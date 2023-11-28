<?php
require_once '../models/conexion.php';
require_once '../models/usuarioModel.php';
require_once '../models/correoModel.php';
require_once '../assets/adodb5/adodb.inc.php';

$usuarioModel = new UsuarioModel();
$correoModel = new CorreoModel();

if (isset($_POST['opc'])) {
    switch ($_POST['opc']) {
        case 1: //INSERT
            $res = $usuarioModel->insertUsuario(
                $_POST['txtNombre'],
                $_POST['txtPrimerApellido'],
                $_POST['txtSegundoApellido'],
                $_POST['txtTelefono'],
                $_POST['txtDireccion'],
                $_POST['txtUsuario'],
                md5($_POST['txtContrasena']),
                $_POST['txtCorreo'],
                $_POST['txtRol']
            );
            if ($res->fields[0] > 0) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case 2: //UPDATE
            $res = $usuarioModel->updateUsuario(
                $_POST['txtIdUsuario'],
                $_POST['txtNombre'],
                $_POST['txtPrimerApellido'],
                $_POST['txtSegundoApellido'],
                $_POST['txtUsuario'],
                $_POST['txtCorreo'],
                $_POST['txtRol'],
                $_POST['txtDireccion']
            );
            if ($res->fields[0] > 0) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case 3: //DELETE
            $resDelete = $usuarioModel->deleteUsuario($_POST['id_usuario']);
            if ($resDelete) {
                echo $resDelete;
            } else {
                echo $resDelete;
            }
            break;
        case 4: //COMPROBAR USUARIO CON usuario Y contrasena
            $user = $_POST['txtUsuario'];
            $pass = md5($_POST['txtContrasena']);
            $res = $usuarioModel->selectUsuarioUsuario($_POST['txtUsuario'], $pass);

            if ($res->RecordCount() > 0) {
                $_SESSION['id_usuario'] = $res->fields[0];
                $_SESSION['usuario'] = $res->fields[1];
                $_SESSION['usuarioNombre'] = $res->fields[2];
                $_SESSION['rol'] = $res->fields[3];
                echo 1;
            } else {
                echo 0;
                $_SESSION['id_usuario'] = 0;
            }
            break;
        case 11:
            echo login();
            break;
        case 12:
            echo validarInicioSesionIndex();
            break;
        case 13:

            if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3)
                echo administrarProductos();
            break;
        case 15:
            echo getUsuarioTabla($usuarioModel);
            break;
        case 16:
            $tablaPlat = getRol($usuarioModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
        case 17:
            $tablaPlat = getRol($usuarioModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
        case 18: //Validar captcha
            echo validarCaptcha($usuarioModel, $correoModel);
            break;
        case 100:
            session_unset(); // Elimina todas las variables de sesión
            session_destroy(); // Destruye la sesión
            session_start();
            $_SESSION['id_usuario'] = 0;
            echo 1;
            break;
    }
}

// if (isset($_GET['opc'])) {
//     switch ($_GET['opc']) {
//         case 1: //INSERT TO DB
//             $usuario = $_POST['txtUsuario'];
//             $contrasena = $_POST['txtContrasena'];
//             $correo = $_POST['txtCorreo'];
//             $usuarioModel->insertUsuario($usuario, $contrasena, $correo);
//             break;
//         case 2: //UPDATE TO DB
//             $usuarioModel->updateUsuario();
//             break;
//         case 3: //DELETE TO DB
//             echo $_POST['opc'];
//             break;

//         case 4: //SELECT TO DB
//             $usuario = $usuarioModel->selectUsuarioUsuario($_POST['txtUsuario'], md5($_POST['txtContrasena']));

//             if ($usuario->recordCount() > 0) {
//                 $_SESSION['id_usuario'] = $usuario->fields[0];
//                 $_SESSION['usuario'] = $usuario->fields[1];
//                 $_SESSION['usuarioNombre'] = $usuario->fields[2];
//                 $_SESSION['rol'] = $usuario->fields[3];
//                 header('Location: ../views/index.php');

//             } else {
//                 echo 'NO';
//                 $_SESSION['res'] = 'n';
//                 header('Location: ../index.php');
//             }
//             break;
//         case 5:
//             echo 'RES';
//             break;



//     }
// }

function validarInicioSesionIndex()
{
    return $_SESSION['id_usuario'] != 0 ? 'Bienvenido ' . $_SESSION['usuarioNombre'] . ' <button class="btn" onclick="cerrarSesion()">
    <i class="bi bi-box-arrow-left"></i>
</button>' : '<a class="nav-link" href="login.php">Iniciar sesión</a>';
}


function login()
{
    return '
    <!-- Iniciar Sesion Modal -->
    <div class="modal fade" id="iniciarSesion" tabindex="-1" aria-labelledby="agregarCarritoP" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Debe iniciar sesion para poder comprar un articulo...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="iniciarSesionFormP">
                    <input type="hidden" name="opc" value="4">
                        <div class="mb-3">
                            <label for="txtUsuario" class="col-form-label">Usuario:</label>
                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario">
                        </div>
                        <div class="mb-3">
                            <label for="txtContrasena" class="col-form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="txtContrasena" name="txtContrasena">
                        </div>
                        <input onclick="iniciarSesion()" class="btn btn-nuevo-usuario w-100" value="Iniciar Sesión"></input>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="container text-center p-3">
                        <div class=" row">
                            <div class="col">
                                <button onclick="crearCuenta()" class="btn btn-outline-success">Crear
                                    cuenta</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary col" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END INICIAR SESION MODAL -->';
}

function administrarProductos()
{
    return ' <form action="../views/grafica.php" method="POST" class="w-100">
<div class="input-group">
    <input class="form-control btn-nuevo-usuario w-100" type="submit" name="verGrafica"
        id="verGrafica" value="Ver graficas">
</div>
</form>

<form action="../views/crudPlataforma.php" method="POST" class="w-100">
<div class="input-group">
    <input class="form-control btn-nuevo-usuario w-100" type="submit" name="btnCRUDPlataforma"
        id="btnCRUDPlataforma" value="Administrar Productos">
</div>
</form>
';
}


function getUsuarioTabla($usuarioModel)
{
    $usuarios = $usuarioModel->usuariosTabla();
    $res = '';
    while (!$usuarios->EOF) {
        $res .= '<tr>
            <th scope="row">' . $usuarios->fields[0] . '</th>
            <td>' . $usuarios->fields[1] . '</td>
            <td>' . $usuarios->fields[2] . '</td>
            <td>' . $usuarios->fields[3] . '</td>
            <td>' . $usuarios->fields[4] . '</td>
            <td>' . $usuarios->fields[5] . '</td>
            <td>
                <a href="#" class="btn btn-success"
                    onclick="editar( ' . $usuarios->fields[0] . ', \'' . $usuarios->fields[6] . '\', \'' . $usuarios->fields[7] . '\', \'' . $usuarios->fields[8] . '\', \'' . $usuarios->fields[2] . '\', \'' . $usuarios->fields[3] . '\', \'' . $usuarios->fields[10] . '\', \'' . $usuarios->fields[5] . '\')">Editar</a>
            </td>
            <td>
            <button onclick="eliminarUsuario(' . $usuarios->fields[0] . ')" class="btn btn-danger">Eliminar</button>

            </td>
        </tr>';

        $usuarios->MoveNext();
    }
    return $res;
}

function getRol($usuarioModel)
{
    $roles = $usuarioModel->getRol();
    $res = '';
    $res .= '<select name="txtRol" id="txtRol">
    <option value="0">Selecciona un rol</option>';
    while (!$roles->EOF) {
        $res .= '<option value="' . $roles->fields[0] . '">' . $roles->fields[1] . '</option>';
        $roles->MoveNext();
    }
    $res .= '</select>';
    return $res;
}



// CLAVE DE SITIO
// 6Lc9bBopAAAAAJYYcuNjDSKPXDTJIadgNUywIl4r
// 
//CLAVE SECRETA
//6Lc9bBopAAAAAI324VSOLpJqzue58PE_GHZqd3r8
function validarCaptcha($usuarioModel, $correoModel)
{
    $res = "";
    $errors = array();

    $captcha = $_POST['g-recaptcha-response'];
    $secreteKey = "6Lc9bBopAAAAAI324VSOLpJqzue58PE_GHZqd3r8";

    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreteKey&response=$captcha");

    $atributos = json_decode($respuesta, TRUE);

    if (!isset($_POST['txtNombre']) || empty($_POST['txtNombre'])) {
        $errors[] = "El campo nombre es obligatorio";
    }
    if (!isset($_POST['txtPrimerApellido']) || empty($_POST['txtPrimerApellido'])) {
        $errors[] = "El campo primer apellido es obligatorio";
    }
    if (!isset($_POST['txtTelefono']) || empty($_POST['txtTelefono'])) {
        $errors[] = "El campo telefono es obligatorio";
    }
    if (!isset($_POST['txtDireccion']) || empty($_POST['txtDireccion'])) {
        $errors[] = "El campo dirección es obligatorio";
    }
    if (!isset($_POST['txtUsuario']) || empty($_POST['txtUsuario'])) {
        $errors[] = "El campo usuario es obligatorio";
    }
    if (!isset($_POST['txtContrasena']) || empty($_POST['txtContrasena'])) {
        $errors[] = "El campo contraseña es obligatorio";
    }
    if (!isset($_POST['txtSegundoApellido']) || empty($_POST['txtSegundoApellido'])) {
        $segundo = "";
    } else {
        $segundo = $_POST['txtSegundoApellido'];
    }
    if (!isset($_POST['txtCorreo']) || empty($_POST['txtCorreo'])) {
        $errors[] = "El campo correo es obligatorio";
    } else {
        $email = $_POST['txtCorreo']; // Reemplaza esto con el correo que deseas validar

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = true;
        } else {
            $errors[] = "Correo electronico invalido";
        }
    }

    if (!$atributos['success']) {
        $errors[] = "El captcha es obligatorio";
    }


    if (count($errors) > 0) {
        foreach ($errors as $error) {
            $res .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>' . $error . '!</strong>  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
            // $res .= '<div class= "alert alert-danger" role = "alert" ></div> <br>';
        }
        return $res;
    } else {
        if ($email) {
            // AQUI VA EL CODIGO DE CREAR USUARIO
            $res = $usuarioModel->insertUsuario(
                $_POST['txtNombre'],
                $_POST['txtPrimerApellido'],
                $segundo,
                $_POST['txtTelefono'],
                $_POST['txtDireccion'],
                $_POST['txtUsuario'],
                md5($_POST['txtContrasena']),
                $_POST['txtCorreo'],
                2
            );
            if ($res->fields[0] > 0) {
                // Ejemplo de uso:
                if (
                    $correoModel->mandarCorreo($_POST['txtCorreo'], $_POST['txtNombre'] . ' ' . $_POST['txtPrimerApellido'], 'Bienvenido a Plataformas Carrillo', '')
                    == 1
                ) {
                    $user = $_POST['txtUsuario'];
                    $pass = md5($_POST['txtContrasena']);
                    $res = $usuarioModel->selectUsuarioUsuario($_POST['txtUsuario'], $pass);

                    if ($res->RecordCount() > 0) {
                        $_SESSION['id_usuario'] = $res->fields[0];
                        $_SESSION['usuario'] = $res->fields[1];
                        $_SESSION['usuarioNombre'] = $res->fields[2];
                        $_SESSION['rol'] = $res->fields[3];
                        echo 1;
                    } else {
                        echo 0;
                        $_SESSION['id_usuario'] = 0;
                    }
                }

            } else {
                echo '<div div class= "alert alert-danger" role = "alert" >No se pudo crear el usuario (Puede que tu correo o usuario ya esten en uso)</div>';
            }
        }
    }


    // if (isset($_POST['g-recaptcha-response'])) {
    // } else {
    //     echo '<div class= "alert alert-success" role = "alert" >Por favor completa el re-Captcha</div>';
    // }
}

?>
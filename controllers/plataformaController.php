<?php
require_once '../models/conexion.php';
require_once '../models/plataformaModel.php';
require_once '../assets/adodb5/adodb.inc.php';

$plataformaModel = new PlataformaModel();
$resul = "";
// POST
// plataformasSlider = 11 
if (isset($_POST["opc"])) {
    switch ($_POST['opc']) {
        case 1: //INSERT TO DB
            if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {

                $imagen = basename($_FILES["file"]["name"]);
                $modelo = $_POST['txtModelo'];
                $descripcion = $_POST['txtDescripcion'];
                $id_marca = $_POST['marcas'];
                $id_tipo = $_POST['tipos'];
                $cantidad = $_POST['txtCantidad'];
                $precio = $_POST['txtPrecio'];
                $costo = $_POST['txtCosto'];
                $reorden = $_POST['txtReorden'];

                $queryRes = $plataformaModel->insertPlataforma($modelo, $descripcion, $id_marca, $imagen, $id_tipo, $cantidad, $precio, $costo, $reorden);

                if ($queryRes > 0) {
                    $plataforma = $plataformaModel->ultimoModelo();
                    $imgNum = $plataforma->fields[0];
                    if ($imgNum > 0) {
                        $uploadDir = '../assets/images/plataformas/' . $imgNum;
                        if (!file_exists($uploadDir)) {
                            if (mkdir($uploadDir, 0777, true)) {
                                echo "La carpeta $uploadDir ha sido creada con éxito.";
                            } else {
                                echo "No se pudo crear la carpeta $uploadDir.";
                            }
                        } else {
                            echo "La carpeta $uploadDir ya existe.";
                        }


                        // $uploadDir = $uploadDir . "/"; // Directorio donde se guardarán las imágenes
                        $uploadFile = $uploadDir . '/' . $imagen;

                        // Verifica si el archivo es una imagen válida
                        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                        $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");

                        if (in_array($imageFileType, $allowedExtensions)) {
                            // Mueve el archivo al directorio de carga
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                                echo "La imagen se ha subido con éxito.";
                                if ($queryRes > 0) {
                                    $_SESSION['insertPlataforma'] = '<div class= "alert alert-success" role = "alert" >Se agrego con exito</div>';
                                    header("Location: ../views/crudPlataforma.php");
                                } else {
                                    $_SESSION['insertPlataforma'] = '<div class= "alert alert-warning" role = "alert" >No se pudo agregar: ' . $queryRes . '</div>';
                                    $queryRes = $plataformaModel->deletePlataforma($imagen);
                                    header("Location: ../views/crudPlataforma.php");
                                }
                            } else {
                                echo "Error al subir la imagen.";
                                $queryRes = $plataformaModel->deletePlataforma($imagen);
                            }
                        } else {
                            $_SESSION['insertPlataforma'] = '<div class= "alert alert-danger" role = "alert" >Archivo no compatible</div>';
                            $queryRes = $plataformaModel->deletePlataforma($imagen);
                            header("Location: ../views/crudPlataforma.php");

                        }
                    }
                } else {
                    echo -1;
                }

            } else {
                $_SESSION['insertPlataforma'] = '<div class= "alert alert-warning" role = "alert" >Seleccione un archivo</div>';
                header("Location: ../views/crudPlataforma.php");
                //echo "No se ha seleccionado ningún archivo.";
            }
            break;
        case 2:
            $resDelete = $plataformaModel->deletePlataforma($_POST['id_modelo']);
            if ($resDelete) {
                echo $resDelete;
            } else {
                echo $resDelete;
            }
            break;
        case 6:
            if (isset($_FILES["file"]) && !empty($_FILES["file"]["name"])) {
                $uploadDir = "../assets/images/plataformas/" . $_POST['txtIdModelo'] . "/"; // Directorio donde se guardarán las imágenes
                $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);
                $imagen = basename($_FILES["file"]["name"]);
                // Verifica si el archivo es una imagen válida
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedExtensions = array("jpg", "jpeg", "png", "gif");

                if (in_array($imageFileType, $allowedExtensions)) {
                    // Mueve el archivo al directorio de carga
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                        echo "La imagen se ha subido con éxito.";

                        $id_modelo = $_POST['txtIdModelo'];
                        $modelo = $_POST['txtModelo'];
                        $descripcion = $_POST['txtDescripcion'];
                        $id_marca = $_POST['marcas'];
                        $id_tipo = $_POST['tipos'];
                        $cantidad = $_POST['txtCantidad'];
                        $precio = $_POST['txtPrecio'];
                        $costo = $_POST['txtCosto'];

                        $queryRes = $plataformaModel->updatePlataforma($id_modelo, $modelo, $descripcion, $id_marca, $imagen, $id_tipo, $cantidad, $precio, $costo);

                        if ($queryRes !== false) {
                            $_SESSION['actualizarPlataforma'] = '<div div class= "alert alert-success" role = "alert" >Se actualizo con exito</div>';
                        } else {
                            $_SESSION['actualizarPlataforma'] = '<div div class= "alert alert-success" role = "alert" >No se pudo actualizar</div>';
                        }
                        header('Location: ../views/crudPlataforma.php');
                    } else {
                        echo 'no se cargo la imagen';
                    }
                } else {
                    echo "Solo se permiten archivos de imagen (jpg, jpeg, png, gif).";
                }

            } else {
                echo "No se ha seleccionado ningún archivo.";
                $id_modelo = $_POST['txtIdModelo'];
                $modelo = $_POST['txtModelo'];
                $descripcion = $_POST['txtDescripcion'];
                $id_marca = $_POST['marcas'];
                $id_tipo = $_POST['tipos'];
                $cantidad = $_POST['txtCantidad'];
                $precio = $_POST['txtPrecio'];
                $costo = $_POST['txtCosto'];

                $plataformaImagen = $plataformaModel->selectIdPlataforma($id_modelo);

                $imagen = $plataformaImagen->fields[4];

                $queryRes = $plataformaModel->updatePlataforma($id_modelo, $modelo, $descripcion, $id_marca, $imagen, $id_tipo, $cantidad, $precio, $costo);


                if ($queryRes !== false) {
                    $_SESSION['actualizarPlataforma'] = '<div div class= "alert alert-success" role = "alert" >Se actualizo con exito</div>';
                } else {
                    $_SESSION['actualizarPlataforma'] = '<div div class= "alert alert-success" role = "alert" >No se pudo actualizar</div>';
                }
                header('Location: ../views/crudPlataforma.php');
            }

            break;
        case 11:
            echo plataformasSlider($plataformaModel);
            break;
        case 12:
            echo getCardsPlataformasIndex($plataformaModel);
            break;
        case 13:
            echo getCardsPlataformas($plataformaModel);
            break;
        case 14:
            echo mostrarFormCarrito();
            break;
        case 15:
            $tablaPlat = getPlataformasTabla($plataformaModel);
            if ($tablaPlat != '') {
                echo getPlataformasTabla($plataformaModel);
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
        case 16:
            $tablaPlat = getMarcas($plataformaModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
        case 17:
            $tablaPlat = getTipos($plataformaModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;

        case 18:
            $tablaPlat = getMarcas($plataformaModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
        case 19:
            $tablaPlat = getTipos($plataformaModel);
            if ($tablaPlat != '') {
                echo $tablaPlat;
            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
    }
}

function getPlataformasTabla($plataformaModel)
{
    $plataformas = $plataformaModel->getAllPlataformasTabla();
    $res = '';
    while (!$plataformas->EOF) {
        $res .= '<tr>
            <th scope="row">' . $plataformas->fields[0] . '</th>
            <td>' . $plataformas->fields[1] . '</td>
            <td>' . $plataformas->fields[9] . '</td>
            <td>' . $plataformas->fields[10] . '</td>
            <td>' . $plataformas->fields[6] . '</td>
            <td>' . $plataformas->fields[11] . '</td>
            <td>' . $plataformas->fields[7] . '</td>
            <td>' . $plataformas->fields[8] . '</td>
            <td>  <a target="_blank" href="../assets/images/plataformas/' . $plataformas->fields[0] . '/' . $plataformas->fields[4] . '">' . $plataformas->fields[4] . '</a></td>
            <td>' . $plataformas->fields[2] . '</td>
            <td>
                <a href="#" class="btn btn-success"
                    onclick="editar( ' . $plataformas->fields[0] . ', \'' . $plataformas->fields[1] . '\', \'' . $plataformas->fields[3] . '\', \'' . $plataformas->fields[5] . '\', \'' . $plataformas->fields[6] . '\', \'' . $plataformas->fields[7] . '\', \'' . $plataformas->fields[8] . '\', \'' . $plataformas->fields[4] . '\', \'' . $plataformas->fields[2] . '\')">Editar</a>
            </td>
            <td>
            <button onclick="eliminarPlataforma(' . $plataformas->fields[0] . ')" class="btn btn-danger">Eliminar</button>

            </td>
        </tr>';

        $plataformas->MoveNext();
    }
    return $res;
}


function getCardsPlataformas($plataformaModel)
{
    $plataformas = $plataformaModel->getAllPlataformasCards();
    $res = '';
    while (!$plataformas->EOF) {
        $res .= '<div class="col-md-4 col-sm-6 cards">
        <div class="box17">
            <img class="pic-1" src="../assets/images/plataformas/' . $plataformas->fields[1] . '/' . $plataformas->fields[5] . '">
            <ul class="icon">
                <li><a href="../views/plataformaDetalle.php?id=' . $plataformas->fields[1] . '"><i class="fa-solid fa-info"></i></a></li>
            </ul>
            
            <div class="box-content">
                <h3 class="title">' . $plataformas->fields[0] . '</h3>
                <span class="post">Cantidad: ' . $plataformas->fields[2] . '</span>
                <span class="post">' . $plataformas->fields[3] . '</span>
                <span class="post texto-limitado">' . $plataformas->fields[4] . '</span>
            </div>
            
        </div>
        <button href="#" class="btn btn-nuevo-usuario w-100 m-2"
        onclick="addCarrito( ' . $_SESSION['id_usuario'] . ', \'' . $plataformas->fields[1] . '\', \'' . $plataformas->fields[6] . '\')"><i class="fa-sharp fa-solid fa-cart-plus"></i></button>
    </div>';

        $plataformas->MoveNext();
    }
    return $res;
}


function getCardsPlataformasIndex($plataformaModel)
{
    $plataformas = $plataformaModel->getAllPlataformasCardsIndex();
    $res = '';
    while (!$plataformas->EOF) {
        $res .= '<div class="col-md-4 col-sm-6 cards">
        <div class="box17">
            <img class="pic-1" src="../assets/images/plataformas/' . $plataformas->fields[1] . '/' . $plataformas->fields[5] . '">
            <ul class="icon">
                <li><a href="../views/plataformaDetalle.php?id=' . $plataformas->fields[1] . '"><i class="fa-solid fa-info"></i></a></li>
            </ul>
            
            <div class="box-content">
                <h3 class="title">' . $plataformas->fields[0] . '</h3>
                <span class="post">Cantidad: ' . $plataformas->fields[2] . '</span>
                <span class="post">' . $plataformas->fields[3] . '</span>
                <span class="post texto-limitado">' . $plataformas->fields[4] . '</span>
            </div>
            
        </div>

        <a href="#" class="btn btn-nuevo-usuario w-100 m-2"
                    onclick="addCarrito( ' . $_SESSION['id_usuario'] . ', \'' . $plataformas->fields[1] . '\', \'' . $plataformas->fields[6] . '\')"><i class="fa-sharp fa-solid fa-cart-plus"></i></a>
    </div>';

        $plataformas->MoveNext();
    }
    return $res;
}


function infoPlataforma($plataformaModel, $id_modelo)
{
    $plataformas = $plataformaModel->selectPlataforma($id_modelo);
    $res = '';
    if ($plataformas) {
        $res .= '<div class="container p-5">
            <div class="row mt-4">
                <div class="col-lg-4 text-center border-right border-secondery">
                    <div class="tab-content row h-100 d-flex justify-content-center align-items-center" id="myTabContent">
                        <div class="tab-pane fade show active col-lg-12" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <img class="img-fluid"
                                src="../assets/images/plataformas/' . $plataformas->fields[1] . '/' . $plataformas->fields[5] . '" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h5>
                    ' . $plataformas->fields[0] . ' - ' . $plataformas->fields[3] . '
                    </h5>
                    <h3>
                        $' . $plataformas->fields[6] . '
                    </h3>
                    <p>
                        Unidades disponibles: ' . $plataformas->fields[2] . '
                    </p>
                    <p class="pb-2">
                    ' . $plataformas->fields[4] . '
                    </p>
                </div>
            </div>
            <button type="button" class="btn btn-lg btn-nuevo-usuario" data-bs-toggle="modal" data-bs-target="#comprarP">Comprar</button>

            <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#agregarCarrito">Agregar al Carrito</button>
        </div>
        ';

    } else {
        $res = 'No se pudo cargar la info';
    }

    return $res;

}


function getMarcas($plataformaModel)
{
    $marcas = $plataformaModel->getMarcas();
    $res = '';
    $res .= '<select name="marcas" id="marcas">
    <option value="0">Selecciona una marca</option>';
    while (!$marcas->EOF) {
        $res .= '<option value="' . $marcas->fields[0] . '">' . $marcas->fields[1] . '</option>';
        $marcas->MoveNext();
    }
    $res .= '</select>';
    return $res;
}

function getTipos($plataformaModel)
{
    $tipos = $plataformaModel->getTipos();
    $res = '';
    $res .= '<select name="tipos" id="tipos">
    <option value="0">Selecciona un tipo</option>';
    while (!$tipos->EOF) {
        $res .= '<option value="' . $tipos->fields[0] . '">' . $tipos->fields[1] . '</option>';
        $tipos->MoveNext();
    }
    $res .= '</select>';
    return $res;
}

function plataformasSlider($plataformaModel)
{
    $tipos = $plataformaModel->plataformasSlider();
    $res = '';
    $cont = 1;
    while (!$tipos->EOF) {
        if ($cont == 1) {
            $res .= '<div class="carousel-item active">
            <div class="mask flex-center">
                <div class="container">
    
                    <div class="row align-items-center">
                        <div class="col-md-7 col-12 order-md-1 order-2">
                            <h4>' . $tipos->fields[1] . '-' . $tipos->fields[2] . '<br></h4>
                            <p class="d-none d-md-block">' . $tipos->fields[3] . '</p>
                            <a href="plataformas.php">Ver más</a>
                        </div>
                        <div class="col-md-5 col-12 order-md-2 order-1">
                            <img src="../assets/images/plataformas/' . $tipos->fields[0] . '/' . $tipos->fields[4] . '" class="mx-auto"
                                alt="slide">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
            $cont++;
        } else {
            $res .= '<div class="carousel-item">
        <div class="mask flex-center">
            <div class="container">

                <div class="row align-items-center">
                    <div class="col-md-7 col-12 order-md-1 order-2">
                        <h4>' . $tipos->fields[1] . '-' . $tipos->fields[2] . '<br></h4>
                        <p class="d-none d-md-block">' . $tipos->fields[3] . '</p>
                        <a href="plataformas.php">Ver más</a>
                    </div>
                    <div class="col-md-5 col-12 order-md-2 order-1">
                        <img src="../assets/images/plataformas/' . $tipos->fields[0] . '/' . $tipos->fields[4] . '" class="mx-auto"
                            alt="slide">
                    </div>
                </div>
            </div>
        </div>
    </div>';
        }

        $tipos->MoveNext();
    }
    return $res;
}


function mostrarFormCarrito()
{
    return '<!-- AGREGAR AL CARRITO -->
    <div class="modal fade" id="agregarCarritoP" tabindex="-1" aria-labelledby="agregarCarritoP" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar al carrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                
                <form id="agregarCarroForm">
                <!-- OPC -->
                <input type="hidden" id="opc" name="opc" value="1">

                <!-- Modelo -->
                        <input type="hidden" id="txtIdModelo" name="txtIdModelo">
                        <!-- Usuario -->
                        <input type="hidden" id="txtIdUsuario" name="txtIdUsuario">
                        <!-- Precio -->
                        <input type="hidden" id="txtPrecio" name="txtPrecio">
                        <div class="mb-3">
                            <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                            <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                        </div>
                    </form>
                    <button onclick="agregarCarrito()" class="btn btn-nuevo-usuario w-100">Agregar</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary col" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>';
}
?>
<?php
require_once '../models/conexion.php';
require_once '../models/compraModel.php';
require_once '../models/correoModel.php';
require_once '../models/compraDetalleModel.php';
require_once '../assets/adodb5/adodb.inc.php';

$compraModel = new CompraModel();
$compraDetalleModel = new CompraDetalleModel();
$correoModel = new CorreoModel();
$resul = "";

if (isset($_POST["opc"])) {

    switch ($_POST["opc"]) {
        case 1:
            echo verCompra($_POST['primerFecha'], $_POST['segundaFecha'], $compraModel);

            break;
        case 2:
            break;
        case 3:
            break;
        case 4:
            break;
        case 5:
            // echo $_POST['txtIdUsuario'];
            $resQuery = $compraModel->comprarCarrito($_POST['id_usuario']);
            if ($resQuery->fields[0] > 0) {
                $cuerpoMensaje = '';
                $ultimoCompra = $compraModel->compraId($_SESSION['id_usuario'])->fields[0];

                $datosUsuario = $compraModel->infoCompraUser($ultimoCompra);
                $articulosCompra = $compraModel->infoCompraProductos($ultimoCompra);
                if ($ultimoCompra > 0) {
                    $resCorreo = $correoModel->compraCorreo($ultimoCompra);
                    if ($resCorreo == 1) {
                        $resQuery = $compraModel->meterTransaccion($_POST['transaccion'], $_POST['status'], $ultimoCompra);
                        if ($resQuery) {
                            echo 1;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                }
            } else {
                echo 0;
            }
            break;
        case 6:
            echo getCompras($_SESSION['id_usuario'], $compraDetalleModel);
            break;
        case 7:
            break;
    }
}


if (isset($_GET['opc'])) {

    switch ($_GET['opc']) {

        case 1: //COMPRA UNICA
            $id_usuario = $_POST['txtIdUsuario'];
            $id_modelo = $_POST['txtIdModelo'];
            $cantidad = $_POST['txtCantidad'];
            $precio = $_POST['txtPrecio'];
            $descuento = 0.0;

            $queryRes = $compraModel->insertConSelect($id_usuario, $id_modelo, $cantidad, $precio, $descuento);

            if ($queryRes == true) {
                echo 'ENTRO';
                while (!$queryRes->EOF) {
                    if ($campo1 = $queryRes->fields['res'] > 0) {
                        $_SESSION['insertCompra'] = 's';
                        echo 'COMPRA REALIZADA';
                    } else {
                        $_SESSION['insertCompra'] = 'ss';
                        echo 'No hay stock suficiente';
                    }
                    $queryRes->MoveNext();
                }
                header("Location: ../views/plataformaDetalle.php?id=" . $id_modelo);

            } else {
                $_SESSION['insertCompra'] = 'nr';
                header("Location: ../views/plataformaDetalle.php?id=" . $id_modelo);
                echo 'No se realizo la compra ';
            }
            break;
        case 2: //UPDATE RESTAR CANTIDAD 
            $id_modelo = $_POST['txtIdModelo'];
            $rs = $plataformaModel->selectIdPlataforma($id_modelo);
            $modelo = $rs->fields[1];
            $descripcion = $rs->fields[2];
            $id_marca = $rs->fields[3];
            $imagen = $rs->fields[4];
            $id_tipo = $rs->fields[5];
            $cantidad = $rs->fields[6];
            $precio = $rs->fields[7];
            $costo = $rs->fields[8];

            if ($cantidad >= $_POST['txtCantidad']) {
                echo 'Cantidad POST' . $_POST['txtCantidad'] . '\n';
                echo '$cantidad' . $cantidad;
                $cantidad = $cantidad - $_POST['txtCantidad'];
                echo 'Cantidad restada: ' . $cantidad;

                $queryRes = $plataformaModel->updatePlataforma($id_modelo, $modelo, $descripcion, $id_marca, $imagen, $id_tipo, $cantidad, $precio, $costo);

                if ($queryRes) {
                    $_SESSION['updatePlataforma'] = 's';
                    header("Location: ../views/plataformaDetalle.php?id=" . $id_modelo);
                } else {
                    $_SESSION['updatePlataforma'] = 'n';
                    header("Location: ../views/plataformaDetalle.php?id=" . $id_modelo);

                }
            } else {
                $_SESSION['updatePlataforma'] = 'sin';
                header("Location: ../views/plataformaDetalle.php?id=" . $id_modelo);
                // echo 'Stock insuficiente';
            }
            break;
        case 3: //DELETE TO DB
            $resDelete = $plataformaModel->deletePlataforma($_GET['id']);
            if ($resDelete === true) {
                $_SESSION['deletePlataforma'] = 's';
                header("Location: ../views/crudPlataforma.php");
            } else {
                $_SESSION['deletePlataforma'] = 'n';
                header("Location: ../views/crudPlataforma.php?info= $resDelete");
            }
            break;
        case 4: //SELECT TO DB
            // echo getPlataformas($plataformaModel);
            break;
        case 5: //COMPRA CARRITO
            $resQuery = $compraModel->comprarCarrito($_GET['id']);
            if ($resQuery->fields[0] > 0) {
                $_SESSION['compraCarrito'] = 's';
                header("Location: ../views/carrito.php");
                echo 'SE COMPRARON TODOS LOS PRODUCTO';
            } else {
                $_SESSION['compraCarrito'] = 'n';
                header("Location: ../views/carrito.php");
                echo 'ALGUNOS PRODUCTOS NO SE COMPRARON';
            }
            break;
        case 6:
            if (isset($_POST["Actualizar"])) {

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

                            if ($queryRes) {
                                $_SESSION['modificarPlataforma'] = 's';
                                header("Location: ../views/crudPlataforma.php");
                            } else {
                                $_SESSION['modificarPlataforma'] = 'n';
                                header("Location: ../views/crudPlataforma.php");
                            }
                        } else {
                            echo "Error al subir la imagen.";
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
                    echo $cantidad = $_POST['txtCantidad'];
                    echo $precio = $_POST['txtPrecio'];
                    echo $costo = $_POST['txtCosto'];

                    $plataformaImagen = $plataformaModel->selectIdPlataforma($id_modelo);

                    $imagen = $plataformaImagen->fields[4];

                    $queryRes = $plataformaModel->updatePlataforma($id_modelo, $modelo, $descripcion, $id_marca, $imagen, $id_tipo, $cantidad, $precio, $costo);
                    if ($queryRes) {
                        $_SESSION['modificarPlataforma'] = 's';
                        header("Location: ../views/crudPlataforma.php");
                    } else {
                        $_SESSION['modificarPlataforma'] = 'n';
                        header("Location: ../views/crudPlataforma.php");
                    }
                }

            } else {
                echo 'NO SE DIO EN ACTUALIZAR';
            }

            break;
        case 7:
            break;
        case 10: //OBTIENE LA INFO DE UNA PLATAFORMA EN ESPECIAL
            $id_modelo = $_GET['id'];
            $resul = infoPlataforma($plataformaModel, $id_modelo);
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
            <td>' . $plataformas->fields[6] . '</td>
            <td>' . $plataformas->fields[7] . '</td>
            <td>' . $plataformas->fields[8] . '</td>
            <td>  <a href="../assets/images/plataformas/' . $plataformas->fields[0] . '/' . $plataformas->fields[4] . '">' . $plataformas->fields[4] . '</a></td>
            <td>' . $plataformas->fields[2] . '</td>
            <td>
                <a href="#" class="btn btn-success"
                    onclick="editar( ' . $plataformas->fields[0] . ', \'' . $plataformas->fields[1] . '\', \'' . $plataformas->fields[3] . '\', \'' . $plataformas->fields[5] . '\', \'' . $plataformas->fields[6] . '\', \'' . $plataformas->fields[7] . '\', \'' . $plataformas->fields[8] . '\', \'' . $plataformas->fields[4] . '\', \'' . $plataformas->fields[2] . '\')">Editar</a>
            </td>
            <td>
            <a href="../controllers/plataformaController.php?opc=3&id=' . $plataformas->fields[0] . '" class="btn btn-danger">Eliminar</a>

            </td>
        </tr>';

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

function getCompras($id_usuario, $compraDetalleModel)
{
    /**
     * id_compra, nombre, fecha
     */
    $compras = $compraDetalleModel->selectCompra($id_usuario);
    $res = '';
    while (!$compras->EOF) {
        $res .= '<tr>
            <th scope="row">' . $compras->fields[0] . '</th>
            <td>' . $compras->fields[1] . '</td>
            <td>' . $compras->fields[2] . '</td>
            <td>
            <form action="../controllers/pdfController.php" method="post">
            <input type="hidden" id="opc" name="opc" value="1">
            <input type="hidden" id="id_usuario" name="id_usuario" value="' . $_SESSION['id_usuario'] . '">
            <input type="hidden" id="id_compra" name="id_compra" value="' . $compras->fields[0] . '">
            
            <button class="btn btn-secondary" type="submit"><i class="bi bi-download"></i></button>
  </form>
            </td>
        </tr>';

        $compras->MoveNext();
    }
    return $res;
}


function verCompra($primerFecha, $segundaFecha, $compraModel)
{
    $datos = array();
    $compras = $compraModel->obtenerComprasFecha($primerFecha, $segundaFecha);
    $datos[] = array('Modelo', 'Cantidad');

    while (!$compras->EOF) {
        $datos[] = array($compras->fields[1], (int) $compras->fields[2]);
        $compras->MoveNext();
    }


    return json_encode($datos);
}
?>
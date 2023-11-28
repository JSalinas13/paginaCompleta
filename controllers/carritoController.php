<?php
require_once '../models/conexion.php';
require_once '../models/carritoModel.php';
require_once '../assets/adodb5/adodb.inc.php';

$carritoModel = new CarritoModel();

if (isset($_POST['opc'])) {
    switch ($_POST['opc']) {
        case 1: //INSERT CARRITO
            $id_usuario = $_POST['txtIdUsuario'];
            $id_modelo = $_POST['txtIdModelo'];
            $cantidad = $_POST['txtCantidad'];
            $fecha = date("Y-m-d");
            $precio = $_POST['txtPrecio'];
            $descuento = 0.0;
            $queryResult = $carritoModel->insertCarrito($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);
            if ($queryResult !== false) {
                if ($queryResult->fields[0] == 1 || $queryResult->fields[0] == 2) {
                    echo 1;
                } else if ($queryResult->fields[0] == 3) {
                    echo 3;
                } else {
                    echo 0;
                }
            }

            break;
        case 2: //ELIMINAR ARTICULO DE CARRITO
            $resDelete = $carritoModel->deleteCarrito($_POST['id_carrito']);
            if ($resDelete > 0) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case 3:
            $id_carrito = $_POST['txtIdCarrito'];
            $id_usuario = $_POST['txtIdUsuario'];
            $id_modelo = $_POST['txtIdModelo'];
            $cantidad = $_POST['txtCantidad'];
            $fecha = $_POST['txtFecha'];
            $precio = $_POST['txtPrecio'];
            $descuento = $_POST['txtDescuento'];
            $resQuery = $carritoModel->updateCarrito($id_carrito, $id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);

            if ($resQuery === false) {
                echo 0;
            } else {
                echo 1;
            }

            break;
        case 4:
            // //INSERT CARRITO GALERIA
            // $id_usuario = $_POST['txtIdUsuario'];
            // $id_modelo = $_POST['txtIdModelo'];
            // $cantidad = $_POST['txtCantidad'];
            // $fecha = date("Y-m-d");
            // $precio = $_POST['txtPrecio'];
            // $descuento = 0.0;
            // $queryResult = $carritoModel->insertCarrito($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);
            // if ($queryResult) {
            //     if ($queryResult->fields[0] == 3) {
            //         echo 3;
            //     } else if ($queryResult->fields[0] > 0 && $queryResult->fields[0] < 3) {
            //         echo 1;
            //     }
            // } else {
            //     echo 0;
            // }

            break;
        case 5:
            break;
        case 6:
            break;
        case 20:
            $id_usuario = $_POST['id_Usuario'];
            $articulos = $carritoModel->contarArticulos($id_usuario);
            echo $articulos->fields[0];
            break;
        case 21:
            echo getCarritoTabla($carritoModel);
            break;
        case 22:

            $totalCarrito = totalCarrito($carritoModel, $_SESSION['id_usuario']);
            if ($totalCarrito != '') {
                // $_SESSION['totalCarrito'] = $totalCarrito;

                echo $totalCarrito;

            } else {
                echo '<tr> Sin resultados... </tr>';
            }
            break;
    }
}

// if (isset($_GET['opc'])) {
//     switch ($_GET['opc']) {

//         case 1: //INSERT DESDE PLATAFORMA DETALLE
//             $id_usuario = $_POST['txtIdUsuario'];
//             $id_modelo = $_POST['txtIdModelo'];
//             $cantidad = $_POST['txtCantidad'];
//             $fecha = date("Y-m-d");
//             $precio = $_POST['txtPrecio'];
//             $descuento = 0.0;
//             $queryResult = $carritoModel->insertCarrito($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);
//             if ($queryResult) {
//                 echo 'SE AGREGO AL CARRITO';
//                 $_SESSION['insertCarrito'] = 's';
//                 header('Location: ../views/plataformaDetalle.php?id=' . $id_modelo);
//             } else {
//                 echo 'NO SE PUDO AGREGAR AL CARRITO';
//                 $_SESSION['insertCarrito'] = 'n';
//                 header('Location: ../views/plataformaDetalle.php?id=' . $id_modelo);
//             }
//             break;
//         case 2: //UPDATE TO DB
//             $id_carrito = $_POST['txtIdCarrito'];
//             $id_usuario = $_POST['txtIdUsuario'];
//             $id_modelo = $_POST['txtIdModelo'];
//             $cantidad = $_POST['txtCantidad'];
//             $fecha = $_POST['txtFecha'];
//             $precio = $_POST['txtPrecio'];
//             $descuento = $_POST['txtDescuento'];
//             $resQuery = $carritoModel->updateCarrito($id_carrito, $id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);

//             if ($resQuery) {
//                 $_SESSION['updateCarrito'] = 's';
//                 header("Location: ../views/carrito.php");
//             } else {
//                 $_SESSION['updateCarrito'] = 'n';
//                 header("Location: ../views/carrito.php");
//                 echo 'NO SE ACTUALIZO';
//             }
//             break;
//         case 3: //DELETE TO DB
//             $resDelete = $carritoModel->deleteCarrito($_GET['id']);
//             if ($resDelete) {
//                 echo 'SE ELIMINO';
//                 $_SESSION['deleteCarrito'] = 's';
//                 header("Location: ../views/carrito.php");
//             } else {
//                 echo 'NO SE ELIMINO';
//                 $_SESSION['deleteCarrito'] = 'n';
//                 header("Location: ../views/carrito.php");
//             }
//             break;
//         case 4: //INSERT CARRITO GALERIA
//             $id_usuario = $_POST['txtIdUsuario'];
//             $id_modelo = $_POST['txtIdModelo'];
//             $cantidad = $_POST['txtCantidad'];
//             $fecha = date("Y-m-d");
//             $precio = $_POST['txtPrecio'];
//             $descuento = 0.0;
//             $queryResult = $carritoModel->insertCarrito($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento);
//             if ($queryResult) {
//                 echo 'SE AGREGO AL CARRITO';
//                 $_SESSION['insertCarritoL'] = 's';
//                 header('Location: ../views/plataformas.php');
//             } else {
//                 echo 'NO SE PUDO AGREGAR AL CARRITO';
//                 $_SESSION['insertCarritoL'] = 'n';
//                 header('Location: ../views/plataformas.php');
//             }
//             break;
//         case 5:
//             echo 'RES';
//             break;
//         case 20:
//             $id_usuario = $_POST['id_Usuario'];
//             $articulos = $carritoModel->contarArticulos($id_usuario);
//             echo $articulos->fields[0];
//             break;


//     }
// }

function getCarritoTabla($carritoModel)
{
    $plataformas = $carritoModel->carritoDetalle($_SESSION['id_usuario']);
    $res = '';
    while (!$plataformas->EOF) {
        $res .= '<tr>
            <th scope="row">' . $plataformas->fields[0] . '</th>
            <td>' . $plataformas->fields[9] . '</td>
            <td>' . $plataformas->fields[8] . '</td>
            <td>' . $plataformas->fields[3] . '</td>
            <td>' . $plataformas->fields[5] . '</td>
            <td>' . $plataformas->fields[6] . '</td>
            <td>' . $plataformas->fields[10] . '</td>
            <td>  <a href="../assets/images/plataformas/' . $plataformas->fields[2] . '/' . $plataformas->fields[11] . '"><img src="../assets/images/plataformas/' . $plataformas->fields[2] . '/' . $plataformas->fields[11] . '" alt="imagen" width="200px"></a></td>
            <td>
                <button class="btn btn-success"
                    onclick="editar( ' . $plataformas->fields[0] . ', \'' . $plataformas->fields[1] . '\', \'' . $plataformas->fields[2] . '\', \'' . $plataformas->fields[3] . '\', \'' . $plataformas->fields[4] . '\', \'' . $plataformas->fields[5] . '\', \'' . $plataformas->fields[6] . '\')">Editar</button>
            </td>
            <td>
            <button onclick="eliminarArticulo(' . $plataformas->fields[0] . ')" class="btn btn-danger">Eliminar</button>

            </td>
        </tr>';

        $plataformas->MoveNext();
    }
    return $res;
}


function getCardsPlataformas($plataformaModel)
{
    $plataformas = $plataformaModel->getAllPlataformas();
    $res = '';
    while (!$plataformas->EOF) {
        $res .= '<div class="col-md-4 col-sm-6 cards">
                    <div class="box17">
                        <img class="pic-1" src="../assets/images/plataformas/' . $plataformas->fields[5] . '">
                        <ul class="icon">
                            <li><a href="#"><i class="bi bi-info-lg"></i></a></li>
                        </ul>
                        <div class="box-content">
                            <h3 class="title">' . $plataformas->fields[0] . '</h3>
                            <span class="post">Disponibles: ' . $plataformas->fields[2] . '</span>
                            <span class="post">' . $plataformas->fields[3] . '</span>
                            <span class="post">' . $plataformas->fields[4] . '</span>
                        </div>
                    </div>
                </div>';

        $plataformas->MoveNext();
    }
    return $res;
}


function totalCarrito($carritoModel, $id_usuario)
{
    $totalCarrito = $carritoModel->totalCarrito($id_usuario);
    if ($totalCarrito) {
        return $totalCarrito->fields[0];
    } else {
        return '';
    }
}
?>
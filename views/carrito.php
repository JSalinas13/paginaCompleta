<?php
require_once '../controllers/carritoController.php';
$carritoModel = new CarritoModel();
if (isset($_SESSION['usuarioNombre']) && !empty($_SESSION['usuarioNombre'])) {
    $_SESSION['totalCarrito'] = totalCarrito($carritoModel, $_SESSION['id_usuario']);
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plataformas carrillo | Carrito</title>

        <!-- CARDS CSS BOOTSTRAP -->

        <!-- BOOTSTRAP CSS 4.6 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/cards.css">
        <link rel="stylesheet" href="../assets/css/styles.css">

        <!-- BOOTSTRAP ICONS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- SCRIPTS -->
        <script src="https://kit.fontawesome.com/c5171c7f74.js" crossorigin="anonymous"></script>



        <script src="../assets/js/jquery-3.7.1.min.js"></script>

        <script>
            function recargarTablaCarrito() {
                $.ajax({
                    url: '../controllers/carritoController.php',
                    type: 'POST',
                    data: {
                        opc: 21,
                    },
                    success: function (data) {
                        $("#getCarritoTabla").html(data);
                        // alert('No. de articulos en el carro: ' + data)
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                    }
                });
            }
            function editar(Id, Usuario, Modelo, Cantidad, Fecha, Precio, Descuento) {
                document.getElementById('txtIdCarrito').value = Id;
                document.getElementById('txtIdUsuario').value = Usuario;
                document.getElementById('txtIdModelo').value = Modelo;
                document.getElementById('txtCantidad').value = Cantidad;
                document.getElementById('txtFecha').value = Fecha;
                document.getElementById('txtPrecio').value = Precio;
                document.getElementById('txtDescuento').value = Descuento;

                $('#editarCarrito').modal('show');
            }

            function editarCarrito() {
                var form = $('#editarCarritoForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/carritoController.php",
                    data: form,
                    success: function (data) {
                        // alert('Hola ' + data);
                        if (data > 0) {
                            recargarTablaCarrito();
                            $('#editarCarrito').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se actualizo con exito</div>');
                            recargarArticulosCarrito();
                            btnPago();
                        } else {
                            $('#editarCarrito').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-warning" role = "alert" >No fue posible actualizar</div>');
                            recargarArticulosCarrito();
                            btnPago();
                        }

                    },
                    error: function (error) {
                        console.log("Hubo un error al realizar la solicitud: ", error);
                    }
                });

            }

            function recargarArticulosCarrito() {
                $.ajax({
                    url: '../controllers/carritoController.php',
                    type: 'POST',
                    data: {
                        opc: 20,
                        id_Usuario: <?= trim($_SESSION['id_usuario']) ?>
                    },
                    success: function (data) {
                        $("#articulosCarritoCarrito").html(data);
                        // alert('No. de articulos en el carro: ' + data)
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                    }
                });
            }
            function insertPlataforma() {
                $('#insertPlataforma').modal('show');
            }

            function eliminarArticulo(id_carrito) {
                // alert(id_carrito)
                $.ajax({
                    url: '../controllers/carritoController.php',
                    type: 'POST',
                    data: {
                        opc: 2,
                        id_carrito: id_carrito
                    },
                    success: function (data) {
                        // alert(data);
                        if (data > 0) {
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se elimino el articulo con exito</div>');
                            recargarTablaCarrito();
                            btnPago();
                        } else {
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >No se pudo eliminar el producto</div>');
                        }
                        recargarArticulosCarrito();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                    }
                });
            }


            function confirmarCompra() {
                document.getElementById('txtIdUsuario').value = <?= $_SESSION['id_usuario'] ?>;
                $('#confirmarCompra').modal('show');
            }

            function btnPago() {
                $.ajax({
                    url: '../controllers/carritoController.php',
                    type: 'POST',
                    data: {
                        opc: 22,
                    },
                    success: function (data) {
                        $("#botonPago").html(data);
                        // alert('No. de articulos en el carro: ' + data)
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                    }
                });
            }

            function pagarCarrito(transaccion, status) {

                var form = $('#confirmarCompraForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/compraController.php",
                    data: {
                        id_usuario: <?= $_SESSION['id_usuario'] ?>,
                        opc: 5,
                        transaccion: transaccion,
                        status: status
                    },
                    success: function (data) {
                        // alert(data);
                        alert(data)
                        if (data > 0) {
                            recargarArticulosCarrito();
                            recargarTablaCarrito();
                            btnPago();
                            $('#confirmarCompra').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se compraron todos los articulos con exito </div>');
                            window.location.href = '../views/compras.php';
                        } else {
                            recargarArticulosCarrito();
                            recargarTablaCarrito();
                            btnPago();
                            $('#confirmarCompra').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-warning" role = "alert" >Algunos articulos no se compraron por falta de stock</div>');
                        }

                    },
                    error: function (error) {
                        console.log("Hubo un error al realizar la solicitud: ", error);
                    }
                });
            }
        </script>

    </head>

    <body>
        <!-- NAVBAR -->
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php"><img src="../assets/images/logo.svg" alt="LOGO"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="plataformas.php">Catalogo de plataformas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="nosotros.php">Nosotros</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contactanos.php">Contactanos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="usuario.php">Usuarios</a>
                            </li>
                        </ul>
                        <span class="navbar-text">
                            <span class="mx-auto">
                                <button type="button" class="btn position-relative">
                                    <a class="btn" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i></a>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark">
                                        <div id="articulosCarritoCarrito"></div>
                                    </span>
                                </button>
                            </span>
                        </span>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div id="resAjax"></div>

                                <div id="resController"></div>
                                <div class="row p-2">
                                    <div class="col-md-2 border-right">
                                        <h4>Carrito</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>
                                                        <div class="form-check-inline">
                                                            Id
                                                        </div>
                                                    </th>
                                                    <th>Usuario</th>
                                                    <th>Modelo</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Descuento</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="getCarritoTabla">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                if (isset($_SESSION['totalCarrito']) && $_SESSION['totalCarrito'] != '') {
                                    echo '
                                    <div class="col-6">
                                    <button onclick="confirmarCompra()" class="btn btn-nuevo-usuario w-100">Pagar</button>
                                </div>
                                <div class="col-6">
                                    TOTAL:
                                    ' . $_SESSION['totalCarrito'] . '
                                </div>
                                    ';
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO MODIFICAR -->
            <div class="modal fade" id="editarCarrito" tabindex="-1" aria-labelledby="editarCarritoLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editarCarritoLabel">Editar plataforma</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- opc 2 -->
                            <form id="editarCarritoForm">
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="opc" name="opc" value="3">
                                    <input type="hidden" class="form-control" id="txtIdCarrito" name="txtIdCarrito">
                                    <input type="hidden" class="form-control" id="txtIdUsuario" name="txtIdUsuario">
                                    <input type="hidden" class="form-control" id="txtIdModelo" name="txtIdModelo">
                                    <input type="hidden" class="form-control" id="txtFecha" name="txtFecha">
                                    <input type="hidden" class="form-control" id="txtPrecio" name="txtPrecio">
                                    <input type="hidden" class="form-control" id="txtDescuento" name="txtDescuento">

                                </div>

                                <div class="mb-3">
                                    <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                                </div>


                            </form>
                            <button onclick="editarCarrito()" class="btn btn-nuevo-usuario w-100">Actualizar</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO MODIFICAR -->
            <div class="modal fade" id="confirmarCompra" tabindex="-1" aria-labelledby="confirmarCompraLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="confirmarCompraLabel">Confirmar compra</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="confirmarCompraForm">
                                <div class="mb-3">


                                </div>

                                <!-- Set up a container element for the button -->
                                <div id="paypal-button-container"></div>



                            </form>
                            <!-- <button onclick="pagarCarrito()" class="btn btn-nuevo-usuario w-100">Confirmar</button> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>





        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
        <!-- Include the PayPal JavaScript SDK -->
        <script
            src="https://www.paypal.com/sdk/js?client-id=AdDIzl9d4NYeg-0spTHBX1JWI0b-XlLCQKug7akwwwKrSmWZ3yrGwwY5UX2PKTdIj6Uao9-7ixxOdZ6V&currency=MXN"></script>


    </body>

    </html>



    <script>
        $(document).ready(function () {
            paypal.Buttons({
                style: {
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: <?= $_SESSION['totalCarrito'] ?>
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    actions.order.capture().then(function (detail) {
                        pagarCarrito(detail.id, detail.status);
                    });
                },
                onCancel: function (data) {
                    console.log(data);
                }
            }).render('#paypal-button-container');

            $.ajax({
                url: '../controllers/carritoController.php',
                type: 'POST',
                data: {
                    opc: 20,
                    id_Usuario: <?= trim($_SESSION['id_usuario']) ?>
                },
                success: function (data) {
                    $("#articulosCarritoCarrito").html(data);
                    // alert('No. de articulos en el carro: ' + data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/carritoController.php',
                type: 'POST',
                data: {
                    opc: 21,
                },
                success: function (data) {
                    $("#getCarritoTabla").html(data);
                    // alert('No. de articulos en el carro: ' + data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/carritoController.php',
                type: 'POST',
                data: {
                    opc: 22,
                },
                success: function (data) {
                    <?php $_SESSION['totalCarrito'] ?>
                    $("#botonPago").html(data);
                    // alert('No. de articulos en el carro: ' + data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
        })
    </script>

    <?php
} else {
    header("Location: login.php");
    exit;
}
?>
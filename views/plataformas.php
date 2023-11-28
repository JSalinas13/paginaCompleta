<?php
// require_once '../controllers/plataformaController.php';
session_start();
$_SESSION['id_usuario'] = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas carrillo | plataformas</title>

    <!-- CARDS CSS BOOTSTRAP -->

    <!-- BOOTSTRAP CSS 4.6 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/cards.css">
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">




    <script>
        // RECARGA EL ICONO DEL CARRITO
        function recargarArticulosCarrit() {
            $.ajax({
                url: '../controllers/carritoController.php',
                type: 'POST',
                data: {
                    opc: 20,
                    id_Usuario: <?= trim($_SESSION['id_usuario']) ?>
                },
                success: function (carrito) {
                    $("#articulosCarrito").html(carrito);
                    // alert('No. de articulos en el carro: ' + data)
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
        }

        function agregarCarrito() {
            var form = $('#agregarCarroForm').serialize();
            $.ajax({
                type: "POST",
                url: "../controllers/carritoController.php",
                data: form,
                success: function (data) {
                    if (data == 2 || data == 1) {
                        recargarArticulosCarrit();
                        $('#agregarCarritoP').modal('hide');
                        $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se agrego al carrito</div>');

                    } else if (data == 3) {
                        $('#agregarCarritoP').modal('hide');
                        $('#resAjax').html('<div div class= "alert alert-warning" role = "alert" >No hay stock suficiente</div>');
                    } else {
                        $('#agregarCarritoP').modal('hide');
                        $('#resAjax').html('<div div class= "alert alert-danger" role = "alert" >No se pudo agregar al carrito</div>');

                    }

                },
                error: function (error) {
                    console.log("Hubo un error al realizar la solicitud: ", error);
                }
            });
        }
        function addCarrito(id_usuario, id_modelo, precio) {
            if (id_usuario > 0) {
                document.getElementById('txtIdModelo').value = id_modelo;
                document.getElementById('txtIdUsuario').value = id_usuario;
                document.getElementById('txtPrecio').value = precio;
                document.getElementById('opc').value = 1;

                $('#agregarCarritoP').modal('show');

            } else {
                $('#iniciarSesion').modal('show');
            }
        }
        function crearCuenta() {
            window.location.href = '../views/crearCuenta.php';
        }

        function iniciarSesion() {
            var form = $('#iniciarSesionFormP').serialize();
            $.ajax({
                type: "POST",
                url: "../controllers/usuarioController.php",
                data: form,
                success: function (data) {
                    if (data > 0) {
                        location.reload(true);
                        $('#iniciarSesion').modal('hide');
                    } else {
                        $('#iniciarSesion').modal('hide');
                        $('#resAjax').html('<div div class= "alert alert-danger" role = "alert" >Usuario o Contraseña incorrectos</div></div>');
                    }

                },
                error: function (error) {
                    console.log("Hubo un error al realizar la solicitud: ", error);
                }
            });

        }

        function cerrarSesion() {
            $.ajax({
                type: "POST",
                url: "../controllers/usuarioController.php",
                data: {
                    opc: 100
                },
                success: function (data) {
                    location.reload(true);
                },
                error: function (error) {
                    console.log("Hubo un error al cerrar sesion: ", error);
                }
            });

        }
    </script>
</head>

<body>

    <header>
        <!-- BARRA DE NAVEGACION -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand  " href="../views/index.php"> <img height="100" src="../assets/images/logo.svg"
                    alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="plataformas.php">Catalogo de plataformas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nosotros.php">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactanos.php">Contactanos</a>
                    </li>
                    <?php
                    if (isset($_SESSION['usuarioNombre'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="compras.php">Compras</a>
                        </li>
                        <?php
                        if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="usuario.php">Usuarios</a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>

                <span class="mx-auto">
                    <button type="button" class="btn position-relative">
                        <a class="btn" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i></a>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark">
                            <div id="articulosCarrito"></div>
                        </span>
                    </button>

                </span>
                <span class="navbar-text" id="validarUsuario">


                </span>



            </div>
        </nav>
    </header>


    <!-- CARDS -->
    <main>
        <div class="container">
            <div class="row w-100">
                <div id="administrarProductos">

                </div>

            </div>
        </div>
        <section class="cards-plataformas">
            <div class="container mt-40">
                <h3 class="text-center">Plataformas</h3>
                <div class="row w-100" id="resAjax"></div>
                <div class="col">
                    <?php
                    if (isset($_SESSION['insertCarritoL'])) {
                        switch ($_SESSION['insertCarritoL']) {
                            case 's':
                                echo '<div class="alert alert-success" role="alert">
                                                    Se agreo al carrito
                                                </div>';
                                $_SESSION['insertCarritoL'] = '';
                                break;
                            case 'n':
                                echo '<div class="alert alert-success" role="alert">
                                                 no se pudo agrar al carrito
                                                </div>';
                                $_SESSION['insertCarritoL'] = '';
                                break;
                            default:
                                $_SESSION['insertCarritoL'] = '';
                        }
                    }
                    ?>
                </div>
                <div class="row mt-30" id="getCardsPlataformas">
                    <?php
                    // echo getCardsPlataformas($plataformaModel);
                    ?>
                </div>
            </div>
        </section>

        <!-- AGREGAR AL CARRITO -->
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
                            <input type="hidden" id="opc" name="opc">
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
                            <input class="btn btn-nuevo-usuario w-100" value="Agregar"
                                onclick="agregarCarrito()"></input>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary col" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Iniciar Sesion Modal -->
        <div id="loginP">

        </div>

        <!-- END INICIAR SESION MODAL -->

    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!--  -->


    <!-- SCRIPTS -->
    <script src="https://kit.fontawesome.com/c5171c7f74.js" crossorigin="anonymous"></script>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>


<script>
    $(document).ready(function () {
        $.ajax({
            url: '../controllers/plataformaController.php',
            type: 'POST',
            data: {
                opc: 13
            },
            success: function (data) {
                $("#getCardsPlataformas").html(data);
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
                opc: 20,
                id_Usuario: <?= trim($_SESSION['id_usuario']) ?>
            },
            success: function (carrito) {
                $("#articulosCarrito").html(carrito);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error: ' + textStatus);
            }
        });

        $.ajax({
            url: '../controllers/usuarioController.php',
            type: 'POST',
            data: {
                opc: 11
            },
            success: function (data) {
                if (<?= $_SESSION['id_usuario'] ?> == 0) {
                    $("#loginP").html(data);
                }

                // alert('No. de articulos en el carro: ' + data)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error: ' + textStatus);
            }
        });

        $.ajax({
            url: '../controllers/usuarioController.php',
            type: 'POST',
            data: {
                opc: 13
            },
            success: function (data) {
                if (<?= isset($_SESSION['rol']) ? $_SESSION['rol'] : 0 ?> == 3) {
                    $("#administrarProductos").html(data);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error: ' + textStatus);
            }
        });
        $.ajax({
            url: '../controllers/usuarioController.php',
            type: 'POST',
            data: {
                opc: 12
            },
            success: function (data) {

                $("#validarUsuario").html(data);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error: ' + textStatus);
            }
        });
    })
</script>
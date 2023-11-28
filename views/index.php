<?php
// require_once '../controllers/plataformaController.php';
session_start();
if (!isset($_SESSION["id_usuario"]) || $_SESSION['id_usuario'] == 0) {
    $_SESSION["id_usuario"] = 0;
    $_SESSION['rol'] = 2;
    // echo 'no existe';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas carrillo | Inicio</title>

    <script src="../assets/js/jquery-3.7.1.min.js"></script>

    <!-- BOOTSTRAP CSS 4.6-->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- CSS FOOTER -->
    <link rel="stylesheet" href="../assets/css/footer.css">

    <!-- ICONS FOOTER -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <link href="https://raw.githubusercontent.com/daneden/animate.css/master/animate.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/slider.css">
    <link rel="stylesheet" href="../assets/css/cards.css">
    <link rel="stylesheet" href="../assets/css/mapa.css">
    <link rel="stylesheet" href="../assets/css/styles.css">




    <script>
        function addCarrito(id_usuario, id_modelo, precio) {
            if (id_usuario > 0) {
                document.getElementById('txtIdModelo').value = id_modelo;
                document.getElementById('txtIdUsuario').value = id_usuario;
                document.getElementById('txtPrecio').value = precio;
                document.getElementById('txtPrecio').value = precio;

                $('#agregarCarritoP').modal('show');

            } else {
                $('#iniciarSesion').modal('show');
            }
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
                        $('#resAjax').html('<div div class= "alert alert-danger" role = "alert" >Usuario o Contraseña incorrectos</div>');
                    }

                },
                error: function (error) {
                    console.log("Hubo un error al realizar la solicitud: ", error);
                }
            });
        }
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
    </script>

</head>

<body>

    <!-- NAVBAR -->
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Inicio</a>
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
                    <?php
                    if (isset($_SESSION['usuarioNombre'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="compras.php">Compras</a>
                        </li>
                        <?php
                        if(isset($_SESSION['rol']) && $_SESSION['rol']==3){
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
                <span class="navbar-text" id="validarInicioSesionIndex">


                </span>



            </div>
        </nav>
    </header>


    <main>
        <!-- SLIDER -->
        <section class="slider">
            <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner" id="plataformasSlider">
                    <?php //echo plataformasSlider($plataformaModel) ?>
                </div>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span
                        class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>
        <!--SLIDER END-->

        <!-- plataformas CARDS -->
        <section class="cards-plataformas m-5">
            <div class="container mt-40">
                <div class="col-12" id="resAjax">
                </div>
                <h3 class="text-center">Plataformas</h3>
                <div class="row mt-30" id="getCardsPlataformasIndex">

                </div>
                <div class="row justify-content-center align-items-center">
                    <a href="../views/plataformas.php" class="btn btn-nuevo-usuario p-2"
                        style="font-size: 25px; width: 50%; ">Ver
                        más</a>
                </div>

            </div>
        </section>
        <!-- plataformas CARDS END -->


        <!-- UBICACIÓN -->
        <section class="ubicacion">
            <!-- contact-section -->
            <div class="contact-map-section">
                <!-- contact-map -->
                <div id="contact-map"></div>
                <!-- /.contact-map -->
                <!-- contact-info -->
                <div class="contact-section">
                    <div class="container">
                        <div class="row">
                            <!-- contact-block -->
                            <div class="d-none d-md-block col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 nopr nopl">
                                <div class="card contact-block">
                                    <div class="card-body">
                                        <h3 class="mb0">Plataformas carrillo</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- /.contact-block -->
                            <div class="d-none d-xl-block d-xxl-none col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12 ">
                            </div>
                            <!-- contact-block -->
                            <div
                                class="d-none d-xl-block d-xxl-none col-xl-4 col-lg-4 col-md-6 col-sm-4 col-12 nopr nopl">
                                <div class="card contact-block">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 ">
                                                <div class="contact-icon"><i class="far fa-clock"></i></div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 col-12 ">
                                                <h6 class="card-title">Horario:</h6>
                                                <p class="contact-small-text">Domingo <span class="float-right">
                                                        Cerrado</span></p>
                                                <p class="contact-small-text"> Lun - Vie<span class="float-right">08:00
                                                        - 05:00 Pm</span></p>
                                                <p class="contact-small-text"> Sabado <span class="float-right"> 08:00 -
                                                        02:00 Pm</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.contact-block -->
                            <!-- contact-block -->
                            <div
                                class="d-none d-xl-block d-xxl-none col-xl-4 col-lg-4 col-md-6 col-sm-4 col-12 nopr nopl">
                                <div class="card contact-block">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 ">
                                            <div class="contact-icon mt20"><i class="far fa-map"></i></div>
                                        </div>
                                        <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 col-12 ">
                                            <div class="card-body">
                                                <h6 class="card-title">Información</h6>
                                                <p class="contact-small-text">Av. Aeropuerto 116, 38116 Gto.</p>
                                                <p class="contact-small-text">jesus.salinas@plataformascarrillo.com</p>
                                                <p class="contact-small-text">+52 - 461 2722826</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.contact-block -->
                            <!-- contact-block -->
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-4 col-12 nopr nopl ">
                                <div class="card contact-block contact-btn">
                                    <div class="card-body">
                                        <a href="contactanos.php" class="btn btn-default btn-block">Contactanos</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.contact-block -->
                        </div>

                    </div>
                </div>
                <!-- /.contact-info -->
            </div>
        </section>
        <!-- UBICACIÓN END -->

        <!-- FOOTER -->
        <section id="footer">
            <div class="container">
                <div class="row text-center text-xs-center text-sm-left text-md-left">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h5>Plataformas carrillo</h5>
                        <ul class="list-unstyled quick-links">
                            <li><a href="index.php"><i class="fa fa-angle-double-right"></i>Inicio</a></li>
                            <li><a href="plataformas.php"><i class="fa fa-angle-double-right"></i>Catalogo de
                                    plataformas</a></li>
                            <li><a href="nosotros.php"><i class="fa fa-angle-double-right"></i>Nosotros</a></li>
                            <li><a href="contactanos.php"><i class="fa fa-angle-double-right"></i>Contactanos</a>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">

                        <p class="h6">© Copyright.<a class="text-green ml-2" href="https://www.sunlimetech.com"
                                target="_blank"></a></p>
                    </div>
                    <hr>
                </div>
            </div>
        </section>
        <!-- FOOTER END -->
    </main>


    <!-- Agregar Carritp Modal -->
    <div id="agregarCarrito">

    </div>
    <!-- Iniciar Sesion Modal -->
    <div id="loginP">

    </div>


    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script>
        function initMap() {
            var uluru = {
                lat: 20.5181028,
                lng: -100.8947046
            };
            var map = new google.maps.Map(document.getElementById('contact-map'), {
                zoom: 16,
                center: uluru,
                scrollwheel: false
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                icon: 'https://easetemplate.com/free-website-templates/kitchen/images/map_marker.png'

            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZib4Lvp0g1L8eskVBFJ0SEbnENB6cJ-g&callback=initMap">
        </script>


    <!-- SCRIPTS -->
    <script src="../assets/js/slider.js"></script>


    <!-- SCRIPTS -->
    <script src="https://kit.fontawesome.com/c5171c7f74.js" crossorigin="anonymous"></script>

</body>

</html>


<script>
    $(document).ready(function () {
        $.ajax({
            url: '../controllers/plataformaController.php',
            type: 'POST',
            data: {
                opc: 11
            },
            success: function (data) {
                $("#plataformasSlider").html(data);
                // alert('No. de articulos en el carro: ' + data)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error: ' + textStatus);
            }
        });

        $.ajax({
            url: '../controllers/plataformaController.php',
            type: 'POST',
            data: {
                opc: 12
            },
            success: function (data) {
                $("#getCardsPlataformasIndex").html(data);
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
                opc: 12
            },
            success: function (data) {
                $("#validarInicioSesionIndex").html(data);
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
            url: '../controllers/plataformaController.php',
            type: 'POST',
            data: {
                opc: 14
            },
            success: function (data) {

                $("#agregarCarrito").html(data);

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
    })
</script>
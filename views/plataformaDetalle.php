<?php
require_once '../controllers/plataformaController.php';
if (isset($_SESSION['usuarioNombre'])) {
    ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plataformas carrillo | plataformas</title>

        <!-- CARDS CSS BOOTSTRAP -->

        <!-- BOOTSTRAP CSS 4.6 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/cards.css">
        <link rel="stylesheet" href="../assets/css/styles.css">

        <!-- BOOTSTRAP ICONS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- CSS FOOTER -->
        <!-- F<link rel="stylesheet" href="/assets/css/footer.css"> -->

        <!-- ICONS FOOTER -->

        <!-- CSS PLATAFORMA DETALLE -->
        <link rel="stylesheet" href="../assets/css/plataformaDetalle.css">

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
                </div>
            </nav>
        </header>


        <!-- CARDS -->
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-2 text-white mt-2 text-center text-capitalize">

                        <?php
                        if (isset($_SESSION['insertCompra'])) {
                            switch ($_SESSION['insertCompra']) {
                                case 's':
                                    echo ' <div class="alert alert-success" role="alert">
                                                Se realizo la compra con exito
                                            </div>';
                                    $_SESSION['insertCompra'] = '';
                                    break;
                                case 'nr':
                                    echo ' <div class="alert alert-danger" role="alert">
                                                 No realizo la compra con exito
                                            </div>';
                                    $_SESSION['insertCompra'] = '';
                                    break;
                                case 'ss':
                                    echo ' <div class="alert alert-warning" role="alert">
                                                No hay stock suficiente
                                            </div>';
                                    $_SESSION['insertCompra'] = '';
                                    break;
                                default:
                                    echo 'NINGUNO';
                            }
                        } else {
                            echo 'NO ISSET';
                        } ?>
                    </div>
                </div>
            </div>
            <?php
            echo infoPlataforma($plataformaModel, $_GET['id']);
            ?>


            <!-- Compra directa -->
            <?php
            $plataforma = $plataformaModel->selectIdPlataforma($_GET['id']);
            ?>
            <div class="modal fade" id="comprarP" tabindex="-1" aria-labelledby="comprarP" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Realizar compra</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../controllers/compraController.php?opc=1" method="post">
                                <!-- Modelo -->
                                <input type="hidden" id="txtIdModelo" name="txtIdModelo" value="<?= $_GET['id'] ?>">
                                <!-- Usuario -->
                                <input type="hidden" id="txtIdUsuario" name="txtIdUsuario"
                                    value="<?= $_SESSION['id_usuario'] ?>">
                                <!-- Precio -->
                                <input type="hidden" id="txtPrecio" name="txtPrecio" value="<?= $plataforma->fields[7] ?>">
                                <div class="mb-3">
                                    <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                                </div>
                                <input type="submit" class="btn btn-nuevo-usuario w-100" value="Comprar"></input>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary col" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AGREGAR AL CARRITO -->
            <div class="modal fade" id="agregarCarrito" tabindex="-1" aria-labelledby="agregarCarrito" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar al carrito</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../controllers/carritoController.php?opc=1" method="post">
                                <!-- Modelo -->
                                <input type="hidden" id="txtIdModelo" name="txtIdModelo" value="<?= $_GET['id'] ?>">
                                <!-- Usuario -->
                                <input type="hidden" id="txtIdUsuario" name="txtIdUsuario"
                                    value="<?= $_SESSION['id_usuario'] ?>">
                                <!-- Precio -->
                                <input type="hidden" id="txtPrecio" name="txtPrecio" value="<?= $plataforma->fields[7] ?>">
                                <div class="mb-3">
                                    <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                                </div>
                                <input type="submit" class="btn btn-nuevo-usuario w-100" value="Agregar"></input>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary col" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!--  -->


        <!-- SCRIPTS -->
        <script src="https://kit.fontawesome.com/c5171c7f74.js" crossorigin="anonymous"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- BOOTSTRAP CSS 4.6 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

    </body>

    </html>


    <script>
        $(document).ready(function () {
            $.ajax({
                url: '../controllers/carritoController.php?opc=20',
                type: 'POST',
                data: {
                    id_Usuario: <?= trim($_SESSION['id_usuario']) ?>
                },
                success: function (data) {
                    $("#articulosCarrito").html(data);
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
    header("Location: index.php");
    exit;
}
?>
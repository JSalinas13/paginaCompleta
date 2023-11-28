<?php
// require_once '../controllers/carritoController.php';

session_start();
if (isset($_SESSION['usuarioNombre'])) {
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
            // function verCompra(id_compra, id_usuario) {
            //     $.ajax({
            //         url: '../controllers/pdfController.php',
            //         type: 'POST',
            //         data: {
            //             opc: 1,
            //             id_compra: id_compra,
            //             id_usuario: id_usuario
            //         },
            //         success: function (data) {
            //             // alert("Hola: " + data);
            //             // $("#resAjax").html(data);
            //             // // alert('No. de articulos en el carro: ' + data)
            //         },
            //         error: function (jqXHR, textStatus, errorThrown) {
            //             console.error('Error: ' + textStatus);
            //         }
            //     });
            // }

            // function verCompra(id_compra, id_usuario) {
            //     $.ajax({
            //         url: '../controllers/pdfController.php',
            //         type: 'POST',
            //         data: {
            //             opc: 1,
            //             id_compra: id_compra,
            //             id_usuario: id_usuario
            //         },
            //         xhrFields: {
            //             responseType: 'blob' // Especificar el tipo de respuesta como blob (para archivos)
            //         },
            //         success: function (data) {
            //             var blob = new Blob([data], { type: 'application/pdf' });
            //             var url = window.URL.createObjectURL(blob);
            //             window.open(url); // Abrir el PDF en una nueva ventana o pestaña
            //         },
            //         error: function (jqXHR, textStatus, errorThrown) {
            //             console.error('Error: ' + textStatus);
            //         }
            //     });
            // }

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
                                        <h4>Compras</h4>
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
                                                    <th>fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody id="getCompraTabla">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>





        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>



    </body>

    </html>


    <script>
        $(document).ready(function () {
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
                url: '../controllers/compraController.php',
                type: 'POST',
                data: {
                    opc: 6
                },
                success: function (data) {
                    $("#getCompraTabla").html(data);
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
    header("Location: index.php");
    exit;
}
?>
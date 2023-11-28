<?php
   require_once '../controllers/carritoController.php';
if (isset($_SESSION['usuarioNombre']) && isset($_SESSION['rol']) && $_SESSION['rol'] == 3) {
    if (isset($_POST['verGrafica'])) {
        ?>
        <?php
     
        if (isset($_SESSION['usuarioNombre'])) {
            ?>
            <!DOCTYPE html>
            <html lang="es">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Plataformas carrillo | Grafica</title>

                <script src="../assets/js/jquery-3.7.1.min.js"></script>

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



                <!-- Incluir la librería de Google Charts -->
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                </script>


                <!-- <br />
<b>Warning</b>:  Undefined array key "prinerFecha" in <b>C:\xampp\htdocs\prograweb\Ajax\controllers\compraController.php</b> on line <b>15</b><br />
<br />
<b>Warning</b>:  Array to string conversion in <b>C:\xampp\htdocs\prograweb\Ajax\controllers\compraController.php</b> on line <b>15</b><br />
Array -->
                <script>
                    function verVentas() {
                        var form = $('#verCompraForm').serialize();
                        $.ajax({
                            type: "POST",
                            url: "../controllers/compraController.php",
                            data: form,
                            success: function (data) {
                                alert(data);
                                var datos = JSON.parse(data);
                                // Carga la librería de Google Charts
                                google.charts.load('current', { 'packages': ['corechart'] });
                                google.charts.setOnLoadCallback(function () {
                                    dibujarGrafico(datos); // Llama a la función para dibujar el gráfico
                                });
                            },
                            error: function (error) {
                                console.log("Hubo un error al realizar la solicitud: ", error);
                            }
                        });
                    }

                    function dibujarGrafico(datos) {
                        // Crea una tabla de datos de Google Charts
                        var data = google.visualization.arrayToDataTable(datos);

                        // Opciones del gráfico
                        var options = {
                            title: 'Productos vendidos'
                        };

                        // Crea el gráfico de barras
                        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
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
                                                <h4>Ver ventas</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 table-responsive">
                                                <form id="verCompraForm">
                                                    <input type="hidden" name="opc" id="opc" value="1">
                                                    <div class="mb-3">
                                                        <label for="primerFecha">Fecha de inicio:</label>
                                                        <input type="date" id="primerFecha" name="primerFecha">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="segundaFecha">Fecha de fin:</label>
                                                        <input type="date" id="segundaFecha" name="segundaFecha">
                                                    </div>
                                                </form>
                                                <div class="col">
                                                    <button class="btn btn-success w-50" onclick="verVentas()">Enviar</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="chart_div" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>

                </main>

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
    <?php
    }
} else {
    header('Location: index.php');
}
?>
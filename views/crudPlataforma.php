<?php
// require_once '../controllers/plataformaController.php';
session_start();
if (isset($_SESSION['usuarioNombre']) && isset($_SESSION['rol']) && $_SESSION['rol'] == 3) {

    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plataformas carrillo | Administrar</title>

        <!-- BOOTSTRAP CSS 4.6-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/styles.css">

        <!-- BOOTSTRAP ICONS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <script src="https://kit.fontawesome.com/c5171c7f74.js" crossorigin="anonymous"></script>
        <script src="../assets/js/jquery-3.7.1.min.js"></script>


        <script>
            function editar(Id, Modelo, Marca, Tipo, Cantidad, Precio, Costo, Imagen, Descripcion) {
                document.getElementById('marcas').selectedIndex = Marca;
                document.getElementById('tipos').selectedIndex = Tipo;
                document.getElementById('txtIdModelo').value = Id;
                document.getElementById('txtModelo').value = Modelo;

                document.getElementById('txtCantidad').value = Cantidad;
                document.getElementById('txtPrecio').value = Precio;
                document.getElementById('txtCosto').value = Costo;
                document.getElementById('txtDescripcion').value = Descripcion;

                $('#exampleModal').modal('show');
            }

            function eliminarPlataforma(v_id_modelo) {
                $.ajax({
                    type: "POST",
                    url: "../controllers/plataformaController.php",
                    data: {
                        opc: 2,
                        id_modelo: v_id_modelo
                    },
                    success: function (data) {
                        $('#resAjax').html(data);
                        recargarTabla();
                    },
                    error: function (error) {
                        console.log("Hubo un error al realizar la solicitud: ", error);
                    }
                });
            }

            function insertPlataforma() {
                $('#insertPlataforma').modal('show');
            }

            function agregarCarrito() {
                var form = $('#insertarPlataformaForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/plataformaController.php",
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

            function recargarTabla() {
                $.ajax({
                    url: '../controllers/plataformaController.php',
                    type: 'POST',
                    data: {
                        opc: 15,
                    },
                    success: function (data) {
                        $("#cargarPlataformasTable").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
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
                </div>
            </nav>
        </header>

        <main>
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">

                                <?php
                                if (isset($_SESSION['actualizarPlataforma'])) {
                                    echo $_SESSION['actualizarPlataforma'];
                                    $_SESSION['actualizarPlataforma'] = '';
                                }
                                if (isset($_SESSION['insertPlataforma'])) {
                                    echo $_SESSION['insertPlataforma'];
                                    $_SESSION['insertPlataforma'] = '';
                                }
                                ?>
                                <div id="resAjax"></div>

                                <div class="row p-2">
                                    <div class="col-md-2 border-right">
                                        <h4>Plataformas</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-nuevo-usuario"
                                            onclick="insertPlataforma()">Nueva plataforma</button>
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
                                                    <th>Modelo</th>
                                                    <th>Marca</th>
                                                    <th>Tipo</th>
                                                    <th>Cantidad</th>
                                                    <th>Re-orden</th>
                                                    <th>Precio</th>
                                                    <th>Costo</th>
                                                    <th>URL Imagen</th>
                                                    <th>Descripcion</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cargarPlataformasTable">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>







            <!-- FORMULARIO MODIFICAR -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editat plataforma</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="../controllers/plataformaController.php"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <!-- <label for="txtIdModelo" class="col-form-label">Id Modelo:</label> -->
                                    <input type="hidden" class="form-control" id="txtIdModelo" name="txtIdModelo">
                                    <input type="hidden" class="form-control" id="opc" name="opc" value="6">
                                </div>
                                <div class="mb-3">
                                    <label for="txtModelo" class="col-form-label">Modelo:</label>
                                    <input type="text" class="form-control" id="txtModelo" name="txtModelo">
                                </div>
                                <div class="mb-3" id="marcasSelect">
                                </div>
                                <div class="mb-3" id="tiposSelect">
                                </div>
                                <div class="mb-3">
                                    <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                                </div>
                                <div class="mb-3">
                                    <label for="txtPrecio" class="col-form-label">Precio:</label>
                                    <input type="text" class="form-control" id="txtPrecio" name="txtPrecio">
                                </div>
                                <div class="mb-3">
                                    <label for="txtCosto" class="col-form-label">Costo:</label>
                                    <input type="text" class="form-control" id="txtCosto" name="txtCosto">
                                </div>
                                <div class="mb-3">
                                    <label for="file">Selecciona una imagen:</label>
                                    <input type="file" name="file" id="file">
                                </div>

                                <div class="mb-3">
                                    <label for="txtDescripcion" class="col-form-label">Descripcion:</label>
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
                                </div>
                                <button class="btn  btn-nuevo-usuario w-100" name="Actualizar">Actualizar</button>
                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INSERTAR NUEVA PLATAFORMA -->
            <div class="modal fade" id="insertPlataforma" tabindex="-1" aria-labelledby="insertPlataformaLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="insertPlataformaLabel">Nueva plataforma
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form action="../controllers/plataformaController.php" method="POST"
                                enctype="multipart/form-data">
                                <!-- OPC -->
                                <input type="hidden" id="opc" name="opc" value="1">

                                <div class="mb-3">
                                    <label for="txtModelo" class="col-form-label">Modelo:</label>
                                    <input type="text" class="form-control" id="txtModelo" name="txtModelo">
                                </div>
                                <div class="mb-3" id="marcasSelect2">
                                </div>
                                <div class="mb-3" id="tiposSelect2">
                                </div>
                                <div class="mb-3">
                                    <label for="txtCantidad" class="col-form-label">Cantidad:</label>
                                    <input type="text" class="form-control" id="txtCantidad" name="txtCantidad">
                                </div>
                                <div class="mb-3">
                                    <label for="txtReorden" class="col-form-label">Reorden:</label>
                                    <input type="text" class="form-control" id="txtReorden" name="txtReorden">
                                </div>
                                <div class="mb-3">
                                    <label for="txtPrecio" class="col-form-label">Precio:</label>
                                    <input type="text" class="form-control" id="txtPrecio" name="txtPrecio">
                                </div>
                                <div class="mb-3">
                                    <label for="txtCosto" class="col-form-label">Costo:</label>
                                    <input type="text" class="form-control" id="txtCosto" name="txtCosto">
                                </div>
                                <div class="mb-3">
                                    <label for="file">Selecciona una imagen:</label>
                                    <input type="file" name="file" id="file" required>
                                </div>

                                <div class="mb-3">
                                    <label for="txtDescripcion" class="col-form-label">Descripcion:</label>
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
                                </div>

                                <input type="submit" class="btn  btn-nuevo-usuario w-100" name="Nuevo" value="Registrar">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>



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
            $.ajax({
                url: '../controllers/plataformaController.php',
                type: 'POST',
                data: {
                    opc: 15,
                },
                success: function (data) {
                    $("#cargarPlataformasTable").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/plataformaController.php',
                type: 'POST',
                data: {
                    opc: 16,
                },
                success: function (data) {
                    $("#marcasSelect").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/plataformaController.php',
                type: 'POST',
                data: {
                    opc: 17,
                },
                success: function (data) {
                    $("#tiposSelect").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });


            $.ajax({
                url: '../controllers/plataformaController.php',
                type: 'POST',
                data: {
                    opc: 18,
                },
                success: function (data) {
                    $("#marcasSelect2").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });

            $.ajax({
                url: '../controllers/plataformaController.php',
                type: 'POST',
                data: {
                    opc: 19,
                },
                success: function (data) {
                    $("#tiposSelect2").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
        })
    </script>

    <?php
}else{
    header('Location: index.php');
} ?>
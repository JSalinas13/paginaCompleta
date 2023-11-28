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
        <title>Plataformas carrillo | Usuarios</title>

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
            function editar(Id, nombre, primerApellido, segundoApellido, usuario, correo, rol, direccion) {
                document.getElementById('txtRol').selectedIndex = rol;
                document.getElementById('txtIdUsuario').value = Id;
                document.getElementById('txtNombre').value = nombre;
                document.getElementById('txtPrimerApellido').value = primerApellido;
                document.getElementById('txtSegundoApellido').value = segundoApellido;

                document.getElementById('txtUsuario').value = usuario;
                document.getElementById('txtCorreo').value = correo;
                document.getElementById('txtDireccion').value = direccion;

                $('#exampleModal').modal('show');
            }

            function actualizarUsuario() {
                var form = $('#actualizarUsuarioForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/usuarioController.php",
                    data: form,
                    success: function (data) {
                        alert(data);
                        if (data != 0) {
                            recargarTabla();
                            $('#exampleModal').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se modifico el usuario con exito</div>');

                        } else {
                            $('#exampleModal').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-danger" role = "alert" >No se pudo actualizar el usuario</div>');
                        }

                    },
                    error: function (error) {
                        console.log("Hubo un error al realizar la solicitud: ", error);
                    }
                });
            }

            function eliminarUsuario(v_id_usuario) {
                $.ajax({
                    type: "POST",
                    url: "../controllers/usuarioController.php",
                    data: {
                        opc: 3,
                        id_usuario: v_id_usuario
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

            function insertUsuario() {
                $('#insertPlataforma').modal('show');
            }

            function recargarTabla() {
                $.ajax({
                    url: '../controllers/usuarioController.php',
                    type: 'POST',
                    data: {
                        opc: 15,
                    },
                    success: function (data) {
                        $("#cargarUsuariosTable").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('Error: ' + textStatus);
                    }
                });
            }

            function crearUsuario() {
                var form = $('#crearUsuarioForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/usuarioController.php",
                    data: form,
                    success: function (data) {
                        // alert(data);
                        if (data != 0) {
                            recargarTabla();
                            $('#insertPlataforma').modal('hide');
                            $('#resAjax').html('<div div class= "alert alert-success" role = "alert" >Se creo el usuario con exito</div>');

                        } else {
                            $('#resAjax').html('<div div class= "alert alert-danger" role = "alert" >No se pudo crear el usuario (Puede que tu correo o usuario ya esten en uso)</div>');
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
                        <li class="nav-item">
                            <a class="nav-link" href="usuario.php">Usuarios</a>
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
                                        <h4>Usuarios</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-nuevo-usuario" onclick="insertUsuario()">Nuevo
                                            usuario</button>
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
                                                    <th>Nombre</th>
                                                    <th>Usuario</th>
                                                    <th>Correo</th>
                                                    <th>Rol</th>
                                                    <th>Direccion</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cargarUsuariosTable">

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
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Usuario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="actualizarUsuarioForm">
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="txtIdUsuario" name="txtIdUsuario">
                                    <input type="hidden" class="form-control" id="opc" name="opc" value="2">
                                </div>
                                <div class="mb-3">
                                    <label for="txtNombre" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="txtPrimerApellido" class=" col-form-label">Primer apellido:</label>
                                    <input type="text" class="form-control" id="txtPrimerApellido" name="txtPrimerApellido"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="txtSegundoApellido" class=" col-form-label">Segundo apellido:</label>
                                    <input type="text" class="form-control" id="txtSegundoApellido"
                                        name="txtSegundoApellido">
                                </div>

                                <div class="mb-3">
                                    <label for="txtUsuario" class="col-form-label">Usuario:</label>
                                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" required>
                                </div>

                                <div class="mb-3">
                                    <label for="txtCorreo" class="col-form-label">Correo:</label>
                                    <input type="email" class="form-control" id="txtCorreo" name="txtCorreo" required>
                                </div>

                                <div class="mb-3" id="rolSelect">

                                </div>

                                <div class="mb-3">
                                    <label for="txtDireccion" class="col-form-label">Direecion:</label>
                                    <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" required>
                                </div>
                            </form>
                            <button onclick="actualizarUsuario()" class="btn  btn-nuevo-usuario w-100"
                                name="Actualizar">Actualizar</button>


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
                            <h1 class="modal-title fs-5" id="insertPlataformaLabel">Nuevo usuario
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form id="crearUsuarioForm">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <input type="hidden" class="form-control" id="opc" name="opc" value="1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtNombre" class="col-form-label">Nombre:</label>
                                            <input type="text" class="form-control" id="txtNombre" name="txtNombre"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtPrimerApellido" class=" col-form-label">Primer apellido:</label>
                                            <input type="text" class="form-control" id="txtPrimerApellido"
                                                name="txtPrimerApellido" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="txtSegundoApellido" class=" col-form-label">Segundo
                                                apellido:</label>
                                            <input type="text" class="form-control" id="txtSegundoApellido"
                                                name="txtSegundoApellido">
                                        </div>

                                        <div class="mb-3">
                                            <label for="txtTelefono" class="col-form-label">Telefono:</label>
                                            <input type="text" class="form-control" id="txtTelefono" name="txtTelefono"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="txtDireccion" class="col-form-label">Direecion:</label>
                                            <input type="text" class="form-control" id="txtDireccion" name="txtDireccion"
                                                required>
                                        </div>


                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="txtUsuario" class="col-form-label">Usuario:</label>
                                            <input type="text" class="form-control" id="txtUsuario" name="txtUsuario"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="txtContrasena" class="col-form-label">Contraseña:</label>
                                            <input type="password" class="form-control" id="txtContrasena"
                                                name="txtContrasena" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="txtCorreo" class="col-form-label">Correo:</label>
                                            <input type="email" class="form-control" id="txtCorreo" name="txtCorreo"
                                                required>
                                        </div>

                                        <div class="mb-3" id="rolSelect2">

                                        </div>
                                    </div>
                                </div>


                            </form>
                            <button onclick="crearUsuario()" class="btn  btn-nuevo-usuario w-100" name="Actualizar">Crear
                                usuario</button>

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
                url: '../controllers/usuarioController.php',
                type: 'POST',
                data: {
                    opc: 15,
                },
                success: function (data) {
                    $("#cargarUsuariosTable").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/usuarioController.php',
                type: 'POST',
                data: {
                    opc: 16,
                },
                success: function (data) {
                    $("#rolSelect").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });
            $.ajax({
                url: '../controllers/usuarioController.php',
                type: 'POST',
                data: {
                    opc: 17,
                },
                success: function (data) {
                    $("#rolSelect2").html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error: ' + textStatus);
                }
            });

        })
    </script>

    <?php
} else {
    header('Location: index.php');
} ?>
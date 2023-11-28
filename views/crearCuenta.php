<?php
session_start();
// require_once("../controller/controller.php");

// echo "Existw: " . isset($_POST['usuarioNombre']) === true ? 1 : 0;

if (isset($_SESSION["usuarioNombre"])) {
    header("Location:   index.php");
} else {
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Plataformas carrillo | Crear cuenta</title>

        <script src="../assets/js/jquery-3.7.1.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

        <!-- BOOST -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

        <!-- BOOTSTRAP ICONS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- CSS FOOTER -->
        <!-- <link rel="stylesheet" href="../assets/css/login.css"> -->

        <!-- ICONS FOOTER -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />


        <!-- CSS -->
        <link rel="stylesheet" href="../assets/css/styles.css">


        <script>
            function crearUsuario() {
                var form = $('#crearUsuarioForm').serialize();
                $.ajax({
                    type: "POST",
                    url: "../controllers/usuarioController.php",
                    data: form,
                    success: function (data) {
                        // alert(data);
                        if (data == 1) {
                            window.location.href = "../views/login.php";
                        } else {
                            $('#resAjax').html(data);
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

        <main>
            <div class="container">
                <div class="m-2" id="resAjax">

                </div>
                <form class="m-5" id="crearUsuarioForm">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="opc" name="opc" value="18">
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
                                <label for="txtSegundoApellido" class=" col-form-label">Segundo
                                    apellido:</label>
                                <input type="text" class="form-control" id="txtSegundoApellido" name="txtSegundoApellido">
                            </div>

                            <div class="mb-3">
                                <label for="txtTelefono" class="col-form-label">Telefono:</label>
                                <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" required>
                            </div>

                            <div class="mb-3">
                                <label for="txtDireccion" class="col-form-label">Direecion:</label>
                                <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" required>
                            </div>


                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="txtUsuario" class="col-form-label">Usuario:</label>
                                <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" required>
                            </div>

                            <div class="mb-3">
                                <label for="txtContrasena" class="col-form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="txtContrasena" name="txtContrasena"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="txtCorreo" class="col-form-label">Correo:</label>
                                <input type="email" class="form-control" id="txtCorreo" name="txtCorreo" required>
                            </div>
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6Lc9bBopAAAAAJYYcuNjDSKPXDTJIadgNUywIl4r"></div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mb-3">
                    <button onclick="crearUsuario()" class="btn  btn-nuevo-usuario w-100" name="Actualizar">Crear
                        cuenta</button>
                </div>
            </div>


        </main>



        <!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> -->


    </body>

    </html>
    <?php
}
?>


<script>
    $(document).ready(function () {
        $('#crearUsuarioModal').modal('show');
    })
</script>
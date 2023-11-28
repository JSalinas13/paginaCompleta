<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataformas carrillo | Nosotros</title>

    <script src="../assets/js/jquery-3.7.1.min.js"></script>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="plataformas.php">Catalogo de plataformas</a>
                    </li>
                    <li class="nav-item active">
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
                <span class="navbar-text" id="validarInicioSesionIndex">


                </span>



            </div>
        </nav>
    </header>

    <main>
        <section>
            <div class="container p-4">
                <div class="shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                    <div class="row">
                        <div class="col-12 col-md-12 col-sm-12 col-lg-6">
                            <div class="img-about">
                                <img src="../assets/images/V1.1 copia@0,25x_2.svg" class="img-about">
                            </div>
                        </div>
                        <div class="col col-md-6 col-sm-12">
                            <h2 class="align-middle">
                                Acerca de <span style="color: #fe5b29;">nosotros</span>
                            </h2>
                            <div class="texto-about">
                                <p>
                                    En Plataformas Carrillo, estamos comprometidos con proporcionar soluciones de
                                    alquiler confiables y eficientes para satisfacer las necesidades de nuestros
                                    clientes en el campo de la construcción, la industria y otros sectores relacionados.
                                    Permítanme guiarlos a través de un recorrido por nuestros servicios y los beneficios
                                    que ofrecemos.
                                </p>
                                <p>
                                    Plataformas de elevación: Contamos con una flota diversa de plataformas de
                                    elevación, como elevadores telescópicos, elevadores de tijera y plataformas
                                    articuladas, que permiten acceder a áreas de trabajo elevadas de manera segura y
                                    eficiente
                                </p>
                                <p>
                                    Montacargas: Proporcionamos montacargas de diferentes capacidades y especificaciones
                                    para facilitar la manipulación de cargas pesadas y mejorar la eficiencia logística
                                    en los lugares de trabajo.
                                </p>
                                <p>
                                    Generadores: Suministramos generadores de energía confiables y eficientes que
                                    garantizan un suministro constante de electricidad en situaciones donde la red
                                    eléctrica no está disponible o es insuficiente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Mision y vision -->
                    <div class="row p-5">
                        <div class="col">
                            <h2 class="align-middle">
                                <span style="color: #fe5b29;">Misión</span>
                            </h2>

                            <ul>
                                <li>
                                    <p>
                                        Proveer soluciones seguras y flexibles, arrendamiento y mantenimiento de
                                        equipo moderno. Oportunamente y de manera confiable y sequra para
                                        actividades de construcción, mantenimiento e instalaciones especializadas
                                        que promuevan el desarrollo y crecimiento rentable de la empresa y de su
                                        capital humano.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Desarrollar objetivos concretos de crecimiento y la capacidad de evaluar
                                        financieramente todas nuestras decisiones y actividades
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Contar con una flota de plataformas reciente y sin problemas
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Desarrollo del capital humano.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Crear y evaluar nuevas oportunidades de negocio que apoyen a lograr los
                                        objetivos de crecimiento.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Posicionarnos como una empresa líider, proporcionando el mejor
                                        servicio y calidad para nuestros clientes.
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="col content-">
                            <h2 class="align-middle">
                                <span style="color: #fe5b29;">Visión</span>
                            </h2>

                            <p class="text-justify">
                                Ser el proveedor más importante de soluciones estratégicas, seguras y flexibles de
                                arrendamiento y mantenimiento de equipo para los sectores de la construcción,
                                mantenimiento e instalaciones especializadas en México, Consolidarnos como empresa lider
                                capaz de dar soluciones de condicionamiento y adecuación para actividades especializadas
                                y profesionales dentro de los mercados de construcción gobierno, industrial, comercial,
                                habitacional, entre otros. Lograr un crecimiento sostenible y estable, con
                                reconocimiento en seguridad, calidad y confiabilidad para nuestros clientes y
                                proveedores.
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

</body>

</html>


<script>
    $(document).ready(function () {
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
    });
</script>
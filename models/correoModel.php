<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../models/conexion.php';
require_once '../models/usuarioModel.php';
require_once '../models/compraDetalleModel.php';
require_once '../models/compraModel.php';
require_once '../assets/adodb5/adodb.inc.php';

require '../assets/phpMiller/PHPMailer/src/Exception.php';
require '../assets/phpMiller/PHPMailer/src/PHPMailer.php';
require '../assets/phpMiller/PHPMailer/src/SMTP.php';

class CorreoModel
{
    private $mail; // Propiedad para almacenar la instancia de PHPMailer
    private $correoDestinatario;
    private $nombreDestinatario;
    private $asunto;

    public function __construct()
    {
        // Crear una nueva instancia de PHPMailer
        $this->mail = new PHPMailer(true); // Usar true para habilitar excepciones

        // Configurar el servidor SMTP de Gmail
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'jesus.salinas.le.9@gmail.com'; // Reemplazar con tu dirección de correo de Gmail
        $this->mail->Password = 'znytlmeszbklhzuj'; // Reemplazar con la contraseña de tu cuenta de Gmail
        $this->mail->Port = 587; // Puerto SMTP seguro para Gmail: 587
        $this->mail->SMTPSecure = 'tls'; // Usar TLS como protocolo de seguridad
    }

    public function mandarCorreo($correoDestinatario, $nombreDestinatario, $asunto, $cuerpoMensaje)
    {
        try {
            $this->mail->setFrom('jesus.salinas.le.9@gmail.com', 'Jesus Salinas'); // Reemplazar con tu dirección de correo y tu nombre
            $this->mail->addAddress($correoDestinatario, $nombreDestinatario);


            $cuerpoMensaje = '
            <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Plataformas Carrillo</title>

    <style>
        .boton-naranja {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ed591d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .boton-naranja:hover {
            background-color: #ed591d;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <tr>
            <td align="center">
                <h1 style="color: #ed591d;">¡Bienvenido a Plataformas Carrillo!</h1>
                <p style="color: #333333;">Estimado/a ' . $nombreDestinatario . ',</p>
                <p style="color: #333333;">Nos complace enormemente darle la bienvenida como nuevo cliente a nuestra
                    empresa de venta de plataformas de elevación. Nos comprometemos a proporcionarle productos y
                    servicios de la más alta calidad para satisfacer sus necesidades de elevación y movilidad.</p>
                <p style="color: #333333;">Estamos aquí para ayudarle en cada paso del proceso, desde la selección de la
                    plataforma adecuada hasta el soporte postventa. ¡Esperamos poder colaborar juntos!</p>
                <p style="color: #333333;">No dude en contactarnos si tiene alguna consulta o necesidad adicional.
                    Estamos a su disposición para ofrecerle la mejor experiencia con nuestros productos y servicios.</p>
                <p style="color: #333333;">¡Gracias por confiar en nosotros!</p>
                <p style="color: #333333;">Atentamente,</p>
                <p style="color: #ed591d;">Plataformas Carrillo</p>
                <a href="https://plataformascarrillo.com" class="boton-naranja">Visitar!</a>
            </td>
        </tr>
    </table>

</body>

</html>
            ';

            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $cuerpoMensaje;

            if ($this->mail->send()) {
                echo 1;
            } else {
                echo 'Hubo un problema al enviar el correo. Error: ' . $this->mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$this->mail->ErrorInfo}";
        }
    }

    public function compraCorreo($ultimoCompra)
    {
        $articulo = '';
        $total = 0;
        $paypal = '';
        try {

            $compraModel = new CompraModel();

            $infoCompra = $compraModel->infoCompra($ultimoCompra);

            $paypal = $infoCompra->fields[4];

            $asunto = 'Recibo de compra';

            $this->mail->setFrom('jesus.salinas.le.9@gmail.com', 'Jesus Salinas'); // Reemplazar con tu dirección de correo y tu nombre


            $this->mail->addAddress($infoCompra->fields[6], $infoCompra->fields[5]);


            while (!$infoCompra->EOF) {

                $articulo .= '   <tr>
                <td>' . $infoCompra->fields[0] . '</td>
                <td>' . $infoCompra->fields[1] . '</td>
                <td>' . $infoCompra->fields[2] . '</td>
                <td>' . $infoCompra->fields[2] * $infoCompra->fields[1] . '</td>
            </tr>';

                $total += $infoCompra->fields[2] * $infoCompra->fields[1];

                $infoCompra->MoveNext();
            }


            $cuerpoMensaje = '
            <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Plataformas Carrillo</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .boton-naranja {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ed591d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .boton-naranja {
            text-decoration: none;
        }

        .boton-naranja:hover {
            background-color: #ed591d;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div class="container mt-5">
        <h2>Lista de Productos</h2>
        <h4>Id Compra:
            ' . $paypal . '
        </h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                ' . $articulo . '
                <tr>
                    <td>Total: </td>
                    <td>' . $total . '</td>
                </tr>
            </tbody>
        </table>

        <a href="https://plataformascarrillo.com" class="boton-naranja text-decoration-none text-white">Visitar!</a>
    </div>

    <!-- Enlaces a los archivos JavaScript de Bootstrap (opcional, para ciertas funcionalidades) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
            ';

            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto . ': #' . $ultimoCompra;
            $this->mail->Body = $cuerpoMensaje;

            if ($this->mail->send()) {
                return 1;
            } else {
                echo 'Hubo un problema al enviar el correo. Error: ' . $this->mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$this->mail->ErrorInfo}";
        }
    }
}
?>
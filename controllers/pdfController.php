<?php
require_once '../models/conexion.php';
require_once '../models/pdfModel.php';
require_once '../assets/adodb5/adodb.inc.php';
require_once '../models/compraDetalleModel.php';

// Ejemplo de uso de la clase ReciboCompraPDF
$reciboPDF = new ReciboCompraPDF();
$compraDetalleModel = new CompraDetalleModel();


if (isset($_POST['opc'])) {
    switch ($_POST['opc']) {
        case 1:
            echo 'HOLA';
            ob_start();
            $items = array();
            $total = 0;
            $articulos = 0;

            $datos = $compraDetalleModel->selectCompraDetalle($_POST['id_usuario'], $_POST['id_compra']);

            if ($datos->RecordCount() > 0) {
                $datosCliente = array(
                    'nombre' => $datos->fields[3]
                );
                $transaccion = $datos->fields[4];

                while (!$datos->EOF) {
                    $items[] = array($datos->fields[0], $datos->fields[1], $datos->fields[2], $datos->fields[2] * $datos->fields[1]);

                    $total += $datos->fields[2] * $datos->fields[1];
                    $articulos += $datos->fields[1];


                    $datos->MoveNext();
                }

                $reciboPDF->generarRecibo($datosCliente, $items, $total, $articulos,$transaccion);
                $reciboPDF->generarPDF('recibo_compra' . $datosCliente['nombre'] . '.pdf', 'I'); // Mostrar en el navegador
                // $reciboPDF->generarPDF('nombre_archivo.pdf', 'F');
                // O puedes guardar el PDF con $reciboPDF->generarPDF('nombre_archivo.pdf', 'F'); (Guardar en el servidor)
            } else {
                echo 'Sin resultados';
            }
            break;
    }
}

?>
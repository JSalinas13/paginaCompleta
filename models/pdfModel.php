<?php
// Importar la librería TCPDF
require_once('../assets/vendor/tecnickcom/tcpdf/tcpdf.php');

class ReciboCompraPDF
{
    private $pdf;

    public function __construct()
    {
        // Crear una instancia de TCPDF
        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

        // Configurar información del documento
        $this->pdf->SetCreator('Plataformas Carrillo');
        $this->pdf->SetAuthor('Plataformas Carrillo');
        $this->pdf->SetTitle('Recibo de Compra');
        $this->pdf->SetSubject('Recibo de Compra');
        $this->pdf->SetKeywords('Recibo, Compra');
    }

    public function generarRecibo($datosCliente, $items, $total, $articulos, $transaccion)
    {
        // Agregar una página
        $this->pdf->AddPage();

        // Establecer estilos y contenido
        $this->pdf->SetFont('helvetica', '', 12);

        // Logo de la empresa (debes cambiar la ruta a tu logo)
        $this->pdf->Image('../assets/images/logo.png', 10, 10, 20);

        // Título del recibo
        $this->pdf->Cell(0, 10, 'Recibo de Compra', 0, 1, 'C');

        // Información del recibo
        $this->pdf->Ln(5);
        $this->pdf->Cell(50, 5, 'Fecha: ' . date('Y-m-d H:i:s'), 0, 1);
        $this->pdf->Cell(50, 5, 'Número de Recibo: '.$transaccion, 0, 1);
        $this->pdf->Cell(0, 5, '-----------------------------------', 0, 1);

        // Detalles del cliente
        $this->pdf->Ln(5);
        $this->pdf->Cell(0, 5, 'Nombre: ' . $datosCliente['nombre'], 0, 1);
        $this->pdf->Cell(0, 5, 'Artículo(s): ' . $articulos, 0, 1);

        // Detalles de los productos en una tabla
        $this->pdf->Ln(3);
        $header = array('Descripción', 'Cantidad', 'Precio Unitario', 'Subtotal');
        $this->pdf->SetFont('', 'B');
        $this->pdf->SetFillColor(200, 220, 255);
        $this->pdf->SetTextColor(0);
        $this->pdf->SetDrawColor(0);
        $this->pdf->SetLineWidth(0.2);

        $this->pdf->Ln(2);
        $this->pdf->SetFont('', 'B');
        foreach ($header as $col) {
            $this->pdf->Cell(40, 7, $col, 1, 0, 'C', 1);
        }
        $this->pdf->Ln();

        $this->pdf->SetFont('');
        foreach ($items as $row) {
            foreach ($row as $col) {
                $this->pdf->Cell(40, 7, $col, 1);
            }
            $this->pdf->Ln();
        }

        // Total
        $this->pdf->Ln(3);
        $this->pdf->SetFont('helvetica', 'B', 12);
        $this->pdf->Cell(130, 7, 'Total:', 0, 0, 'R');
        $this->pdf->Cell(0, 7, $total, 0, 1);

        // Agradecimiento por la compra
        $this->pdf->Ln(10);
        $this->pdf->SetFont('helvetica', '', 10);
        $this->pdf->Cell(0, 10, 'Gracias por su compra', 0, 1, 'C');
    }

    public function generarPDF($nombreArchivo, $output)
    {
        // Generar el PDF en el navegador o guardar en el servidor
        $this->pdf->Output($nombreArchivo, $output);
    }
}
?>
<?php
// session_start();
class CompraDetalleModel
{
    private $id_compra;
    private $id_modelo;
    private $cantidad;
    private $precio;
    private $descuento;

    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }


    public function insertarCompraDetalle($id_compra, $id_modelo, $cantidad, $precio, $descuento)
    {
        $table = 'compra_detalle';
        $record = array();
        $record['id_compra'] = $id_compra;
        $record['id_modelo'] = $id_modelo;
        $record['cantidad'] = $cantidad;
        $record['precio'] = $precio;
        $record['descuento'] = $descuento;
        $this->db->autoExecute($table, $record, 'INSERT');
        $_SESSION['resCompraDetalle'] = 'insertado';
        header('Location: ../views/usuario.php');

    }

    public function updateCompraDetalle($id_compra, $id_modelo, $cantidad, $precio, $descuento)
    {
        $table = 'compra_detalle';
        $record = array();
        $record['id_compra'] = $id_compra;
        $record['id_modelo'] = $id_modelo;
        $record['cantidad'] = $cantidad;
        $record['precio'] = $precio;
        $record['descuento'] = $descuento;
        $this->db->autoExecute($table, $record, 'UPDATE', 'id_compra=' . $_POST['txtIdCompra'] . ' AND id_modelo =' . $id_modelo);
        $_SESSION['resCompra'] = 'actualizado';
        header('Location: ../views/usuario.php');
    }

    public function deleteCompraDetalle($id_compra, $id_modelo)
    {
        $query = "DELETE FROM compra_detalle WHERE id_compra = " . $id_compra . ' AND id_modelo =' . $id_modelo;
        $rs = $this->db->Execute($query);
        return $rs;
    }

    public function selectCompraDetalleId($id_compra, $id_modelo)
    {
        $query = "SELECT * FROM compra_detalle WHERE id_compra = " . $id_compra . ' AND id_modelo =' . $id_modelo;
        $rs = $this->db->Execute($query);
        return $rs;
    }

    public function selectCompra($id_usuario)
    {
        $query = "SELECT id_compra, CONCAT(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido) AS nombre, fecha
        FROM compra
                 INNER JOIN usuario u on compra.id_usuario = u.id_usuario
                 INNER JOIN persona p on u.id_usuario = p.id_usuario
        WHERE compra.id_usuario = $id_usuario";
        $rs = $this->db->Execute($query);
        return $rs;
    }

    public function selectCompraDetalle($id_usuario, $id_compra)
    {
        $query = "SELECT m.modelo,
        cd.cantidad,
        cd.precio,
        CONCAT(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido) AS nombre,
        transaccion
 FROM compra c
          INNER JOIN compra_detalle cd on c.id_compra = cd.id_compra
          INNER JOIN modelo m on cd.id_modelo = m.id_modelo
          INNER JOIN usuario u on c.id_usuario = u.id_usuario
          INNER JOIN persona p on u.id_usuario = p.id_usuario
 WHERE c.id_usuario = $id_usuario
   AND c.id_compra = $id_compra";
        $rs = $this->db->Execute($query);
        return $rs;
    }

    public function allCompraDetalle()
    {
        $query = "SELECT * FROM compra_detalle";
        $rs = $this->db->Execute($query);
        return $rs;
    }
}

?>
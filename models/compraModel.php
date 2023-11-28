<?php
// session_start();
class CompraModel
{
    private $id_compra;
    private $id_usuario;
    private $fecha;

    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }


    public function insertarCompra($id_usuario, $fecha)
    {
        $table = 'compra';
        $record = array();
        $record['id_usuario'] = $id_usuario;
        $record['fecha'] = $fecha;
        $rs = $this->db->autoExecute($table, $record, 'INSERT');
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        } else {
            $rs = $this->db->Insert_ID();
        }
        echo $rs;
    }

    public function updateCompra($id_compra, $id_usuario, $fecha)
    {
        $table = 'compra';
        $record = array();
        $record['id_compra'] = $id_compra;
        $record['id_usuario'] = $id_usuario;
        $record['fecha'] = $fecha;
        $rs = $this->db->autoExecute($table, $record, 'UPDATE', 'id_compra =' . $_POST['txtIdCompra'] . ' AND id_usuario =' . $id_usuario);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }


    public function meterTransaccion($transaccion, $status, $id_compra)
    {
        $table = 'compra';
        $record = array();
        $record['transaccion'] = $transaccion;
        $rs = $this->db->autoExecute($table, $record, 'UPDATE', 'id_compra =' . $id_compra);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function deleteCompra($id_compra, $id_usuario)
    {
        $query = "DELETE FROM compra WHERE id_compra = " . $id_compra . ' AND id_usuario =' . $id_usuario;
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function insertConSelect($id_usuario, $id_modelo, $cantidad, $precio, $descuento)
    {
        $query = "CALL registrarCompra(?,?,?,?,?)";
        $rs = $this->db->Execute($query, array($id_usuario, $id_modelo, $cantidad, $precio, $descuento));

        if (!$rs) {
            die("Error al ejecutar el procedimiento almacenado de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function selectCompraId($id_compra, $id_usuario)
    {
        $query = "SELECT * FROM compra WHERE id_compra = " . $id_compra . ' AND id_modelo =' . $id_usuario;
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function allCompraDetalle()
    {
        $query = "SELECT * FROM compra";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function comprarCarrito($id_usuario)
    {
        $query = "CALL comprarCarrito(?)";
        $rs = $this->db->Execute($query, array($id_usuario));

        if (!$rs) {
            echo die("Error al ejecutar el procedimiento comprarCarrito: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function compraId($id_usuario)
    {
        $query = "SELECT id_compra FROM compra WHERE id_usuario = $id_usuario ORDER BY 1 DESC LIMIT 1;";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function infoCompraProductos($id_compra)
    {
        $query = "SELECT m.modelo, cd.cantidad, cd.precio, (cd.cantidad * cd.precio) AS subtotal,transaccion
        FROM compra
                 INNER JOIN compra_detalle cd on compra.id_compra = cd.id_compra
                 INNER JOIN modelo m on cd.id_modelo = m.id_modelo
        WHERE compra.id_compra = $id_compra";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function infoCompraUser($id_compra)
    {
        $query = "SELECT concat(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido), correo
        FROM compra
                 INNER JOIN usuario u on compra.id_usuario = u.id_usuario
                 INNER JOIN persona p on u.id_usuario = p.id_usuario
        WHERE id_compra = $id_compra";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }



    public function obtenerComprasFecha($primerFecha, $segundaFecha)
    {
        $query = "SELECT m.id_modelo, m.modelo AS nombre_producto, SUM(cd.cantidad) AS total_vendido
        FROM usuario u
                 INNER JOIN compra v ON u.id_usuario = v.id_usuario
                 INNER JOIN compra_detalle cd on v.id_compra = cd.id_compra
                 INNER JOIN modelo m on cd.id_modelo = m.id_modelo
        WHERE v.fecha BETWEEN '$primerFecha' AND '$segundaFecha'
        GROUP BY m.id_modelo, m.modelo
        ORDER BY SUM(cd.cantidad) DESC;";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }

    public function infoCompra($id_compra)
    {
        $query = "SELECT m.modelo,
        cd.cantidad,
        cd.precio,
        (cd.cantidad * cd.precio) AS subtotal,
        transaccion,
        concat(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido),
        correo
 FROM compra
          INNER JOIN compra_detalle cd on compra.id_compra = cd.id_compra
          INNER JOIN modelo m on cd.id_modelo = m.id_modelo
          INNER JOIN usuario u on compra.id_usuario = u.id_usuario
          INNER JOIN persona p on u.id_usuario = p.id_usuario
 WHERE compra.id_compra = $id_compra";
        $rs = $this->db->Execute($query);
        if ($rs === false) {
            $rs = $this->db->ErrorMsg();
        }
        return $rs;
    }
}

?>
<?php

class CarritoModel
{
    private $id_carrito;
    private $id_usuario;
    private $id_modelo;
    private $cantidad;
    private $fecha;
    private $precio;
    private $descuento;

    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }


    public function insertCarrito($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento)
    {
        $query = "CALL existeCarrito(?,?,?,?,?,?)";
        $rs = $this->db->Execute($query, array($id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento));
        if (!$rs) {
            die("Error al ejecutar el procedimiento comprarCarrito: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function updateCarrito($id_carrito, $id_usuario, $id_modelo, $cantidad, $fecha, $precio, $descuento)
    {
        $table = 'carrito';
        $record = array();
        $record['id_carrito'] = $id_carrito;
        $record['id_usuario'] = $id_usuario;
        $record['id_modelo'] = $id_modelo;
        $record['cantidad'] = $cantidad;
        $record['fecha'] = $fecha;
        $record['precio'] = $precio;
        $record['descuento'] = $descuento;
        $rs = $this->db->autoExecute($table, $record, 'UPDATE', 'id_carrito = ' . $id_carrito);
        if (!$rs) {
            die("Error al ejecutar actualizarCarrito de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function deleteCarrito($id_carrito)
    {
        $query = "DELETE FROM carrito WHERE id_carrito=" . $id_carrito;
        $rs = $this->db->Execute($query);
        if (!$rs) {
            die("Error al ejecutar deleteCarrito: " . $this->db->ErrorMsg());
        }
        return $this->db->Affected_Rows();
    }

    public function carritoDetalle($id_usuario)
    {
        $query = "SELECT c.id_carrito,
        u.id_usuario,
        m.id_modelo,
        c.cantidad,
        c.fecha,
        c.precio,
        c.descuento,
        u.usuario,
        m.modelo,
        CONCAT(p.nombre, ' ', p.primer_apellido) as nombrecliente,
        SUM(c.cantidad * c.precio)               AS subtotal,
        m.imagen
 FROM carrito c
          INNER JOIN usuario u on c.id_usuario = u.id_usuario
          INNER JOIN modelo m on c.id_modelo = m.id_modelo
          INNER JOIN persona p on u.id_usuario = p.id_usuario
          WHERE c.id_usuario = $id_usuario
 GROUP BY c.id_carrito,u.id_usuario,m.id_modelo,c.cantidad,c.fecha,c.precio,c.descuento,u.usuario,m.modelo,nombrecliente";
        $rs = $this->db->Execute($query);
        if (!$rs) {
            die("Error al ejecutar carritoDetalle de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function allCarrito($id_usuario)
    {
        $query = "SELECT * FROM carrito WHERE id_usuario = " . $id_usuario;
        $rs = $this->db->Execute($query);
        if (!$rs) {
            die("Error al ejecutar el procedimiento almacenado de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }
    public function contarArticulos($id_usuario)
    {
        $query = "SELECT COUNT(id_usuario) FROM carrito WHERE id_usuario = " . $id_usuario;
        $rs = $this->db->Execute($query);
        if (!$rs) {
            die("Error al ejecutar el procedimiento almacenado de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function totalCarrito($id_usuario)
    {
        $query = "SELECT SUM(c.precio * c.cantidad) AS Subtotal
        FROM carrito c
        WHERE id_usuario = " . $id_usuario;
        $rs = $this->db->Execute($query);
        if (!$rs) {
            die("Error al ejecutar totalCarrito: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

}

?>
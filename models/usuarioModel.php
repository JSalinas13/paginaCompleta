<?php
// session_start();
class UsuarioModel
{
    private $id_usuario;
    private $usuario;
    private $contrasena;
    private $correo;

    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->conectar();
    }


    public function insertUsuario(
        $nombre,
        $primerApellido,
        $segundoApellido,
        $telefono,
        $direccion,
        $usuario,
        $contrasena,
        $correo,
        $idRol
    ) {
        $query = "CALL crearUsuario(?,?,?,?,?,?,?,?,?)";
        $rs = $this->db->Execute($query, array($nombre, $primerApellido, $segundoApellido, $telefono, $direccion, $usuario, $contrasena, $correo, $idRol));

        if (!$rs) {
            echo die("Error al ejecutar el procedimiento almacenado de compra: " . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function updateUsuario(
        $id_usuario,
        $nombre,
        $primerApellido,
        $segundoApellido,
        $usuario,
        $correo,
        $idRol,
        $direccion
    ) {
        $query = "CALL actualizarUsuario(?,?,?,?,?,?,?,?)";
        $rs = $this->db->Execute($query, array($id_usuario, $nombre, $primerApellido, $segundoApellido, $usuario, $correo, $idRol, $direccion));

        if (!$rs) {
            echo die("Error al ejecutar el procedimiento almacenado de compra: " . $this->db->ErrorMsg());
        } else {
            $_SESSION['id_usuario'] == $id_usuario ? $_SESSION['rol'] = $idRol : '';
        }
        return $rs;
    }

    public function deleteUsuario($id_usuario)
    {
        $query = "CALL eliminarUsuario(?)";
        $rs = $this->db->Execute($query, array($id_usuario));

        if (!$rs) {
            echo die("Error al ejecutar el procedimiento almacenado de eliminarUsuario: " . $this->db->ErrorMsg());
        }
        $rs = '<div div class= "alert alert-success" role = "alert" >Se elimino con exito</div>';

        return $rs;
    }

    public function selectUsuarioId($id)
    {
        $query = "SELECT * FROM usuario WHERE id_usuario=" . $id;
        $rs = $this->db->Execute($query);
        return $rs;
    }

    public function selectUsuarioUsuario($usuario, $contrasena)
    {
        $query = "SELECT u.id_usuario, u.usuario, CONCAT(p.nombre, ' ', p.primer_apellido) AS nombre, r.id_rol
        FROM usuario u
                 INNER JOIN persona p on u.id_usuario = p.id_usuario
                 INNER JOIN rol r on u.id_rol = r.id_rol
        WHERE usuario = ?
          AND contrasena =?";
        $rs = $this->db->Execute($query, array($usuario, $contrasena));
        if ($rs === false) {
            die('Error en la consulta: ' . $this->db->ErrorMsg());
        }
        return $rs;
    }

    public function usuariosTabla()
    {
        $query = "SELECT u.id_usuario,
        concat(p.nombre, ' ', p.primer_apellido, ' ', p.segundo_apellido) as nombre,
        u.usuario,
        u.correo,
        r.rol,
        p.direccion,
        p.nombre,
        p.primer_apellido,
        p.segundo_apellido,
        p.id_persona,
        r.id_rol
 FROM usuario u
          INNER JOIN persona p on u.id_usuario = p.id_usuario
          INNER JOIN rol r on u.id_rol = r.id_rol
          order by 1";
        $rs = $this->db->Execute($query);
        return $rs;
    }
    public function allUsuario()
    {
        $query = "SELECT * FROM usuario";
        $rs = $this->db->Execute($query);
        // print_r($rs->getRows());
        return $rs;
    }
    public function getRol()
    {
        $query = "SELECT * FROM rol";
        $rs = $this->db->Execute($query);
        // print_r($rs->getRows());
        return $rs;
    }


    public function funcionesAdmin()
    {
        return '';
    }
}

?>
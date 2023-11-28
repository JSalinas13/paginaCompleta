<?php
session_start();
class Conexion
{
    private $DBType = 'mysqli';
    private $DBServer = 'localhost'; // server name or IP address
    private $DBUser = 'js';
    private $DBPass = '123456';
    private $DBName = 'plataformascarrillo';
 
    public function __construct()
    {

    }

    function conectar()
    {
        $con = adoNewConnection($this->DBType);
        $con->debug = false;
        $con->connect($this->DBServer, $this->DBUser, $this->DBPass, $this->DBName);
        return $con;
    }

}

// class Conexion
// {
//     private $DBType = 'mysqli';
//     private $DBServer = 'localhost'; // server name or IP address
//     private $DBUser = 'id20648674_js';
//     private $DBPass = 'PrograWeb@2023';
//     private $DBName = 'id20648674_plataformascarrillo';

//     public function __construct()
//     {

//     }

//     function conectar()
//     {
//         $con = adoNewConnection($this->DBType);
//         $con->debug = false;
//         $con->connect($this->DBServer, $this->DBUser, $this->DBPass, $this->DBName);
//         return $con;
//     }

// }


?>
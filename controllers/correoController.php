<?php

$correoModel = new CorreoModel();

echo $correoModel->mandarCorreo($_POST['txtCorreo'], $_POST['txtNombre'] . ' ' . $_POST['txtPrimerApellido'], 'Bienvenido a Plataformas Carrillo', '');
?>
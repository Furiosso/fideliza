<?php
include_once "./conexion.php";
include_once "./enviar_correo.php";
session_start();
$tipo = $mysqli->real_escape_string($_POST['tipo']);
switch($tipo){
    case 1:
        $query = "SELECT apellidos, email FROM compradores WHERE id = ".$_SESSION['usuario'];
        $fila = $mysqli->query($query)->fetch_row();
        $apellidos = $fila[0];
        $email = $fila[1];
        $query = "DELETE FROM compradores WHERE id = ".$_SESSION['usuario'];
        break;
    case 2:
        $query = "SELECT empresa, email FROM empresas WHERE id = ".$_SESSION['empresa'];
        $fila = $mysqli->query($query)->fetch_row();
        $apellidos = $fila[0];
        $email = $fila[1];
        $query = "DELETE FROM empresas WHERE id = ".$_SESSION['empresa'];
        break;
}
$mysqli->query($query);
$mensaje="<p>A la atención de ${apellidos}: <br>
Su baja de Fideliza.com se ha producido de manera efectiva.<br>
Esperamos que su experiencia haya sido satisfactoria y vuelva pronto con nosotros.<br>
Atentamente<br>
El equipo de Fideliza.com<p>";
enviar_correo($email, $apellidos, 'Confirmación de baja', $mensaje);
unset($_SESSION['usuario']);
unset($_SESSION['empresa']);
header('Location: ../index.php');
die();
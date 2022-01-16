<?php
include_once "./conexion.php";
session_start();
$porcentaje = $mysqli->real_escape_string($_POST["porcentaje"]);
$id_empresa = $_SESSION["empresa"];
$id_categoria = $mysqli->real_escape_string($_POST["categoria"]);
$query = "SELECT id_categoria FROM descuentos WHERE id_empresa = $id_empresa";
$tabla = $mysqli->query($query);
$flag = true;
while($row = $tabla->fetch_row()){
    if($row[0] == $id_categoria){
        $flag = false;
        break;
    }
}
if($flag){
    $query = "INSERT INTO descuentos(id_empresa, id_categoria, porcentaje_descuento) VALUES ($id_empresa, $id_categoria, $porcentaje)";
    $mysqli->query($query); 
    echo $flag;
}
die();

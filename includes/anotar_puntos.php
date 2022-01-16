<?php
include_once "./conexion.php";
session_start();
$codigo = $mysqli->real_escape_string($_POST['cod']);
$cantidad = $mysqli->real_escape_string($_POST['cantidad']);
$id_empresa = $_SESSION['empresa'];
$query = "SELECT codigos_descuento.id_cliente, descuentos.porcentaje_descuento FROM codigos_descuento, descuentos WHERE codigos_descuento.codigo_descuento = '$codigo' AND codigos_descuento.id_descuento = descuentos.id";
$fila = $mysqli->query($query)->fetch_row();
$id_cliente = $fila[0];
$descuento = $fila[1];
$importe = round(($cantidad*$descuento/100), 2, PHP_ROUND_HALF_DOWN); 
$sumando = $importe;
$query = "SELECT monedero FROM monederos WHERE id_cliente = $id_cliente AND id_empresa = $id_empresa";
$fila = $mysqli->query($query)->fetch_row();
if($fila == 0){
    $query = "INSERT INTO monederos VALUES ($id_cliente, $id_empresa, $importe, NULL)";
    $mysqli->query($query);
}else{
    $importe += $fila[0];
    $query = "UPDATE monederos SET monedero = $importe WHERE id_cliente = $id_cliente AND id_empresa = $id_empresa";
    $mysqli->query($query);
}
$query = "DELETE FROM codigos_descuento WHERE codigo_descuento = '$codigo'";
$mysqli->query($query);
$query = "SELECT nombre, apellidos FROM compradores WHERE id = $id_cliente";
$fila = $mysqli->query($query)->fetch_row();
$nombre = $fila[0];
$apellidos = $fila[1];
echo 'Se han cargado '.$sumando.' euros en el monedero del cliente '.$nombre.' '.$apellidos;
die();

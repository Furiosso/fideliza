<?php
include_once "./conexion.php";
session_start();
$codigo = $mysqli->real_escape_string($_POST['cod']);
$precio = $mysqli->real_escape_string($_POST['precio']);
$id_empresa = $_SESSION['empresa'];
$query = "SELECT id_cliente, monedero FROM monederos WHERE codigo_monedero = '$codigo'";
$fila = $mysqli->query($query)->fetch_row();
$id_cliente = $fila[0];
$monedero = $fila[1];
$precio -= $monedero;
$query = "SELECT nombre, apellidos FROM compradores WHERE id = $id_cliente";
$fila = $mysqli->query($query)->fetch_row();
$nombre = $fila[0];
$apellidos = $fila[1];
if($precio >= 0){
    echo 'El importe a cobrar es de '.$precio.' euros. El cliente '.$nombre.' '.$apellidos.' ha agotado todo el dinero de su monedero';
    $query = "DELETE FROM monederos WHERE codigo_monedero = '$codigo'";
    $mysqli->query($query);
}else{
    $precio = abs($precio);
    echo 'El importe a cobrar es de 0 euros. El cliente '.$nombre.' '.$apellidos.' conserva '.$precio.' euros en su monedero';
    $query = "UPDATE monederos SET monedero = $precio, codigo_monedero = NULL WHERE codigo_monedero = '$codigo'";
    $mysqli->query($query);
}
die();
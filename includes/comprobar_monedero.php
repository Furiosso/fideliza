<?php
session_start();
include_once "./conexion.php";
$id_empresa = $_SESSION['empresa'];
$codigo = $_POST['cod'];
$query = "SELECT * FROM monederos WHERE codigo_monedero = '$codigo' AND id_empresa = $id_empresa";
$fila = $mysqli->query($query);
if(($fila->fetch_row()) == 0){
    echo "invalid";
}else{
    echo 'Inserte el precio total del producto a cobrar para calcular el importe final que se le cargará al cliente tras restársele el importe de su monedero: <input type="number" id="precio" min=0 step=0.01><br><button onclick="calcular_importe();" style="cursor: pointer;">Calcular</button>';
}
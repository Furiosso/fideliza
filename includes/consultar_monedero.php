<?php
include_once "./conexion.php";
session_start();
$id_empresa = $mysqli->real_escape_string($_POST["id"]);
$id_cliente = $_SESSION['usuario'];
$query = "SELECT monederos.monedero, empresas.empresa FROM monederos, empresas WHERE monederos.id_cliente = $id_cliente AND monederos.id_empresa = $id_empresa AND empresas.id = monederos.id_empresa";
$fila = $mysqli->query($query)->fetch_row();
if($fila == 0){
    echo "Todavía no tiene dinero acumulado en este comercio";
}else{
    $monedero = $fila[0];
    $empresa = $fila[1];
    echo 'Tiene '.$monedero.' euros acumulados en su monedero del comercio '.$empresa.' 
    ¿Quiere obtener el código para canjearlos?
    <br><br>
    <div class="botones">
    <button onclick="solicitar_canje('.$id_empresa.');" style="cursor: pointer">Sí</button>
    <br>
    <button onclick="$(\'#modal2\').dialog(\'close\')" style="cursor: pointer")">Ahora no</button></div>';
}
die();
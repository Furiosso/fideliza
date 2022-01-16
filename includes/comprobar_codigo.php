<?php
session_start();
include_once "./conexion.php";
$id_empresa = $_SESSION['empresa'];
$codigo = $mysqli->real_escape_string($_POST['cod']);
$query = "SELECT descuentos.id_categoria FROM codigos_descuento, descuentos WHERE codigos_descuento.codigo_descuento = '$codigo' AND codigos_descuento.id_descuento = descuentos.id AND descuentos.id_empresa = $id_empresa";
$fila = $mysqli->query($query)->fetch_row();
if($fila == 0){
    echo "invalid";
}else{
    $query = "SELECT categoria FROM categorias WHERE id = $fila[0]";
    $fila = $mysqli->query($query)->fetch_row();
    $categoria = $fila[0];
    echo 'Este descuento pertenece a la categoría '.$categoria.'. Si el producto que desea adquirir el cliente no pertenece a esta categoría póngase en contacto con este. Inserte el precio total del producto para ingresar el porcentaje correspondiente en el monedero del cliente : <input type="number" id="cantidad" min=0 step=0.01><br><button onclick="anotar_puntos();" style="cursor: pointer;">Anotar</button>';
}
<?php
include_once './conexion.php';
$categoria = "";
$empresa = "";
$orderby = "ORDER BY descuentos.porcentaje_descuento DESC";
if($_POST['categoria'] != 0){
    $categoria = 'AND categorias.id = '.$_POST['categoria'];
}
if($_POST['empresa'] != 0){
    $empresa = 'AND empresas.id = '.$_POST['empresa'];
}
if($_POST['categoria'] == 0 && $_POST['empresa'] == 0){
    $orderby = "ORDER BY empresas.empresa, descuentos.porcentaje_descuento DESC";
}
$query = "SELECT empresas.empresa, categorias.categoria, descuentos.porcentaje_descuento, descuentos.id, empresas.id FROM empresas, categorias, descuentos WHERE empresas.id = descuentos.id_empresa AND descuentos.id_categoria = categorias.id ".$empresa." ".$categoria." ".$orderby;
$tabla = $mysqli->query($query);
if(($fila = $tabla->fetch_row()) > 0){
    $html = '<table id="myTable" class="display greyGridTable">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Productos</th>
            <th>Descuento</th>
            <th>Solicitar código de descuento</th>
            <th>Consultar monedero</th>
        </tr>
    </thead>
    <tbody>
    <tr><td>'.$fila[0].'</td><td>'.$fila[1].'</td><td>'.$fila[2].'%</td><td><button onclick="solicitar_codigo('.$fila[3].')" style="cursor: pointer">Solicitar código</button></td><td><button onclick="consultar_monedero('.$fila[4].')" style="cursor: pointer">Consultar monedero</button></td></tr>';
    while($fila = $tabla->fetch_row()){
        $html .= '<tr><td>'.$fila[0].'</td><td>'.$fila[1].'</td><td>'.$fila[2].'%</td><td><button onclick="solicitar_codigo('.$fila[3].')" style="cursor: pointer">Solicitar código</button></td><td><button onclick="consultar_monedero('.$fila[4].')" style="cursor: pointer">Consultar monedero</button></td></tr>';
    }    
    $html .= '</tbody></table>';
    echo $html;
}
die();
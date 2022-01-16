<?php
include_once './conexion.php';
session_start();
$id_empresa = $_SESSION['empresa'];
$query = "SELECT categorias.categoria, descuentos.porcentaje_descuento, descuentos.id FROM descuentos JOIN categorias ON descuentos.id_categoria = categorias.id WHERE descuentos.id_empresa = $id_empresa ORDER BY categoria";
$tabla = $mysqli->query($query);
if(($fila = $tabla->fetch_row()) > 0){
    $html = '<table id="myTable" class="display greyGridTable">
    <thead>
        <tr>
            <th>Categoría</th>
            <th>Descuento</th>
            <th>Modificar</th>
            <th>Eliminar descuento</th>
        </tr>
    </thead>
    <tbody>
    <tr><td>'.$fila[0].'</td><td><input type="number" id="disc_'.$fila[2].'" placeholder="'.$fila[1].'%" max=100 min=1.5 step=0.25></td><td><button onclick="modificar_porcentaje('.$fila[2].');" style="cursor:pointer">Modificar</button></td><td><i class="fas fa-trash-alt" onclick="borrar_descuento('.$fila[2].');" style="cursor: pointer"></i></td></tr>';
    while($fila = $tabla->fetch_row()){
        $html .= '<tr><td>'.$fila[0].'</td><td><input type="number" id="disc_'.$fila[2].'" placeholder="'.$fila[1].'%" max=100 min=1.5 step=0.25></td><td><button onclick="modificar_porcentaje('.$fila[2].');" style="cursor:pointer">Modificar</button></td><td><i class="fas fa-trash-alt" onclick="borrar_descuento('.$fila[2].');" style="cursor: pointer"></i></td></tr>';
    }
    $html .= '</tbody></table>';
    echo $html;
}
die();
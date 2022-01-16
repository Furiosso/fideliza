<?php
include_once "./conexion.php";
$categoria = $mysqli->real_escape_string($_POST["categoria"]);
$query ="INSERT INTO categorias (categoria) VALUES ('$categoria');";
$mysqli->query($query);
$query ="SELECT * FROM categorias";
$tabla = $mysqli->query($query);
$data = '<select name="categoria" id="categoria"><option value="">Categorías...</option>';   
while($row = $tabla->fetch_row()){
    $seleccionado = ""; 
    if($row[1] == $categoria){
        $seleccionado = "selected";
    }
    $data .= '<option '.$seleccionado.' value="'.$row[0].'">'.$row[1].'</option>';
}
$data .= '</select>';
echo $data;    
die();

<?php
    require_once './conexion.php';
    $id = $mysqli->real_escape_string($_POST['id']);
    $porcentaje_descuento = $_POST["porcentaje"];
    $query = 'UPDATE descuentos SET porcentaje_descuento = '.$porcentaje_descuento.' WHERE id = '.$id.'';
    $mysqli->query($query);
    die();
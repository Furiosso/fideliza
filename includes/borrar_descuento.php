<?php
include_once "./conexion.php";
$id = $mysqli->real_escape_string($_POST['id']);
$query = 'DELETE FROM descuentos WHERE id = '.$id.'';
$mysqli->query($query);
die();
<?php
include_once "./conexion.php";
$tipo=$mysqli->real_escape_string($_GET['tipo']);
$dni=$mysqli->real_escape_string($_GET['dni']);
$email=$mysqli->real_escape_string($_GET['email']);
switch($tipo){
    case 1:
        $query="UPDATE compradores SET verificado = 1 WHERE dni = '$dni' AND email = '$email'";
        break;
    case 2:
        $query="UPDATE empresas SET verificado = 1 WHERE nif = '$dni' AND email = '$email'";
        break;
}
$mysqli->query($query);
switch($tipo){
    case 1:
        header('Location: ../index.php?success=1');
        break;
    case 2:
        header('Location: ../index.php?success=2');
        break;
}
die();
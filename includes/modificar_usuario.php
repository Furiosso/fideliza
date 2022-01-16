<?php
    session_start();
    require_once './conexion.php';
    $valor = $mysqli->real_escape_string($_POST['valor']);
    $columna = $mysqli->real_escape_string($_POST['columna']);
    $query = 'UPDATE compradores SET '.$columna.' = "'.$valor.'" WHERE id = '.$_SESSION['usuario'].'';
    $mysqli->query($query);
    die();
<?php

    session_start();
    require_once './conexion.php';
    $valor = $mysqli->real_escape_string($_POST['valor']);
    $columna = $mysqli->real_escape_string($_POST['columna']);
    $query = 'UPDATE empresas SET '.$columna.' = "'.$valor.'" WHERE id = '.$_SESSION['empresa'].'';
    $mysqli->query($query);
    die();
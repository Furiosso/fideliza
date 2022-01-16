<?php
    include "./conexion.php";
    session_start();
    unset($_SESSION['usuario']);
    unset($_SESSION['empresa']);
    header('Location: ../index.php');
    exit();
?>
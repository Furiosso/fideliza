<?php
$hostname = "localhost";
$database = "fideliza";
$username = "fideliza";
$password = "fideliza69@";

$mysqli = new mysqli($hostname, $username, $password, $database);
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else {
    $mysqli->set_charset("utf8");
    setlocale(LC_ALL, 'es_ES.UTF-8');
}
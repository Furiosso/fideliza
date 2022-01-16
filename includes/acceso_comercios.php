<?php
include "./conexion.php";
session_start();
$nif = $mysqli->real_escape_string($_POST['nif']);
$pass = $mysqli->real_escape_string($_POST['pass']);
$query = "SELECT id, verificado FROM empresas WHERE nif = '" . $nif . "' AND aes_decrypt(pass, 'belladona') = '".$pass."';";
$result = $mysqli->query($query);
$filas = $result->num_rows;
if($result->num_rows == 1){
    $fila = $result->fetch_array();
    if($fila['verificado'] == 1){
        $_SESSION['empresa'] = $fila["id"];
        echo '1';
    }else{
        echo '<i style="color: red" class="fas fa-exclamation-circle"></i> Cuenta no verificada aún'; 
    }
} else {
    echo '<i style="color: red" class="fas fa-exclamation-circle"></i> Error, usuario o contraseña incorrecto';
};
exit();
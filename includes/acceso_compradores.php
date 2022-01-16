<?php
include "./conexion.php";
session_start();
$dni = $mysqli->real_escape_string($_POST['dni']);
$pass = $mysqli->real_escape_string($_POST['pass']);
$query = "SELECT id, verificado FROM compradores WHERE dni = '" . $dni . "' AND aes_decrypt(pass, 'belladona') = '".$pass."';";
$result = $mysqli->query($query);
if($result->num_rows == 1){
    $fila = $result->fetch_row();
    if($fila[1] == 1){
        $_SESSION['usuario'] = $fila[0];
        echo '1';
    }else{
        echo '<i style="color: red" class="fas fa-exclamation-circle"></i> Cuenta no verificada aún'; 
    }
} else {
    echo '<i style="color: red" class="fas fa-exclamation-circle"></i> Error, usuario o contraseña incorrecto';
};
exit();
<?php
include_once "./conexion.php";
include_once "./enviar_correo.php";
$nombre = $mysqli->real_escape_string($_POST["nombre"]);
$apellidos = $mysqli->real_escape_string($_POST["apellidos"]);
$dni = $mysqli->real_escape_string($_POST["dni"]);
$pass = $mysqli->real_escape_string($_POST["pass"]);
$email = $mysqli->real_escape_string($_POST["email"]);
$telefono = $mysqli->real_escape_string($_POST["telefono"]);
$flag = false;
$coda ='<i style="color: red" class="fas fa-exclamation-circle"></i> Ya existe un registro con ese ';
if($result = $mysqli->query("SELECT id FROM compradores WHERE dni ='$dni'")->fetch_row() > 0){
    $coda .= 'D.N.I. ';
    $flag = true;
}
if($result = $mysqli->query("SELECT id FROM compradores WHERE email ='$email'")->fetch_row() > 0){
    switch($flag){
        case true:
            $coda .= ' y ese correo electrónico';
            break;
        case false;    
            $coda .= 'correo electrónico';
            $flag = true;
            break; 
    }  
}     
if(!$flag){
    $coda = 'Acceso a clientes';
    $query ="INSERT INTO compradores (nombre, apellidos, dni, pass, email, telefono) VALUES ('$nombre', '$apellidos', '$dni', aes_encrypt('$pass', 'belladona'), '$email', '$telefono');";
    $mysqli->query($query);
    $mensaje = '<html>
    <head>
    <style>
    button:hover{
        border-color: darkgreen;
    }
    a{
        text-decoration: none;
    }
    </style>
    <head>
    <body><p>Estimado/a sr/sra '.$apellidos.':<br>
    Por favor haga click en este botón para verificar su cuenta:</p><br>
    <button><a href="https://fideliza.ciberweb.com/includes/verificar.php?tipo=1&dni='.$dni.'&email='.$email.'" style="
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    color: black;
    cursor: pointer;
    ">VERIFICAR</a></button><br>
    <p>Atentamente<br>
    El equipo de Fideliza.com</p></body></html>';
    enviar_correo($email, $apellidos, 'Verificación de cuenta', $mensaje);
}
echo $coda;
die();
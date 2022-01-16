<?php
include_once "./conexion.php";
include_once "./enviar_correo.php";
$empresa = $mysqli->real_escape_string($_POST["empresa"]);
$nif = $mysqli->real_escape_string($_POST["nif"]);
$pass = $mysqli->real_escape_string($_POST["pass"]);
$direccion_postal = $mysqli->real_escape_string($_POST['direccion_postal']);
$direccion_fiscal = $mysqli->real_escape_string($_POST['direccion_fiscal']);
$email = $mysqli->real_escape_string($_POST["email"]);
$telefono = $mysqli->real_escape_string($_POST["telefono"]);
$flag = 0;
$coda = '<i style="color: red" class="fas fa-exclamation-circle"></i> Ya existe un registro con ese ';
if($result = $mysqli->query("SELECT id FROM empresas WHERE nif ='$nif'")->fetch_row() > 0){
    $coda .= 'D.N.I.';
    $flag++;
}
if($result = $mysqli->query("SELECT id FROM empresas WHERE email ='$email'")->fetch_row() > 0){
    $flag++;
    switch($flag){
        case 1:
            $coda .= 'correo electrónico';
            break;
        case 2:
            $coda .= ' y ese correo electrónico';
            break;    
    }
}
if($result = $mysqli->query("SELECT id FROM empresas WHERE empresa ='$empresa'")->fetch_row() > 0){
    $flag++;
    switch($flag){
        case 1:
            $coda .= 'nombre';
            break;
        default:
            $coda .= ' y ese nombre';
            break;      
    }
}
if($result = $mysqli->query("SELECT id FROM empresas WHERE telefono ='$telefono'")->fetch_row() > 0){
    $flag++;
    switch($flag){
        case 1:
            $coda .= 'teléfono';
            break;
        default:
            $coda .= ' y ese teléfono';
            break;      
    }
}
if($flag == 0){
    $coda = 'Acceso a empresas';
    $query ="INSERT INTO empresas (empresa, nif, pass, direccion_postal, direccion_fiscal, email, telefono) VALUES ('$empresa', '$nif', aes_encrypt('$pass', 'belladona'), '$direccion_postal', '$direccion_fiscal', '$email', '$telefono');";
    $mysqli->query($query);
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
    <body><p>Estimada empresa '.$empresa.':<br>
    Por favor haga click en este botón para verificar su cuenta:</p><br>
    <button><a href="https://fideliza.ciberweb.com/includes/verificar.php?tipo=2&dni='.$nif.'&email='.$email.'" style="
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    color: black;
    cursor: pointer;
    ">VERIFICAR</a></button><br>
    <p>Atentamente<br>
    El equipo de Fideliza.com</p></body></html>';
    enviar_correo($email, $empresa, 'Verificación de cuenta', $mensaje);
}
echo $coda;
die();

<?php
include_once "./conexion.php";
include_once "./generador_de_codigos.php";
include_once "./enviar_correo.php";
session_start();
$id_cliente = $_SESSION['usuario'];
$id_empresa = $mysqli->real_escape_string($_POST['empresa']);
$codigo = generar_codigo(5);
$query = "UPDATE monederos SET codigo_monedero = '$codigo' WHERE id_cliente = $id_cliente AND id_empresa = $id_empresa";
$mysqli->query($query);
$query = "SELECT apellidos, compradores.email, empresa, monedero FROM compradores, empresas, monederos WHERE compradores.id = $id_cliente AND empresas.id = $id_empresa AND monederos.id_empresa = $id_empresa AND monederos.id_cliente = $id_cliente";
$fila = $mysqli->query($query)->fetch_row();
$apellidos = $fila[0];
$direccion = $fila[1];
$dinero = $fila[3];
$empresa = $fila[2];
$mensaje = '<p>Estimado/a sr/sra '.$apellidos.':<br>
Aquí tiene su código para utilizar los '.$dinero.' euros de su monedero en el comercio '.$empresa.':<br>
</p><strong><h1>'.$codigo.'</h1></strong><p><br>
Atentamente<br>
El equipo de Fideliza.com</p>';
enviar_correo($direccion, $apellidos, 'Código monedero', $mensaje);
echo 'Solicite que le descuenten el dinero de su monedero en su próxima compra adjuntando el siguiente código: <br><h1>'.$codigo.'</h1>';
die();
<?php
include_once "./conexion.php";
include_once "./generador_de_codigos.php";
include_once "./enviar_correo.php";
session_start();
$id_cliente = $_SESSION['usuario'];
$id = $mysqli->real_escape_string($_POST['id']);
$codigo = generar_codigo(6);
$query = "INSERT INTO codigos_descuento VALUES ($id, $id_cliente, '$codigo')";
$mysqli->query($query);
$fila = $mysqli->query("SELECT apellidos, email FROM compradores JOIN codigos_descuento ON compradores.id = codigos_descuento.id_cliente WHERE codigo_descuento = '$codigo'")->fetch_row();
$apellidos = $fila[0];
$direccion = $fila[1];
$fila = $mysqli->query("SELECT empresa, porcentaje_descuento, categoria FROM empresas, descuentos JOIN codigos_descuento ON descuentos.id = codigos_descuento.id_descuento JOIN categorias ON categorias.id = descuentos.id_categoria WHERE descuentos.id_empresa = empresas.id AND codigo_descuento = '$codigo'")->fetch_row();
$empresa = $fila[0];
$porcentaje = $fila[1];
$categoria = $fila[2];
$mensaje = '<p>Estimado/a sr/sra '.$apellidos.':<br>
Aquí tiene su código para obtener su reembolso del '.$porcentaje.'% en su compra de '.$categoria.' en '.$empresa.':<br>
</p><strong><h1>'.$codigo.'</h1></strong><p><br>
Atentamente<br>
El equipo de Fideliza.com</p>';
enviar_correo($direccion, $apellidos, 'Código reembolso', $mensaje);
echo $codigo;
die();
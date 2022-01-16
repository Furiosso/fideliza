<?php
    include_once "./includes/conexion.php";
    include_once "./includes/clases.php";
    session_start();
    if(empty($_SESSION['empresa'])){
        header("Location: ./index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./includes/icons/favicon.png" type="image/x-icon" rel="shortcut icon" />
    <title>Fideliza.com</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/5b39dcffb2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./includes/css/css.css" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
        pintar_tabla();
    } );
    function modificar(tipo) {
        switch(tipo){
            case(1):
                var valor = $('#empresa').val();
                var columna = 'empresa';
                break;
            case(2):
                var valor = $('#nif').val();
                var columna = 'nif';
                break;
            case(3):
                var valor = $('#direccion_postal').val();
                var columna = 'direccion_postal';
                break;
            case(4):
                var valor = $('#direccion_fiscal').val();
                var columna = 'direccion_fiscal';
                break;
            case(5):
                var valor = $('#email').val();
                var columna = 'email';
                break;
            case(6):
                var valor = $('#telefono').val();
                var columna = 'telefono';
                break;
            }
         $.ajax({
            method: "POST",
            url: "includes/modificar_comercio.php",
            data: {valor: valor, columna: columna}
        }).done(function () {
        }); 
    }     
    function categoria(){
        console.log($('#categoria2').val());
        var categoria = $('#categoria2').val();
        $.ajax({
            method: "POST",
            url: "./includes/incluir_categoria.php",
            data: {categoria: categoria}
        }).done(function (data) {
            $('#desplegable').html(data);
        }); 
    }  
    function insertar_porcentaje(){
        var porcentaje = $('#porcentaje').val();
        var categoria = $('#categoria').val();
        $.ajax({
            method: "POST",
            url: "./includes/incluir_porcentaje.php",
            data: {porcentaje: porcentaje, categoria: categoria}
        }).done(function () {
            pintar_tabla();
        }); 
    }
    function modificar_porcentaje(id){
        porcentaje = $('#disc_'+id).val();
        $.ajax({
            method: "POST",
            url: "./includes/modificar_porcentaje.php",
            data: {id: id, porcentaje: porcentaje}
        }).done(function () {
            pintar_tabla();
        }); 
    }
    function borrar_descuento(id){
        $.ajax({
            method: "POST",
            url: "./includes/borrar_descuento.php",
            data: {id: id}
        }).done(function () {
            pintar_tabla();
        }); 
    }
    function comprobar_codigo(){         
        var cod = $('#cod').val();
        $.ajax({
            method: "POST",
            url: "includes/comprobar_codigo.php",
            data: {cod : cod}
        }).done(function (data) {   
            switch(data){   
                case 'invalid':
                    $("#invalido").dialog({
                        modal: true,
                        width: 325
                    });
                    break;
                default:        
                $("#anotacion").html(data).dialog({
                    modal: true,
                    width: 325
                });
                $('#cod').html("");
            }
        });
        $(this).dialog("close");
    }  
    function anotar_puntos(){
        var cod = $('#cod').val();
        var cantidad = $('#cantidad').val();
        console.log(cod);
        $.ajax({
            method: "POST",
            url: "includes/anotar_puntos.php",
            data: {cod : cod, cantidad: cantidad}
        }).done(function (data) {                    
            $("#anotacion").html(data).dialog({
                modal: true,
                width: 325
            });
        });
    }
    function comprobar_monedero(){               
        var cod = $('#cod').val();
        $.ajax({
            method: "POST",
            url: "includes/comprobar_monedero.php",
            data: {cod : cod}
        }).done(function (data) {   
            switch(data){   
                case 'invalid':
                    $("#invalido").dialog({
                        modal: true,
                        width: 325
                    });
                    break;
                default:        
                $("#anotacion").html(data).dialog({
                    modal: true,
                    width: 325
                });
                $('#cod').html("");
            }
        });
        $(this).dialog("close");
    }              
     
    function calcular_importe(){
        var cod = $('#cod').val();
        var precio = $('#precio').val();
        console.log(cod);
        $.ajax({
            method: "POST",
            url: "includes/calcular_precio.php",
            data: {cod : cod, precio: precio}
        }).done(function (data) {                    
            $("#anotacion").html(data).dialog({
                modal: true,
                width: 325
            });
        });
    }

    function mostrar_info(div){
            $(div).dialog({
                modal: true,
                width: 325
            }); 
        } 
    function pintar_tabla(){
        $.ajax({
            url: "./includes/pintar_tabla.php"
        }).done(function (data) {
            $('#tabla').html(data);
            $('#myTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": false,
                "responsive": true,
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                }
            });
        }); 
    }
  </script>
  
</head>
<body>    
    <header id="cabecera" class="banner">
        <div>
            <h1 id="logo">FIDELIZA</h1>
            <h2 class="subtitulo">Acumula dinero en tus compras online</h2>
        </div>
        <p style="float: right;"><a href="./includes/cerrar_sesion.php">Cerrar Sesión</a></p>
    </header>
    <section>
        <div class="decoracion_up"></div>
        <h2 class="encabezado">Perfil</h2>
        <div class="decoracion_down"></div>
    </section>
    <main>
        <?php                
            $query = "SELECT * FROM empresas WHERE id = '" . $_SESSION["empresa"]."';";
            $result = $mysqli->query($query);
            $fila = $result->fetch_array();
            $empresa = $fila['empresa'];
            $direccion_postal = $fila['direccion_postal'];
            $direccion_fiscal = $fila['direccion_fiscal'];
            $nif = $fila['nif'];
            $email = $fila['email'];
            $telefono = $fila['telefono'];
        ?>
        <table class="perfil">
            <tr>
                <td>Nombre: </td>
                <td><input type='text' id="empresa" placeholder=<?= $empresa;?>></td>
                <td><button onclick="modificar(1)">Modificar</button></td>
            </tr><tr>
                <td>N.I.F.: </td>
                <td><input type='text' id="nif" placeholder=<?= $nif;?>></td>
                <td><button onclick="modificar(2)">Modificar</button></td>
            </tr><tr>
                <td>Dirección postal: </td>
                <td><input type='text' id="direccion_postal" placeholder=<?= $direccion_postal;?>></td>            
                <td><button onclick="modificar(3)">Modificar</button></td>
            </tr><tr>
                <td>Dirección fiscal: </td>
                <td><input type='text' id="direccion_fiscal" placeholder=<?= $direccion_fiscal;?>></td>            
                <td><button onclick="modificar(4)">Modificar</button></td>
            </tr><tr>
                <td>Correo electrónico: </td>
                <td><input type='email' id="email" placeholder=<?= $email;?>></td>                       
                <td><button onclick="modificar(5)">Modificar</button></td>
            </tr><tr></tr>
                <td>Teléfono: </td>
                <td><input type='text' id="telefono" placeholder=<?= $telefono;?>></td>
                <td><button onclick="modificar(6)">Modificar</button></td>
            </tr><tr>
                <td></td>
                <td><button id="boton_baja" onclick="mostrar_info('#baja');" style="font-size: 1.2em; padding: .15em .5em; margin-top: .15em">Darse de baja</button></td>
                <td></td>
            </tr>
        </table>
        <div id="baja" style="display: none" class="modal">¿Está seguro de que quiere darse de baja?
            <br><br>
            <div class="botones">
            <form method="post" action="./includes/dar_baja.php">
            <input type="hidden" name="tipo" value="2">
            <button type="submit" style="cursor: pointer">Sí</button>
            </form>
            <button onclick="$('#baja').dialog('close');" style="cursor: pointer")>No</button></div>
        </div>
        </table>
        <div>
            <div class="decoracion_up"></div>
            <h2 class="encabezado">Gestión</h2>
            <div class="decoracion_down"></div>
            <div id="gestion" class="desplegable"> 
            <table class="perfil"><tbody><tr><td>
            Escoja la categoría en la que quiere aplicar el descuento: 
            </td><td id="desplegable">
            
            <?php
            $result = $mysqli->query("select id, categoria from categorias order by categoria");
            $select_categorias = new Select($result, 'categoria', 'categoria', 'Categorías...'); 
            ?>
            </td></tr><tr><td>
            Si la categoría que busca no aparece en el listado, inclúyala aquí: 
            </td><td>
            <input type="text" id="categoria2">
            <button onclick="categoria()">Incluir categoría</button>
            </td></tr><tr><td>
            Indique el porcentaje sobre el precio del producto que se acumulará en el monedero del cliente: 
            </td><td> 
            <input type="number" id="porcentaje" max=100 min=1.5 step=0.25>
            <button onclick="insertar_porcentaje()">Incluir porcentaje</button>
            </td></tr></tbody></table>
            </div>
            <div id="tabla" class="tabla"></div>
            <div id="invalido" style="display: none;" title="Código inválido" class="modal">
                <h2>Este código no es válido</h2>
            </div>
            <div id="anotacion" title="Introduzca el precio del producto" class="modal"></div>
            <div class="desplegable" id="verificacion" class="modal">
            <label>Introduzca aquí los códigos proporcionados por los clientes para su verificación:  </label>
                <input type="text" id="cod" max=6 min=5 autocomplete="off">
            <button onclick="
            switch($('#cod').val().length){
                case 6:
                    comprobar_codigo();
                    break;
                case 5:
                    comprobar_monedero();
                    break;
                default:
                    $('#invalido').dialog({
                        modal: true,
                        width: 325
                    });    
            }" 
            style="cursor: pointer;">Verificar</button></div>
        </div>
    </main>
    <footer class="pie">
    <div class="decoracion_down"></div>
        <ul>                           
            <li><p><i class="fas fa-phone-alt"></i> Contacto</p></li>
            <li><p><i class="fas fa-cookie-bite"></i> Cookies</p></li>
            <li><p><i class="fas fa-shield-alt"></i> Privacidad</p></li>
            <li><p><i class="fas fa-project-diagram"></i>   Mapa del sitio</p></li>
        </ul>
        <div style="background-color: rgb(252, 168, 42); text-align:center">Icons made by <a style="color:white; text-decoration: none; cursor: pointer" href="https://www.freepik.com" title="Freepik">Freepik</a> from <a style="color:white; text-decoration: none; cursor: pointer" href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
    </footer>
    
</body>
</html>
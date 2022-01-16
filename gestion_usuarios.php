<?php
    include_once "./includes/conexion.php";
    include_once "./includes/clases.php";
    session_start();
    if(empty($_SESSION['usuario'])){
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
                    var valor = $('#nombre').val();
                    var columna = 'nombre';
                    break;
                case(2):
                    var valor = $('#apellidos').val();
                    var columna = 'apellidos';
                    break;
                case(3):
                    var valor = $('#dni').val();
                    var columna = 'dni';
                    break;
                case(4):
                    var valor = $('#email').val();
                    var columna = 'email';
                    break;
                case(5):
                    var valor = $('#telefono').val();
                    var columna = 'telefono';
                    break;
            }
             $.ajax({
                method: "POST",
                url: "includes/modificar_usuario.php",
                data: {valor: valor, columna: columna}
            }).done(function () {
            });
        }
        function solicitar_codigo(id){
            $.ajax({
                method: "POST",
                url: "./includes/solicitar_codigo_descuento.php",
                data: {id : id}
            }).done(function (data) {
                $('#cod').html(data);
                var div = '#modal'
                mostrar_info(div);
            }); 
        }    

        function solicitar_canje(empresa){
            $.ajax({
                method: "POST",
                url: "./includes/solicitar_codigo_canje.php",
                data: {empresa: empresa}
            }).done(function (data) {
                $('#modal2').html(data);
            });
        }

        function consultar_monedero(id){
            $.ajax({
                method: "POST",
                url: "./includes/consultar_monedero.php",
                data: {id : id}
            }).done(function (data) {
                $('#modal2').html(data);
                var div = '#modal2';
                mostrar_info(div);
            }); 
        } 

        function mostrar_info(div){
            $(div).dialog({
                modal: true,
                width: 325
            }); 
        } 

        function pintar_tabla(){
            var empresa =$('#empresa').val();
            var categoria = $('#categoria').val();
            if(categoria == ""){
                categoria = 0;
            }
            if(empresa == ""){
                empresa = 0;
            }
            $.ajax({
                method: "POST",
                url: "./includes/pintar_tabla_empresas.php",
                data: {categoria: categoria, empresa: empresa}
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
        <p style="float: right;"><a href="includes/cerrar_sesion.php">Cerrar Sesión</a></p>
    </header>
    <section>
        <div class="decoracion_up"></div>
        <h2 class="encabezado">Perfil</h2>
        <div class="decoracion_down"></div>
    
    
            <?php
                $query = "SELECT * FROM compradores WHERE id = '" . $_SESSION["usuario"]."';";
                $result = $mysqli->query($query);
                $fila = $result->fetch_array();
                $nombre = $fila['nombre'];
                $apellidos = $fila['apellidos'];
                $dni = $fila['dni'];
                $email = $fila['email'];
                $telefono = $fila['telefono'];
            ?>
        
        <table class="perfil">
            <tr>
                <td>Nombre: </td>
                <td><input type='text' id="nombre" placeholder=<?= $nombre;?>></td>
                <td><button onclick="modificar(1)">Modificar</button></td>
            </tr><tr>
                <td>Apellidos: </td>
                <td><input type='text' id="apellidos" placeholder=<?= $apellidos;?>></td>
                <td><button onclick="modificar(2)">Modificar</button></td>
            </tr><tr>
                <td>D.N.I.: </td>
                <td><input type='text' id="dni" placeholder=<?= $dni;?>></td>            
                <td><button onclick="modificar(3)">Modificar</button></td>
            </tr><tr>
                <td>Correo electrónico: </td>
                <td><input type='email' id="email" placeholder=<?= $email;?>></td>                       
                <td><button onclick="modificar(4)">Modificar</button></td>
            </tr><tr></tr>
                <td>Teléfono: </td>
                <td><input type='text' id="telefono" placeholder=<?= $telefono;?>></td>
                <td><button onclick="modificar(5)">Modificar</button></td>
            </tr><tr>
                <td></td>
                <td><button id="boton_baja" onclick="mostrar_info('#baja');" style="font-size: 1.2em; padding: .15em .5em; margin-top: .15em">Darse de baja</button></td>
                <td></td>
            </tr>
        </table>
        <div id="baja" style="display: none">¿Está seguro de que quiere darse de baja?
            <br><br>
            <div class="botones">
            <form method="post" action="./includes/dar_baja.php">
            <input type="hidden" name="tipo" value="1">
            <button type="submit" style="cursor: pointer">Sí</button>
            </form>
            <button onclick="$('#baja').dialog('close');" style="cursor: pointer")>No</button>
            <div>
        </div>
        
    </section>
    <div class="decoracion_up"></div>
        <h2 class="encabezado">Directorio</h2>
        <div class="decoracion_down"></div>
    <main>   
        <div class="desplegable">     
            <?php
            $result = $mysqli->query("select id, empresa from empresas order by empresa");
            $select_empresas = new Select($result, 'empresa', 'empresa', 'Comercios...'); 
            
            $result = $mysqli->query("select id, categoria from categorias order by categoria");
            $select_categorias = new Select($result, 'categoria', 'categoria', 'Productos...'); 
            ?>
            <button onclick="pintar_tabla();" style="cursor: pointer;">Buscar</button>
            </div>
        <div id="tabla" class="tabla"></div>
        <div id="modal" title="Código de verificación" style="display: none;" class="modal">
            <h2>Presente este código para conseguir sus puntos: </h2><h1><span id="cod"></span></h1>
        </div>
        
        <div id="modal2" title="Consulta de monedero" style="display: none" class="modal"></div>
    </main>
    <footer class="pie">
    <div class="decoracion_up"></div>
        <ul style="margin: 0;">                           
            <li><p><i class="fas fa-phone-alt"></i> Contacto</p></li>
            <li><p><i class="fas fa-cookie-bite"></i> Cookies</p></li>
            <li><p><i class="fas fa-shield-alt"></i> Privacidad</p></li>
            <li><p><i class="fas fa-project-diagram"></i>   Mapa del sitio</p></li>
        </ul>
        <div style="background-color: rgb(252, 168, 42); text-align:center">Icons made by <a style="color:white; text-decoration: none; cursor: pointer" href="https://www.freepik.com" title="Freepik">Freepik</a> from <a style="color:white; text-decoration: none; cursor: pointer" href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
    </footer>
</body>
</html>
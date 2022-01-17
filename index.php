<?php
    session_start();
    if(!empty($_SESSION["empresa"])){
        header("Location: ./gestion_comercios.php");
        exit();
    }
    if(!empty($_SESSION["usuario"])){
        header("Location: ./gestion_usuarios.php");
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
    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/5b39dcffb2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./includes/css/css.css" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
      
        function alta_usuarios(){
            $("#dialog-perfil").dialog({
                modal: true,
                width: 325
            })                          
        };
        function alta_comercios(){
            $("#dialog-comercio").dialog({
                modal: true,
                width: 325           
            });                         
        }
        
      // Las funciones que utilizan el método submit tienen que cargarse una vez esté el documento listo para 
      // cargar correctamente el escuhador del evento. Se podría evitar con otro tipo de eventos como click
      // pero en este caso es necesario submit para que funcionen los atibutos de formulario tales como required o pattern
  
    $(document).ready(function(){
        $('#acceso1').submit(function (e) { 
            e.preventDefault();
            var dni = $('#dni').val();
            var pass = $('#pass').val();                
            $.ajax({
                method: "POST",
                url: "./includes/acceso_compradores.php",
                data: {dni: dni, pass: pass}
            }).done(function (data){
                switch(data){
                    case '1':
                        window.location.href = "./gestion_usuarios.php";
                        break;
                    default:   
                        $('#legend1').html(data);
                        $('#legend2').html('Acceso a empresas');
                        break;
                }
            }); 
        });
        $('#acceso2').submit(function (e) {
            e.preventDefault();
            var nif = $('#nif').val();
            var pass = $('#pass1').val(); 
            $.ajax({
                method: "POST",
                url: "./includes/acceso_comercios.php",
                data: {nif: nif, pass: pass}
            }).done(function (data){
                switch(data){
                    case '1':
                        window.location.href = "./gestion_comercios.php";
                        break;
                    default:   
                        $('#legend2').html(data);
                        $('#legend1').html('Acceso a clientes');
                        break;
                }
            }); 
        });
        $('#alta1').submit(function(e){
            e.preventDefault();
            var nombre = $('#nombre').val();
            var apellidos = $('#apellidos').val();
            var dni = $('#dni2').val();
            var email = $('#email').val();
            var telefono = $('#telefono').val();
            var pass = $('#pass2').val();
            var pass2 = $('#pass3').val();
            if(pass != pass2){
                alert("La segunda contraseña que has introducido no coincide con la primera. Vuelve a intentarlo");
            }else{
                $.ajax({
                    method: "POST",
                    url: "./includes/crear_perfil.php",
                    data: {nombre: nombre, apellidos: apellidos, dni: dni, pass: pass, email: email, telefono: telefono}
                }).done( function(data){
                    $('#legend1').html(data);
                    $('#legend2').html('Acceso a empresas');
                    if(data == 'Acceso a clientes'){
                        $("#correo").dialog({
                            modal: true,
                            width: 325
                        });
                    }
                }); 
                $('#dialog-perfil').dialog("close");
            }
        });
        $('#alta2').submit(function(e){
            e.preventDefault();
            var empresa = $('#empresa').val();
            var nif = $('#nif2').val();
            var email = $('#email2').val();
            var telefono =$('#telefono2').val();
            var direccion_postal = $('#direccion_postal').val();
            var direccion_fiscal = $('#direccion_fiscal').val();
            var pass = $('#pass4').val();
            var pass2 = $('#pass5').val();
            if(pass != pass2){
                alert("La segunda contraseña que has introducido no coincide con la primera. Vuelve a intentarlo");
            }else{
                $.ajax({
                    method: "POST",
                    url: "./includes/crear_comercio.php",
                    data: {empresa: empresa, nif: nif, email: email, pass: pass, telefono: telefono, direccion_postal: direccion_postal, direccion_fiscal: direccion_fiscal}
                }).done(function(data){
                    $('#legend2').html(data);
                    $('#legend1').html('Acceso a clientes');
                    if(data == 'Acceso a empresas'){
                        $("#correo").dialog({
                            modal: true,
                            width: 325
                        });
                    }
                }); 
                $("#dialog-comercio").dialog("close"); 
            }
        })
    });
        </script>  
</head>

<body>
    <header class="banner">
    <h1 id="logo">FIDELIZA</h1>
    <h2 class="subtitulo">Acumula dinero en tus compras online</h2>
    
    </header>
    
    <section id="presentacion">
        <div class="decoracion_up"></div>
        <h2 class="encabezado">CÓMO FUNCIONA: </h2>
        <div class="decoracion_down"></div>
        <ul id="lista">
            <li><div class="centrar"><p>Accede a Fideliza.com </p></div><i class="fas fa-sign-in-alt"></i></li>
            <li class="right"><i class="fas fa-arrow-circle-right" style="font-size: 1.5em;"></i></li>
            <li class="down"><i class="fas fa-arrow-circle-down" style="font-size: 1.5em;"></i></li>
            <li><div class="centrar"><p>Busca el tipo de producto que desees y mira el porcentaje sobre el precio total que cada comercio se ofrece a devolverte </p></div><i class="fas fa-search"></i></li>
            <li class="right"><i class="fas fa-arrow-circle-right" style="font-size: 1.5em;"></i></li>
            <li class="down"><i class="fas fa-arrow-circle-down" style="font-size: 1.5em;"></i></li>
            <li><div class="centrar"><p>Solicita el código para solicitar la devolución al comercio a la hora de efectuar la compra </p></div><i class="fas fa-shopping-bag"></i></li>
            <li class="right"><i class="fas fa-arrow-circle-right" style="font-size: 1.5em;"></i></li>
            <li class="down"><i class="fas fa-arrow-circle-down" style="font-size: 1.5em;"></i></li>
            <li><div class="centrar"><p>Acumula dinero en tu monedero y solicita su canje mediante un código cuando te apetezca gastarlo </p></div><i class="fas fa-hand-holding-usd"></i></li>

        </ul>

        <div class="decoracion_up"></div>
        <h3 class="encabezado">Accede a tu cuenta: </h3>
    </section>
    <main id="index">
        <div id=acceso_clientes class="acceso">
            <form method="post" id="acceso1" class="formulario" autocomplete="off">
                <fieldset>
                  
                    <legend id="legend1" style="margin-bottom: 10px">
                    <?php
                        if(!empty($_GET['success']) && $_GET['success'] == 1):
                    ?>
                    <i class="fas fa-check-circle" style="color: darkgreen;"></i> Cuenta verificada con éxito
                    <?php
                        else:
                    ?>                    
                    Acceso a clientes 
                    <?php
                    endif;
                    ?>
                    </legend>
                  
                    <h5>¿No estás registrado?<br><a style="cursor: pointer;" onclick="alta_usuarios();"><u>DATE DE ALTA</u></a><br> y empieza a acumular dinero en tus monederos</h5>
                    <label>
                        D.N.I.:<br>
                        <input type="text" name="dni" id="dni" placeholder="D.N.I." required>
                    </label><br>
                    <label>
                        CONTRASEÑA:<br>
                        <input type="password" name="pass" id="pass" placeholder="Contraseña" required>
                    </label>
                    <button type="submit" id="entrar1" class="entrar">Entrar</button> 
                </fieldset>
            </form>
        </div>
        <div id="acceso_comercios" class="acceso">
            <form id="acceso2" method="post" class="formulario" autocomplete="off">
                <fieldset>
                   
                <legend id="legend2" style="margin-bottom: 10px">
                    <?php
                        if(!empty($_GET['success']) && $_GET['success'] == 2):
                    ?>
                    <i class="fas fa-check-circle" style="color: darkgreen;"></i> Cuenta verificada con éxito
                    <?php
                        else:
                    ?> 
                Acceso a empresas
                    <?php
                    endif;
                    ?>
            
                </legend>
                   
                    <h5>¿No estás registrado? <br><a style="cursor: pointer;" onclick="alta_comercios();"><u>DATE DE ALTA</u></a><br> y empieza a notar la fidelidad de tus clientes</h5>
                    <label>
                        N.I.F.:<br>
                        <input type="text" name="nif" id="nif" placeholder="N.I.F." required>
                    </label><br>
                    <label>
                        CONTRASEÑA:<br>
                        <input type="password" name="pass" id="pass1" placeholder="Contraseña" required>
                    </label>                    
                    <button type="submit" class="entrar">Entrar</button> 
                </fieldset>
            </form>
        
        </div>
        <div id="dialog-perfil" title="Crear usuario" style="display: none" class="datos">
            <form method="post" id="alta1" autocomplete="off" class="modal">
                <label>Nombre:
                <input style="margin-bottom: 6px;" pattern="[a-zA-z]+" title="No puedes poner números en el nombre" type="text" placeholder="Nombre" id="nombre" required></label>
                <label>Apellidos:
                <input style="margin-bottom: 6px;" pattern="[a-zA-z]+" title="No puedes poner números en los apellidos" type="text" placeholder= "Apellidos" id="apellidos" required></label>
                <label>D.N.I.:
                <input style="margin-bottom: 6px;" pattern="[x-zX-Z0-9]\d{7}[a-zA-Z]" title="El D.N.I. tiene que estar formado por 8 números seguidos de una letra, el N.I.E. tiene que empezar por una letra seguida de 7 números y otra letra" type="text" placeholder="D.N.I." id="dni2" required></label>
                <label>Correo electrónico:
                <input style="margin-bottom: 6px;" title="Escriba un correo electrónico válido" type="email" placeholder="Correo electrónico" id="email" required></label>
                <label>Teléfono:
                <input style="margin-bottom: 6px;" pattern="(+)?[0-9]+" title="Escriba un teléfono válido" type="text" placeholder="Teléfono" id="telefono" required></label>      
                <label>Contraseña:
                <input style="margin-bottom: 6px;" type="password" minlength="6" placeholder="Contraseña" id="pass2" required></label>
                <label>Repite la contraseña:
                <input type="password" placeholder="Contraseña" id="pass3" minlength="6" required></label>
                <button type="submit">Guardar</button>
            </form>
        </div>
        <div id="dialog-comercio" title="Darse de alta" style="display: none" class="datos">
            <form method="post" id="alta2" autocomplete="off" class="modal">
                <label>Nombre de la empresa:
                <input style="margin-bottom: 6px;" title="Introduzca el nombre de la empresa" type="text" placeholder="Nombre de la empresa" id="empresa" required></label>
                <label>N.I.F.:
                <input style="margin-bottom: 6px;" pattern="[x-zX-Z0-9]\d{7}[a-zA-Z]" title="El N.I.F. tiene que estar formado por 8 números seguidos de una letra, el N.I.E. tiene que empezar por una letra seguida de 7 números y otra letra" type="text" placeholder="N.I.F." id="nif2" required></label>
                <label>Dirección postal:
                <input style="margin-bottom: 6px;" type="text" title="Introduzca la dirección postal" placeholder="Dirección postal" id="direccion_postal" required></label>
                <label>Dirección fiscal:
                <input style="margin-bottom: 6px;" type="text" title="Introduzca la dirección fiscal" placeholder="Dirección postal" id="direccion_fiscal" required></label>
                <label>Correo electrónico:
                <input style="margin-bottom: 6px;" title="Escriba un correo electrónico válido" type="email" placeholder="Correo electrónico" id="email2" required></label>
                <label>Teléfono:
                <input style="margin-bottom: 6px;" pattern="(+)?[0-9]+" title="Escriba un teléfono válido" type="text" placeholder="Teléfono" id="telefono2" required></label>    
                <label>Contraseña:
                <input style="margin-bottom: 6px;" type="password" minlength="6" placeholder="Contraseña" id="pass4" required></label>
                <label>Repite la contraseña:
                <input type="password" placeholder="Contraseña" id="pass5" minlength="6" required></label>
                <button type="submit">Guardar</button>
            </form>
        </div>
        <div id="correo" title="ALTA CORRECTA" style="display: none;" class="datos">
            Acceda al correo electrónico que le hemos enviado para verificar su cuenta. Si no lo encuentra en la bandeja principal, búsquelo en spam.
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

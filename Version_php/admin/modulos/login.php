<?php
Session::start();
if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
    $usuarioLogueado = true;
}else{
    $usuarioLogueado = false;
}

if (! $usuarioLogueado ){
    if (Session::has("errorAdmin")){
        $errorAdmin = Session::get("errorAdmin");
        Session::clear("errorAdmin");
    };
?>

<div id='usuario'>
     <form id='usr' method='post' action='php/iniciar.sesion.php'>
        <label for='user'>Usuario</label><input id='user' type='text' name='usuario'/>
         <label for='pass'>Password</label><input id ='pass' type='password' name='password'/>


         <input type='submit' value='Ingresar' id='login_btn'/>
     </form>
 </div>;

 <?php
 if (! $usuarioLogueado && isset($errorAdmin)) {
     echo("<div class='DivErrores'>");
     echo("<h2 style='color:#F00'>" . ucfirst($errorAdmin) . "</h2>");
     echo("</div>");
 }
 }
 ?>

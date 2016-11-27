<style>
    p{font-family: Roboto;} 
    a{font-family: Roboto;}
</style>

<?php
session_start();
if(isset($_SESSION['nombre'])){
    echo "<div id='usuario'>";
    echo "<p>Bienvenido <strong>".$_SESSION['nombre']."</strong></p>";
    echo "<a href='modulos/cerrar.sesion.php' id='btn_exit'>Cerrar Sesión</a>";
    echo "</div>";
    echo "<script src='../js/abm.js'></script>";
}else{

    echo "<div id='usuario'>";
    echo "<form id='usr' method='post' action='modulos/iniciar.sesion.php'>";
    echo "<label for='usuario'>Usuario</label><input id='user' type='text' name='usuario'>";
    echo "<label for='password'>Password</label><input id ='pass'type='password' name='password'>";
    echo "<input type='submit' value='Ingresar' id='login_btn'> ";
    echo "</form>";
    echo "</div>";
    echo "<div id='msj'></div>";
    echo "<script src='../js/login.js'></script>";
}
?>


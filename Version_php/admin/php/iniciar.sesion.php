<?php
require_once('../../config.php');
$inputs = $_POST;

Session::start();
if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
    $admin = New Usuario($_POST['usuario'], $_POST['password']);
    $error = $admin->validarAdmin();
} else {
    $error = "No ha ingresado el usuario o la contraseña";
}

if ($error){
    Session::set('errorAdmin', $error);
    Session::clear('admin');
    Session::clear('logueadoAdmin');
} else {
    Session::clear('errorAdmin');
    Session::set('admin',$admin);
    Session::set('logueadoAdmin','S');
};
header("Location: ../index.php");

?>
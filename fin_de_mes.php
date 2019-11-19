<?php
session_start();

//$_SESSION["usuario"] tiene el username del usuario
if(!empty($_SESSION["usuario"]) && $_SESSION["rol"] === "admin"){
  include_once dirname(__FILE__) . '/config.php';
  $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS , NOMBRE_DB);
}
else{
  //lo manda al login si no hay nada en la sesion
  header("Location: index.php");
  exit(404);
}






 ?>

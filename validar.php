<?php
  include_once dirname(__FILE__) . '/config.php';
  $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);

  $username = $_POST["username"];
  echo $username . "<br>";
  $sql = "SELECT * FROM Usuarios WHERE nombreUsuario = \"$username\"; ";

  if(! $resultado = mysqli_query($con,$sql)){
    echo $con->error;
    exit();
  }
  while($fila = mysqli_fetch_array($resultado)) {
    $DBPassword = $fila["contraUsuario"];
    $DBRol = $fila["tipoUsuario"];
  }

  if(isset($_POST["contra"]) && $DBPassword == hash('sha1', $_POST["contra"]) ){
    session_start();

    $_SESSION["usuario"] = $username;
    $_SESSION["rol"] = $DBRol;
    $_SESSION["visitas"] = 0;

    if($DBRol == "admin"){
      //lleva a la pagina del admin
      header("Location: admin.html");

    }
    //lleva a la pagina del usuario normal
    else{
      header("Location: paginausuario.php");

    }

  }else{
    echo "Error de contraseña";
  }



//poner esto al principio de cada pagina para tener la informacion del usuario
/*******************************************/

/*

session_start();

//$_SESSION["usuario"] tiene el username del usuario
if(!empty($_SESSION["usuario"]) &&  $_SESSION["rol"] === "admin" ){
  include_once dirname(__FILE__) . '/config.php';
  $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS , NOMBRE_DB);
}
else{
  //lo manda al login si no hay nada en la sesion
  header("Location: index.php");
  exit(404);
}
*/

/*******************************************/


?>

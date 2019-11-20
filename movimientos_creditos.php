<?php

session_start();
//$_SESSION["usuario"] tiene el username del usuario
if(!empty($_SESSION["usuario"]) &&  $_SESSION["rol"] === "user" ){
  include_once dirname(__FILE__) . '/config.php';
  $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS , NOMBRE_DB);
}
else{
  //lo manda al login si no hay nada en la sesion
  header("Location: index.php");
  exit(404);
}

$id = $_SESSION["id"];
$fecha = '';
$valor = 0;
$interes = 0;


include_once dirname(__FILE__) . '/config.php';
$conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
if($conn){
    if(isset($_GET['consignar'])){
      $idCredito = $_GET['consignar'];
      echo "<h2>Consignar</h2>";
      $html = '<form action="" method="POST">';
      $html .= "cantidad".'<br>'.'<input type="text" name="cantidadConsignar"><br>';
      $html .= '<input type="submit" name="envioConsigna" value="enviar">';
      $html .= '</form>';
      echo($html);
      if(isset($_POST['envioConsigna'])){
        $result = $conn->query("SELECT * FROM Creditos WHERE idCredito=$idCredito") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $saldo = $row['saldoPendiente'];
            $cantconsig = $_POST['cantidadConsignar'];
            $nuevosaldo=$saldo - $cantconsig;
            $conn->query("UPDATE Creditos SET saldoPendiente = '$nuevosaldo' WHERE idCredito=$idCredito") or die($conn->error);
            header("location: manejar_creditos.php");
        }
      }
    }
}
?>

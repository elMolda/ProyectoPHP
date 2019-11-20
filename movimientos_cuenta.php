<?php

session_start();
$id = 0;

include_once dirname(__FILE__) . '/config.php';
$conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
if($conn){
    if(isset($_GET['retiro'])){
        $id = $_GET['retiro'];
        echo "<h2>Retirar</h2>";
        $html = '<form action="" method="POST">';
        $html .= "cantidad".'<br>'.'<input type="text" name="cantidadRetiro"><br>';
        $html .= '<input type="submit" name="envioRetiro" value="enviar">';
        $html .= '</form>';
        echo($html);
        if(isset($_POST['envioRetiro'])){
          $result = $conn->query("SELECT * FROM Cuentas WHERE idCuenta=$id") or die($conn->error);
          if($result){
              $row = $result->fetch_array();
              $saldo = $row['saldoCuenta'];
              $cantretiro = $_POST['cantidadRetiro'];
              $nuevosaldo=$saldo - $cantretiro;
              if($nuevosaldo < 0){
                $nuevosaldo = 0;
              }
              $conn->query("UPDATE Cuentas SET saldoCuenta = '$nuevosaldo' WHERE idCuenta=$id") or die($conn->error);
              header("location: manejar_cuentas.php");
          }
        }
    }

    if(isset($_GET['consignacion'])){
      $id = $_GET['consignacion'];
      echo "<h2>Consignar</h2>";
      $html = '<form action="" method="POST">';
      $html .= "cantidad".'<br>'.'<input type="text" name="cantidadaConsignar"><br>';
      $html .= '<input type="submit" name="envioConsigna" value="enviar">';
      $html .= '</form>';
      echo($html);
      if(isset($_POST['envioConsigna'])){
        $result = $conn->query("SELECT * FROM Cuentas WHERE idCuenta=$id") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $saldo = $row['saldoCuenta'];
            $cantretiro = $_POST['cantidadaConsignar'];
            $nuevosaldo=$saldo + $cantretiro;
            $conn->query("UPDATE Cuentas SET saldoCuenta = '$nuevosaldo' WHERE idCuenta=$id") or die($conn->error);
            header("location: manejar_cuentas.php");
        }
      }
    }

    if(isset($_POST['guardar'])){
        $id =  $_POST['id'];
        $saldo = $_POST['nSaldo'];
        $conn->query("UPDATE Cuentas SET saldoCuenta = '$saldo' WHERE idCuenta=$id") or die($conn->error);
        header("location: gestionar_cuentas.php");
    }
}
?>

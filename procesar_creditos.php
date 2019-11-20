<?php

<?php session_start();

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

$id = 0;
$fecha = '';
$valor = 0;
$interes = 0;
$apro = 0;

include_once dirname(__FILE__) . '/config.php';
$conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
if($conn){
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $conn->query("DELETE FROM Creditos WHERE idCredito=$id") or die($conn->error);
        header("location: gestionar_creditos.php");
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM Creditos WHERE idCredito=$id") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $fecha = $row['fechaCredito'];
            $valor = $row['valorCredito'];
            $interes = $row['interesCredito'];
            $apro = $row['creditoPendiente'];
        }
    }

    if(isset($_POST['guardar'])){
        $id =  $_POST['id'];
        $nFecha = $_POST['nFecha'];
        $nValor = $_POST['nValor'];
        $nInt = $_POST['nInt'];
        $apro = $_POST['apro'];
        $conn->query("UPDATE Creditos SET fechaCredito = '$nFecha',
                                          valorCredito = '$nValor',
                                          interesCredito = '$nInt',
                                          creditoPendiente = '$apro' WHERE idCredito=$id") or die($conn->error);
        header("location: gestionar_creditos.php");
    }
}
?>

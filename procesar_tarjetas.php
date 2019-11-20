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
$cupo = 0;
$scupo = 0;
$interes = 0;
$cuota = 0;
$apro = 0;

include_once dirname(__FILE__) . '/config.php';
$conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
if($conn){
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $conn->query("DELETE FROM Tarjetas WHERE numeroTarjeta=$id") or die($conn->error);
        header("location: gestionar_tarjetas.php");
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM Tarjetas WHERE numeroTarjeta=$id") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $cupo = $row['cupoTajeta'];
            $scupo = $row['sobreCupo'];
            $interes = $row['interes'];
            $cuota = $row['cuotaManejo'];
            $apro = $row['tarjetaPendiente'];
        }
    }

    if(isset($_POST['guardar'])){
        $id =  $_POST['id'];
        $nCupo = $_POST['nCupo'];
        $nScupo = $_POST['nScupo'];
        $nInt = $_POST['nInt'];
        $nCuota = $_POST['nCuota'];
        $apro = $_POST['apro'];
        $conn->query("UPDATE Tarjetas SET cupoTajeta = '$nCupo',
                                          sobreCupo = '$nScupo',
                                          interes = '$nInt',
                                          cuotaManejo = '$nCuota',
                                          tarjetaPendiente = '$apro' WHERE numeroTarjeta=$id") or die($conn->error);
        header("location: gestionar_tarjetas.php");
    }
}
?>

<?php

session_start();
$saldo = 0;
$id = 0;

include_once dirname(__FILE__) . '/config.php'; 
$conn = mysqli_connect(HOST_DB,USER_DB,USER_PASS,NAME_DB);
if($conn){
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $conn->query("DELETE FROM Cuentas WHERE idCuenta=$id") or die($conn->error);
        header("location: gestionar_cuentas.php");
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM Cuentas WHERE idCuenta=$id") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $saldo = $row['saldoCuenta'];
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
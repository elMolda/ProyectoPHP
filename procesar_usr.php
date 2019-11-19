<?php

session_start();
$nombreUsuario = '';
$tipo = '';
$id = 0;

include_once dirname(__FILE__) . '/config.php'; 
$conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
if($conn){
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $conn->query("DELETE FROM Usuarios WHERE idUsuario=$id") or die($conn->error);
        header("location: editar_usuarios.php");
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $result = $conn->query("SELECT * FROM Usuarios WHERE idUsuario=$id") or die($conn->error);
        if($result){
            $row = $result->fetch_array();
            $nombreUsuario = $row['nombreUsuario'];
            $tipo = $row['tipoUsuario'];
        }
    }

    if(isset($_POST['guardar'])){
        $id =  $_POST['id'];
        $nuevoNombre = $_POST['nomUsr'];
        $nuevoTipo = $_POST['tipoUsr'];
        $conn->query("UPDATE Usuarios SET nombreUsuario = '$nuevoNombre', tipoUsuario = '$nuevoTipo' WHERE idUsuario=$id") or die($conn->error);
        header("location: editar_usuarios.php");
    }
}
?>
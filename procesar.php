<?php
include_once dirname(__FILE__) . '/config.php'; 
$conn = mysqli_connect(HOST_DB,USER_DB,USER_PASS,NAME_DB);
if($conn){
    if(isset($_GET['del'])){
        $id = $_GET['del'];
        $conn->query("DELETE FROM Usuarios WHERE idUsuario=$id") or die($conn->error);
    }
}
?>
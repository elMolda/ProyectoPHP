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

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>

    <h1>Panel de administración</h1>

    <form action="gestionar_usuarios.php">
        <input type="submit" value="Gestionar Usuarios" />
    </form>
    <br><br>
    <form action="gestionar_cuentas.php">
        <input type="submit" value="Gestionar Cuentas" />
    </form>
    <br><br>
    <form action="gestionar_creditos.php">
        <input type="submit" value="Gestionar Créditos" />
    </form>
    <br><br>
    <form action="gestionar_tarjetas.php">
            <input type="submit" value="Gestionar Tarjetas de Crédito" />
    </form>
    <br><br>
    <form action="salir.php">
            <input type="submit" value="Salir" />
    </form>
</body>

</html>

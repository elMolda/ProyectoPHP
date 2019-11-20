<?
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
?>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Mis Cuentas</h1>
    <?php require_once 'movimientos_cuenta.php';?>
    <?php
      $id= $_SESSION["id"];
        include_once dirname(__FILE__) . '/config.php';
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Cuentas WHERE idUsuario=$id") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th># Cuenta</th>
                    <th>Saldo</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idCuenta'];?></td>
                    <td><?php echo $row['saldoCuenta'];?></td>
                    <td>
                        <a href="movimientos_cuenta.php?retiro=<?php echo $row['idCuenta'];?>">Retirar</a>
                        <a href="movimientos_cuenta.php?consignacion=<?php echo $row['idCuenta'];?>">Consignar</a>
                        <a href="manejar_tarjetas.php?idcuenta=<?php echo $row['idCuenta'];?>">Tarjetas</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <form action="" method="POST">
    <input type="submit" name="crearCuenta" value="CrearCuenta"><br>
    </form>
    <a href="cliente.php">Regresar</a><br>
    <?php
    if(isset($_POST['crearCuenta'])){
      echo "Se inserto una nueva cuenta";
      $conn->query("INSERT INTO cuentas (idCuenta, idUsuario, saldoCuenta) VALUES (NULL, $id, 0)") or die($conn->error);
      header("location: manejar_cuentas.php");
    }
    ?>
    </div>
</body>
</html>

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
<body>
    <h1>Gestionar Tarjetas de Crédito</h1>
    <?php require_once 'procesar_tarjetas.php';?>
    <?php
        include_once dirname(__FILE__) . '/config.php';
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Tarjetas") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th># Tarjeta</th>
                    <th># Cuenta</th>
                    <th>Cupo</th>
                    <th>Sobrecupo</th>
                    <th>Interés</th>
                    <th>Cuota Manejo</th>
                    <th>Aprobada</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['numeroTarjeta'];?></td>
                    <td><?php echo $row['idCuenta'];?></td>
                    <td><?php echo $row['cupoTajeta'];?></td>
                    <td><?php echo $row['sobreCupo'];?></td>
                    <td><?php echo $row['interes'];?></td>
                    <td><?php echo $row['cuotaManejo'];?></td>
                    <td><?php echo $row['tarjetaPendiente'];?></td>
                    <td>
                        <a href="gestionar_tarjetas.php?edit=<?php echo $row['numeroTarjeta'];?>">Editar</a>
                        <a href="procesar_tarjetas.php?del=<?php echo $row['numeroTarjeta'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form action="procesar_tarjetas.php" method="POST">
        <h4>Formulario para editar</h4>
        <p>Primero de click en la tarjeta que quiere editar para activar la funcionalidad</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <br><br>
            Cupo: <input type="number" name="nCupo" value="<?php echo $cupo?>">
            <br><br>
            Sobre Cupo: <input type="number" name="nScupo" value="<?php echo $scupo?>">
            <br><br>
            Interés: <input type="number" name="nInt" value="<?php echo $interes?>">
            <br><br>
            Cuota Manejo: <input type="number" name="nCuota" value="<?php echo $cuota?>">
            <br><br>
            <?php if($apro == 1): ?>
                <input type="radio" name="apro" value="1" checked=true> Aprobar<br>
                <input type="radio" name="apro" value="0">Rechazar<br>
            <?php elseif($apro == 0): ?>
                <input type="radio" name="apro" value="1"> Aprobar<br>
                <input type="radio" name="apro" value="0" checked=true>Rechazar<br>
            <?php endif; ?>
            <button type="submit" name="guardar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>

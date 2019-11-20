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


<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Gestionar Créditos</h1>
    <?php require_once 'procesar_creditos.php';?>
    <?php
        include_once dirname(__FILE__) . '/config.php';
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Creditos") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Id Crédito</th>
                    <th>Id Usuario</th>
                    <th>Fecha</th>
                    <th>Valor</th>
                    <th>Interés</th>
                    <th>Aprobado</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idCredito'];?></td>
                    <td><?php echo $row['idUsuario'];?></td>
                    <td><?php echo $row['fechaCredito'];?></td>
                    <td><?php echo $row['valorCredito'];?></td>
                    <td><?php echo $row['interesCredito'];?></td>
                    <td><?php echo $row['creditoPendiente'];?></td>
                    <td>
                        <a href="gestionar_creditos.php?edit=<?php echo $row['idCredito'];?>">Editar</a>
                        <a href="procesar_creditos.php?del=<?php echo $row['idCredito'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form action="procesar_creditos.php" method="POST">
        <h4>Formulario para editar</h4>
        <p>Primero de click en el crédito que quiere editar para activar la funcionalidad</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <br><br>
            Fecha: <input type="date" name="nFecha" value="<?php echo $fecha?>">
            <br><br>
            Valor: <input type="number" name="nValor" value="<?php echo $valor?>">
            <br><br>
            Interés: <input type="number" name="nInt" value="<?php echo $interes?>">
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

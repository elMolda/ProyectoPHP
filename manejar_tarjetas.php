<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Mis Tarjetas</h1>
    <?php require_once 'movimientos_creditos.php';?>
    <?php
    include_once dirname(__FILE__) . '/config.php';
    if(isset($_GET['idcuenta'])){
        $idcuenta =$_GET['idcuenta'];
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM tarjetas WHERE idCuenta = $idcuenta") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Numero de Tarjeta</th>
                    <th>Cupo Tajeta</th>
                    <th>SobreCupo</th>
                    <th>Interés</th>
                    <th>Cuota Manejo</th>
                    <th>Tarjeta Pendiente</th>
                    <th colspan="1">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['numeroTarjeta'];?></td>
                    <td><?php echo $row['cupoTajeta'];?></td>
                    <td><?php echo $row['sobreCupo'];?></td>
                    <td><?php echo $row['interes'];?></td>
                    <td><?php echo $row['cuotaManejo'];?></td>
                    <td><?php echo $row['tarjetaPendiente'];?></td>
                    <td>
                        <a href="movimientos_tarjetas.php?pagar=<?php echo $row['numeroTarjeta'];?>">Consignar</a>
                    </td>
                </tr>
            <?php endwhile; }?>
        </table>
        <a href="cliente.php">Regresar</a><br><br>
    </div>
</body>
</html>

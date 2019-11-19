<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Editar Cuentas</h1>
    <?php require_once 'procesar_cuenta.php';?>
    <?php
        include_once dirname(__FILE__) . '/config.php'; 
        $conn = mysqli_connect(HOST_DB,USER_DB,USER_PASS,NAME_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Cuentas") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th># Cuenta</th>
                    <th>Id Usuario</th>
                    <th>Saldo</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idCuenta'];?></td>
                    <td><?php echo $row['idUsuario'];?></td>
                    <td><?php echo $row['saldoCuenta'];?></td>
                    <td>
                        <a href="gestionar_cuentas.php?edit=<?php echo $row['idCuenta'];?>">Editar</a>
                        <a href="procesar_cuenta.php?del=<?php echo $row['idCuenta'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form action="procesar_cuenta.php" method="POST">
        <h4>Formulario para editar</h4>
        <p>Primero de click en la cuenta que quiere editar para activar la funcionalidad</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <br><br>
            Nuevo Saldo: <input type="number" name="nSaldo" value="<?php echo $saldo?>">
            <button type="submit" name="guardar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
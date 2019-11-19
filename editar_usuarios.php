<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Editar Usuarios</h1>
    <?php require_once 'procesar_usr.php';?>
    <?php
        include_once dirname(__FILE__) . '/config.php'; 
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Usuarios") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Id Usuario</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th colspan="2">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idUsuario'];?></td>
                    <td><?php echo $row['nombreUsuario'];?></td>
                    <td><?php echo $row['tipoUsuario'];?></td>
                    <td>
                        <a href="editar_usuarios.php?edit=<?php echo $row['idUsuario'];?>">Editar</a>
                        <a href="procesar_usr.php?del=<?php echo $row['idUsuario'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form action="procesar_usr.php" method="POST">
        <h4>Formulario para editar</h4>
        <p>Primero de click en el usuario que quiere editar para activar la funcionalidad</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <br><br>
            Nombre Usuario: <input type="text" name="nomUsr" value="<?php echo $nombreUsuario?>">
            <br><br>
            Tipo Usuario: <select name="tipoUsr">
                <option value="Admin">Administrador</option>
                <option value="Cliente">Cliente</option>
            </select>
            <br><br>
            <button type="submit" name="guardar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
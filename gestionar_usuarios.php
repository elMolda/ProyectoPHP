<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Editar Usuarios</h1>
    <?php require_once 'procesar_usuarios.php';?>
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
                        <a href="gestionar_usuarios.php?edit=<?php echo $row['idUsuario'];?>">Editar</a>
                        <a href="procesar_usuarios.php?del=<?php echo $row['idUsuario'];?>">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <form action="procesar_usuarios.php" method="POST">
        <h4>Formulario para editar</h4>
        <p>Primero de click en el usuario que quiere editar para activar la funcionalidad</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <br><br>
            Nombre Usuario: <input type="text" name="nomUsr" value="<?php echo $nombreUsuario?>">
            <br><br>
            Tipo Usuario:
            <br><br>
            <?php if($tipo == 'admin'): ?>
                <input type="radio" name="tipoUsr" value="admin" checked=true>Administrador<br>
                <input type="radio" name="tipoUsr" value="user">Cliente<br>
            <?php elseif($tipo == 'user'): ?>
                <input type="radio" name="tipoUsr" value="admin">Administrador<br>
                <input type="radio" name="tipoUsr" value="user" checked=true>Cliente<br>
            <?php endif; ?>
            <button type="submit" name="guardar">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>
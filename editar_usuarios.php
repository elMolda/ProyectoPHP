<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Editar Usuarios</h1>
    <?php
        include_once dirname(__FILE__) . '/config.php'; 
        $conn = mysqli_connect(HOST_DB,USER_DB,USER_PASS,NAME_DB);
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
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idUsuario'];?></td>
                    <td><?php echo $row['nombreUsuario'];?></td>
                    <td><?php echo $row['tipoUsuario'];?></td>
                    <td></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
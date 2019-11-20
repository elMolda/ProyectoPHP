<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Mis Créditos</h1>
    <?php require_once 'movimientos_creditos.php';?>
    <?php
    $id = 1;
        include_once dirname(__FILE__) . '/config.php';
        $conn=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);
        if($conn){
            $result = $conn->query("SELECT * FROM Creditos WHERE idUsuario = $id AND creditoPendiente = 1") or die($conn->error);
        }
    ?>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Id Crédito</th>
                    <th>Fecha</th>
                    <th>Valor</th>
                    <th>Interés</th>
                    <th>saldoPendiente</th>
                    <th colspan="1">Acción</th>
                </tr>
            </thead>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['idCredito'];?></td>
                    <td><?php echo $row['fechaCredito'];?></td>
                    <td><?php echo $row['valorCredito'];?></td>
                    <td><?php echo $row['interesCredito'];?></td>
                    <td><?php echo $row['saldoPendiente'];?></td>
                    <td>
                        <a href="movimientos_creditos.php?consignar=<?php echo $row['idCredito'];?>">Consignar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="cliente.php">Regresar</a><br><br>
        <h4>Formulario para crear credito</h4><br>
        <form action="" method="POST">
          Fecha: <input type="date" name="nFecha"><br>
          Valor: <input type="number" name="nValor"><br>
          <input type="checkbox" name="interesEstandar"> Usar interes estandar <br>
          Ingrese su interés: <input type="number" name="nInt"><br>
          <input type="submit" name="submitcredito" value="EnviarCredito"><br>
        </form>

        <?php
        if(isset($_POST['submitcredito'])){
              echo "string";
              $nFecha = date('YYYY-MM-DD', strtotime($_POST['nFecha']));
              $nValor = $_POST['nValor'];
              if(isset($_POST['interesEstandar'])){
                $nInt = $interes;
                $apro = 1;
              }
              else {
                $nInt = $_POST['nInt'];
                $apro = 0;
              }
              echo "Se inserto una nuevo credito";
              $conn->query("INSERT INTO creditos (idCredito, idUsuario, fechaCredito, valorCredito, interesCredito, saldoPendiente,creditoPendiente)
              VALUES (NULL, $id, $nFecha, $nValor, $nInt, $nValor, $apro)") or die($conn->error);
              header("location: manejar_creditos.php");
            }

         ?>

    </div>
</body>
</html>

<html>

<head>
    <meta charset="utf-8">
</head>

<body>

    <h1>Panel de Visitante</h1>

    <form action="">
        Ingrese su correo: <input type="email" name="email">
        <input type="submit" name="enviarCorreo">
    </form>

    <a href="cliente.php">Regresar</a><br><br>
    <h4>Formulario para crear credito</h4><br>
    <form action="" method="POST">
      Fecha: <input type="date" name="nFecha"><br>
      Valor: <input type="number" name="nValor"><br>
      <input type="submit" name="submitcredito" value="EnviarCredito"><br>
    </form>

    <?php
    $id = 0;
    $fecha = '';
    $valor = 0;
    $interes = 0;
    if(isset($_POST['submitcredito'])){
          $nFecha = $_POST['nFecha'];
          echo ($nFecha);
          $nValor = $_POST['nValor'];
          $nInt = $interes;
          $apro = 0;
          echo "Se inserto una nuevo credito";
          $conn->query("INSERT INTO creditos (idCredito, idUsuario, fechaCredito, valorCredito, interesCredito, saldoPendiente,creditoPendiente)
          VALUES (NULL, $id, $nFecha, $nValor, $nInt, $nValor, $apro)") or die($conn->error);
          header("location: manejar_creditos.php");
        }

     ?>

</body>

</html>

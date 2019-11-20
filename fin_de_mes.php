<?php
session_start();

date_default_timezone_set('America/Bogota');



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

$error = false;
if(isset($_POST["operaciones"])){
  $ops  = unserialize($_POST["operaciones"]);
  foreach($ops as $op){
    $sql = "INSERT INTO operaciones (idCuenta , monto ,descripcion) VALUES (\"$op[0]\" , \"$op[1]\" , \"$op[2]\");";
    if(mysqli_query($con,$sql)){

    }
    else{
      $error = true;
    }

    $sql = "UPDATE cuentas SET saldoCuenta = saldoCuenta+ $op[1] WHERE idCuenta = $op[0];";
    if(mysqli_query($con,$sql)){
    }
    else{
      $error = true;
    }


  }
  if($error){
    echo "Huubo un error al insertar en la base de datos<br>";
  }
  else{
    echo "Valores insertados con exito<br>";
  }

}

$user = $_GET["user"];
$query = "SELECT SUM(saldoCuenta) as suma FROM cuentas WHERE  idUsuario = \"$user\"; ";

$resultado = mysqli_query($con,$query);

$value = mysqli_fetch_object($resultado);
$suma =  $value->suma;

$query = "SELECT nombreUsuario  FROM usuarios WHERE  idUsuario = \"$user\"; ";

$resultado = mysqli_query($con,$query);

$value = mysqli_fetch_object($resultado);
$username =  $value->nombreUsuario;

$query = "SELECT valorCredito , fechaCredito  FROM creditos WHERE  idUsuario = \"$user\"; ";

$resultado = mysqli_query($con,$query);

$value = mysqli_fetch_object($resultado);
$valor =  $value->valorCredito;
$fechaCredito =  $value->fechaCredito;

$fechaCredito = obtenerFechaCredito($fechaCredito);

$opps = array();
$fallidas = array();

$query = "SELECT * FROM cuentas WHERE  idUsuario = \"$user\"; ";
$restante = $valor;
$resultado = mysqli_query($con,$query);

//saca la fecha de pago de este mes
$mesCorte = date("m");
$diaCorte = 31;
$anoCorte = date("y");
$fechaCorte= $anoCorte."-".$mesCorte."-".$diaCorte;
for($i =0 ; $i<4 ; $i++){
  if(checkdate($mesCorte , $diaCorte , $anoCorte)){
    $fechaCorte = $anoCorte."-".$mesCorte."-".$diaCorte;
    $diaSemana = date('w', strtotime($fechaCorte));
    if($diaSemana != 0 && $diaSemana != 6){
      break;
    }

  }
  $diaCorte--;

}

while($fila = mysqli_fetch_array($resultado)) {


  $temp =array($fila["idCuenta"] , $fila["cuotaManejo"]*-1, "Cuota de manejo", $fechaCorte)  ;
  if( $fila["cuotaManejo"] <  $fila["saldoCuenta"]){
    array_push($opps , $temp);


  }else{
    array_push($fallidas , $temp);
  }
  $temp =array($fila["idCuenta"]  , $fila["cuotaManejo"]*0.01, "intereses" , $fechaCorte)  ;
  array_push($opps , $temp);
}
if($suma >= $valor ){
  $puede = true;
  $tomado =array();

  $query = "SELECT * FROM cuentas WHERE  idUsuario = \"$user\" ORDER BY saldoCuenta DESC;";
  $restante = $valor;

  $resultado = mysqli_query($con,$query);
  while($fila = mysqli_fetch_array($resultado)) {
    if($restante > 0){
      if($fila["saldoCuenta"]  <= $restante){
        $restante -= $fila["saldoCuenta"];
        $temp =array($fila["idCuenta"]  , $fila["saldoCuenta"]*-1, "Pago de Intereses" , $fechaCredito)  ;

        array_push($opps , $temp);
        $sql = "INSERT INTO opps (idCuenta , monto ,descripcion) VALUES (\"$temp[0]\" , \"$temp[1]\" , \"$temp[2]\");";

      }
      else{

        $temp =array($fila["idCuenta"]  , $restante*-1, "Pago de Intereses" , $fechaCredito)  ;
        array_push($opps , $temp);
        $restante=0;
      }
    }

  }

}
else{
  $puede = false;
  $temp =array($fila["idCuenta"]  , $valor, "Pago de intereses")  ;
  array_push($fallidas , $temp);
}


 ?>

<h1> Acciones de fin de mes de <?php echo $username?></h1>
<h2> Operaciones realizadas </h2>
<table border="1">
  <thead>
      <tr>
          <th>cuenta</th>
          <th>Monto</th>
          <th>Descripcion </th>
          <th>Fecha de pago</th>
      </tr>
  </thead>
  <?php  foreach ($opps as  $value) {?>
    <tr>
        <td><?php echo $value[0];?></td>
        <td><?php echo $value[1];?></td>
        <td><?php echo $value[2];?></td>
        <td><?php echo $value[3];?></td>

      </tr>
  <?php } ?>

</table>

<h2> Operraciones fallidas</h2>



<table border="1">
  <thead>
      <tr>
          <th>Monto</th>
          <th>Descripcion </th>
      </tr>
  </thead>
  <?php  foreach ($fallidas as  $value) {?>
    <tr>
        <td><?php echo $value[1];?></td>
        <td><?php echo $value[2];?></td>



      </tr>
  <?php } ?>

</table>
<br><br>
<form action="fin_de_mes.php?user=<?php echo $_GET["user"]?>" method="POST">
<input type="hidden" name="operaciones" value="<?php echo  htmlentities(serialize($opps)); ?>">
<input type="submit" value="Aplicar cambios">
</form>
<br><br>
<form action="admin.php" method="POST">
<input type="submit" value="volver">
</form>



<?php
  function obtenerFechaCredito($ini){
    $fech = $ini;
    //saca la fecha de pago del creditos
    $diaSemana = date('w', strtotime($fech));
    if($diaSemana == 0 || $diaSemana == 6){
      $fech[9]= $fech[9]+1;

    }
    if($diaSemana == 0 || $diaSemana == 6){
      $fech[9]= $fech[9]+1;

    }
    return $fech;

  }

?>

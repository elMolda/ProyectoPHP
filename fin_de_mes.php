<?php
session_start();

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


if(isset($_POST["operaciones"])){
  $ops  = unserialize($_POST["operaciones"]);
  foreach($ops as $op){
    $sql = "INSERT INTO operaciones (idCuenta , monto ,descripcion) VALUES (\"$op[0]\" , \"$op[1]\" , \"$op[2]\");";
    if(mysqli_query($con,$sql)){
      echo "Insertado<br>";
    }
    else{
      echo "Error al insertar<br>";
    }
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

$query = "SELECT valorCredito  FROM creditos WHERE  idUsuario = \"$user\"; ";

$resultado = mysqli_query($con,$query);

$value = mysqli_fetch_object($resultado);
$valor =  $value->valorCredito;

$opps = array();
$fallidas = array();

$query = "SELECT * FROM cuentas WHERE  idUsuario = \"$user\"; ";
$restante = $valor;
$resultado = mysqli_query($con,$query);
while($fila = mysqli_fetch_array($resultado)) {

  $temp =array($fila["idCuenta"] , $fila["cuotaManejo"]*-1, "Cuota de manejo")  ;
  if( $fila["cuotaManejo"] <  $fila["saldoCuenta"]){
    array_push($opps , $temp);



  }else{
    array_push($fallidas , $temp);
  }
  $temp =array($fila["idCuenta"]  , $fila["cuotaManejo"]*0.01, "intereses")  ;
  array_push($opps , $temp);
}
if($suma >= $valor ){
  $puede = true;
  $tomado =array();

  $query = "SELECT * FROM cuentas WHERE  idUsuario = \"$user\"; ";
  $restante = $valor;

  $resultado = mysqli_query($con,$query);
  while($fila = mysqli_fetch_array($resultado)) {
    if($restante > 0){
      if($fila["saldoCuenta"]  <= $restante){

        $restante -= $fila["saldoCuenta"];
        $temp =array($fila["idCuenta"]  , $fila["saldoCuenta"]*-1, "Pago de Intereses")  ;

        array_push($opps , $temp);
        $sql = "INSERT INTO opps (idCuenta , monto ,descripcion) VALUES (\"$temp[0]\" , \"$temp[1]\" , \"$temp[2]\");";

      }
      else{

        $temp =array($fila["idCuenta"]  , $restante*-1, "Pago de Intereses")  ;
        array_push($opps , $temp);
        $restante=0;
      }
    }

  }

}
else{
  $puede = false;
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
      </tr>
  </thead>
  <?php  foreach ($opps as  $value) {?>
    <tr>
        <td><?php echo $value[0];?></td>
        <td><?php echo $value[1];?></td>
        <td><?php echo $value[2];?></td>

      </tr>
  <?php } ?>

</table>

<h2> Operraciones fallidas</h2>



<table border="1">
  <thead>
      <tr>
          <th>cuenta</th>
          <th>Monto</th>
          <th>Descripcion </th>
      </tr>
  </thead>
  <?php  foreach ($fallidas as  $value) {?>
    <tr>
        <td><?php echo $value[0];?></td>
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

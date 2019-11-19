<?php

  $respuestas  = new SplFixedArray(5);


  if(isset($_POST["usuario"])){

    $username = $_POST["usuario"];
    $cont = hash('sha1', $_POST["contraseña"]);
    $rol = $_POST["tipo"];
    include_once dirname(__FILE__) . '/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS , NOMBRE_DB);
    $sql = "INSERT INTO Usuarios (nombreUsuario , contraUsuario , tipoUsuario) VALUES (\"$username\" , \"$cont\" , \"$rol\");";


      if (mysqli_query($con,$sql)) {
        echo "Usuario insertado en la base de datos con rol de ".$rol;
      }
      else {
        echo "Error al insertar el usuario" . mysqli_error($con);
      }


    mysqli_close($con);

  }
  $output = "";
  $myArray = array( 'usuario' =>  'text',
  'contraseña' => 'password' );
  
  $output .= "<h1> Register</h1><br>";
  $output .= "<form action=\"register.php\" method=\"post\">";
  $output .= process($myArray , $respuestas);
  $output .= "<a>Rol:</a><br>";
  $output .= "Admin <input type=\"radio\" checked=true value=\"admin\" name=\"tipo\">";
  $output .= "<br>User <input type=\"radio\" checked=true value=\"user\" name=\"tipo\"><br><br>";
  $output .= "<input type=\"submit\" value=\"Registrar\">";
  $output .= "</form>";
  $output.= "<form action = \"index.php\" method=\"post\">";
  $output.= "<input type=\"submit\" value=\"Ir a login\">";
  $output.= "</form>";

  echo $output;

  function process($elementos  , $res){
    $output = "";
    $i = 0;
    foreach ($elementos as $key => $value) {

      if($value === "button"){
       $output .= "<button>" . $key . "</button><br>";
      }
      else{
       $output .= $key;
       $output .= "<br><input type=" . $value . " name= ". $key." value =".$res [$i].">";
       $output .= "</input><br>";
       $i++;
      }

    }



    return  $output;
  }
 ?>

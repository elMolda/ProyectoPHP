
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>

<body>

  <?php
    include_once dirname(__FILE__) . '/config.php';
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS, NOMBRE_DB);

    $output = "";


    $output .= "<h1> Log in</h1><br>";
    $output .= "<form action=\"validar.php\" method=\"post\" >";
    $output .= "<input type=\"text\"  name=\"username\" value=\"username\"><br>";
    $output .= "<input type=\"password\"  name=\"contra\" value=\"contra\"><br>";
    $output .= "<input type=\"submit\" value=\"Entrar\"><br><br>";
    $output .= "</form>";
    $output .= "<form action=\"register.php\" method=\"post\" >";
    $output .= "<input type=\"submit\" value=\"Ir a register\">";
    $output .= "</form>";
    echo $output;


    mysqli_close($con);


   ?>


</body>

</html>

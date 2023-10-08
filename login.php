<?php
session_start();
$_SESSION['logged'] = false;
$msg="";
$email="";
$password="";
if(isset($_POST['email']) && isset($_POST['password'])) {
  if ($_POST['email']==""){
    $msg.="Debe ingresar un email <br>";
  }else if ($_POST['password']=="") {
    $msg.="Debe ingresar la clave <br>";
  }else {
    $email = strip_tags($_POST['email']);
    $password= sha1(strip_tags($_POST['password']));
    //momento de conectarnos a db
    $conn = mysqli_connect("localhost","admin_ngiot","121212","admin_nicolas");
    if ($conn==false){
      echo "Hubo un problema al conectarse a María DB";
      die();
    }
    $result = $conn->query("SELECT * FROM `users` WHERE `users_email` = '".$email."' AND  `users_password` = '".$password."' ");
    $users = $result->fetch_all(MYSQLI_ASSOC);
    //cuento cuantos elementos tiene $tabla,
    $count = count($users);
    if ($count == 1){
      //cargo datos del usuario en variables de sesión
      $_SESSION['users_id'] = $users[0]['users_id'];
      $_SESSION['users_email'] = $users[0]['users_email'];
      $msg .= "Exito!!!";
      $_SESSION['logged'] = true;
       echo '<meta http-equiv="refresh" content="2; url=dashboard.php">';
    }else{
      $msg .= "Acceso denegado!!!";
      $_SESSION['logged'] = false;
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Página de inicio de sesión</title>
    <link rel="stylesheet" type="text/css" href="./css/logueo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form id="loginForm" method="post" name="form">
            <div class="form-group">
                <input type="email" name="email"  id="username" placeholder="Correo electrónico"  value="<?php echo $email ?>" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
            </div>
            <button type="submit">Iniciar sesión</button>
            <p class="register-link">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </form>

    </div>
    <br>
    <br>
    <div  class="alerta">
        <?php echo $msg ?>
      </div>
   
</body>

</html>
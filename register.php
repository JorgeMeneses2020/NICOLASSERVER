<?php 
//momento de conectarnos a db
$conn = mysqli_connect("localhost", "admin_ngiot","121212", "admin_nicolas"); 
if ($conn==false){
    echo "Hubo un problema al conectarse a María DB"; 
    die();
}

//declaramos variables vacias servirán también para repoblar el formulario $email = "";
$password = "";
$password_r = "";
$msg = "";
$email="";


if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_r'])) {

    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']); 
    $password_r= strip_tags($_POST['password_r']);
    
    if ($password==$password_r) {
    
    //aquí como todo estuvo OK, resta controlar que no exista previamente el mail ingresado en la tabla users. $result = $conn->query("SELECT * FROM `users` WHERE `users_email` = '".$email." "); $users = $result->fetch_all (MYSQLI_ASSOC);
    $result = $conn->query("SELECT * FROM `users` WHERE `users_email` = '".$email."' ");
    $users = $result->fetch_all(MYSQLI_ASSOC);
   //cuento cuantos elementos tiene $tabla,
   
   $count =count($users);
   if ($count == 0){
    $password = sha1($password); //encriptar clave con shal
    $conn->query("INSERT INTO `users` (`users_email`, `users_password`) VALUES ('".$email."', '".$password."');");
    $msg="Usuario creado correctamente, ingrese haciendo <a href='login.php'>clic aquí</a> <br>"; 
 
     }else{
     $msg="El mail ingresado ya existe <br>";
     } 
   
   //solo si no hay un usuario con mismo mail, procedemos a insertar fila con nuevo usuario
  
    }
    else {
    $msg = "Las claves no coinciden"; 
    }
}else{
    $msg="Complete el formulario";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HUERTAS ING</title>
    <link rel="icon" type="image/png" href="./img/icon.png">
    <link rel="stylesheet" type="text/css" href="./css/logueo.css">
</head>

<body>
    <div class="container">

        <h2>Registrate</h2>
    <form method="POST" target="register.php">
        <div class="form-group">
            <input type="email" name="email" id="email" placeholder="Correo electrónico" value="<?php echo $email;?>"required>

        </div>

        <div class="form-group">
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
        </div>

        <div class="form-group">
            <input type="password" name="password_r" id="password_r" placeholder="Contraseña" required>
        </div>
        <button type="submit">Registrarse</button>
    </form>
        <br><br>

    <div  class="alerta">
        <?php echo $msg ?>
         </div>

        <br>

        <div class="p-v-lg text-center">

            <div>Already have an account? <a ui-sref="access.signin" href="login.php" class="text-primary_600">Sign
                    in</a></div>
        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>
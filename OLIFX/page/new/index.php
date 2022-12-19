<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL); // mesmo resultado de: error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["button"])) {
    // If the user didn't choose a profile picture, set the default one.
    if ($_FILES["profilepic"]["name"] == "") $_FILES["profilepic"]["name"] = "default.png";
    
    $user = new User();
    $user->constructorCreate(
        trim($_POST["email"]),
        trim($_POST["cellphone"]),
        trim($_POST["fullname"]),
        $_POST["password"],
        trim($_POST["city"])
    );
    $user->setProfilePic($_FILES);
    $user->save();
    
    header("location: ../login/");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">
  <title>OLIFX | Create Account</title>
  <link rel="stylesheet" href="new.css">
</head>
<body>
    <section class="form">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <h1 class="title-in-box">Create Account</h1>

            <label for="fullname">Full name</label>
            <input type="text" name="fullname" id="fullname" required>

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required>

            <label for="cellphone">Phone number</label>
            <input type="tel" name="cellphone" id="cellphone" value="" maxlength="15" minlength="15" required onChange="contactSeparators()">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="city">City</label>
            <input type="text" name="city" id="city" required>

            <label for="profilepic">Profile picture</label>
            <input type="file" name="profilepic" id="profilepic">

            <input type="submit" value="Create" name="button">
        </form>
    </section>
    <script>
        function mascara(o,f){
            v_obj=o
            v_fun=f
            setTimeout("execmascara()",1)
        }
        function execmascara(){
            v_obj.value=v_fun(v_obj.value)
        }
        function mtel(v){
            v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
            v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
            v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
            return v;
        }
        function id( el ){
            return document.getElementById( el );
        }
        window.onload = function(){
            id('cellphone').onkeyup = function(){
                mascara( this, mtel );
            }
        }
    </script>
</body>
</html>

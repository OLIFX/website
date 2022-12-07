<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "../../settings/config.php";
session_start();
if (isset($_SESSION['idUser'])) {
    $user = User::find($_SESSION['idUser']);
    if (isset($_POST["button"])) {
        if ($_FILES["profilepic"]["name"] == "") $_FILES["profilepic"]["name"] = "default.jpg";
        // var_dump($_POST);
        // die();
        $user->setFullName($_POST['name']);
        $user->setEmail($_POST['email']);
        $user->setCellphone($_POST['cellphone']);
        $user->setCity($_POST['city']);
        $user->setProfilePic($_FILES);
        if ($user->save()) {
            // echo "<script>alert('Your profile was updated successfully!');</script>";
            header('location: ../home');
        } else {
            // echo "<script>alert('An error occured on update your profile');</script>";
            header('location: ./index.php');
        };
    }
} else {
    header("location: ../login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit your account</title>
</head>
<body>
    <div class="edit-account-container">
        <section class="edit-account-form">
            <form action="index.php" method="post">
                <h1 class="edit-account-form-title">Edit your account</h1>

                <label for="name">Full name</label>
                <input type="text" name="name" id="name" value="<?php echo $user->getFullName()?>" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?php echo $user->getEmail()?>" required>

                <label for="cellphone">Phone number</label>
                <input type="tel" name="cellphone" id="cellphone" value="<?php echo $user->getCellphone()?>" maxlength="15" minlength="15" required onChange="contactSeparators()">
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

                <label for="city">City</label>
                <input type="text" name="city" id="city" value="<?php echo $user->getCity()?>" required>

                <label for="profilepic">Profile picture</label>
                <input type="file" name="profilepic" id="profilepic" value=<?php echo $user->getProfilePic()?>>

                <input type="submit" value="Edit" name="button">
            </form>
        </section>
    </div>
</body>
</html>
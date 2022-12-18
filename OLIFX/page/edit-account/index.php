<?php
require_once "../../settings/config.php";
session_start();
if (isset($_SESSION['idUser'])) {
    $user = User::find($_SESSION['idUser']);
    if (isset($_POST["button"])) {
        $haveProfilePic = true;
        if ($_FILES["profilepic"]["name"] == "") {
            $haveProfilePic = false;
        }

        $user->setFullName(trim($_POST['name']));
        $user->setEmail(trim($_POST['email']));
        $user->setCellphone(trim($_POST['cellphone']));
        $user->setCity(trim($_POST['city']));
        
        if ($haveProfilePic) {
            $user->setProfilePic($_FILES);
        }
        
        if ($user->save()) {
            header('location: ../home');
        } else {
             echo "<script>alert('An error occured on update your profile');</script>";
        };
    }
} else {
    header("location: ../login");
}

$lang = $_SESSION['language'];

$file_content = file_get_contents("../../assets/translate/{$lang}.json");
$content = json_decode($file_content, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $content['editAccount']['title'] ?></title>
</head>
<body>
    <div class="edit-account-container">
        <!-- <div class="languages-area">
            <img style="border: none;" src="../../assets/images/world-icon.png" alt="world-icon">
            <div class="language-dropdown">
                <a href="./index.php?language=pt-br">pt-br</a>
                <a href="./index.php?language=en-us">en-us</a>
            </div>
        </div> -->
        <section class="edit-account-form">
            <form action="index.php" method="post" enctype="multipart/form-data">
                <h1 class="edit-account-form-title"><?php echo $content['editAccount']['title'] ?></h1>

                <label for="name"><?php echo $content['editAccount']['fullName'] ?></label>
                <input type="text" name="name" id="name" value="<?php echo $user->getFullName()?>" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?php echo $user->getEmail()?>" required>

                <label for="cellphone"><?php echo $content['editAccount']['telephone'] ?></label>
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

                <label for="city"><?php echo $content['editAccount']['city'] ?></label>
                <input type="text" name="city" id="city" value="<?php echo $user->getCity()?>" required>

                <label for="profilepic"><?php echo $content['editAccount']['profilePic'] ?></label>
                <input type="file" name="profilepic" id="profilepic">

                <input type="submit" value="<?php echo $content['editAccount']['edit'] ?>" name="button">
            </form>
        </section>
    </div>
</body>
</html>
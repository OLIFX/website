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


$directory = "../../database/users/";

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
    <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">

    <link rel="stylesheet" href="../home/style.css">    

    <link rel="stylesheet" href="style.css">
    <title><?php echo $content['editAccount']['title'] ?></title>

</head>
<body>
    <div class="edit-account-container">
        <div class="user-area">
            <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
        </div>

        <div class="dropdown" style="display: none">
            <a href="../edit-account/">Edit your account</a>
            <a href="../yours">Your products</a>
            <a href="../login/logout.php">Log out</a>
        </div>
        
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
                        v=v.replace(/\D/g,""); //Remove tudo o que n??o ?? d??gito
                        v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca par??nteses em volta dos dois primeiros d??gitos
                        v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca h??fen entre o quarto e o quinto d??gitos
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

        <div class="bottom-navigation">

            <a href="../home">
                <div class="anchor">
                    <img src="../../assets/icons/home-o.png" alt="Home" class="home">
                </div>
            </a>

            <a href="../favorites">
                <div class="anchor">
                    <img src="../../assets/icons/star-o.png" alt="Home" class="home">
                </div>
            </a>

            <a href="../post">
                <div class="anchor">
                    <img src="../../assets/icons/new-o.png" alt="Home" class="home">
                </div>
            </a>
        </div>

        
    </div>

    <script src="../home/main.js"></script>
</body>
</html>
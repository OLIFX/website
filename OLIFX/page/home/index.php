<?php

require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}

$products = Product::findall();
$directory = "../../database/users/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <script src="main.js"></script>
    <title>OLIFX | Home</title>
</head>
<body>
    <div class="container">
        <div class="superior-part">
            <div class="superior-elements">
                <input type="text" class="search" placeholder="Search something...">
                
                <div class="user-area">
                    <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
                </div>
                
                <div class="dropdown">
                    <a href="../edit-account/">Edit your account</a>
                    <a href="../edit-account/">Your products</a>
                    <a href="../login/logout.php">Log out</a>
                </div>
                
                <span class="home-welcome">Welcome, <?php echo $_SESSION["fullName"]?>!</span>
            </div>
        </div>

        <div class="middle-part">
            <?php
                if (count($products) <= 0) {
                    echo "<div class=\"card\">";
                    echo "<img src=\"../../assets/images/item.png\" alt=\"Default icon\">";

                    echo "<p class=\"card-title\">This is an example of a title... Some stuff here</p>";
                    echo "<p class=\"card-description\">This is an example of a description... Lorem ipsum dolor sit amet consectetur adipisicing elit</p>";

                    echo "<p class='card-price'>R$ 00,00</p>";

                    echo "</div>";
                }

                foreach($products as $product) {
                    
                    $id = $product->getIdProduct();
                    if(Media::existeMediaProduto($id)){
                        $img = Media::findMediaByProduct($id);
                        echo "<div class=\"card\">";
                        echo "<img src=\"../../database/media/{$img->getPath()}\" alt=\"Default icon\">";
                    }else{
                        
                        echo "<div class=\"card\">";
                        echo "<img src=\"../../assets/images/item.png\" alt=\"Default icon\">";
                    }
                    
                    echo "<p class=\"card-title\">{$product->getTitle()}</p>";
                    echo "<p class=\"card-description\">{$product->getDescription()}</p>";
                    
                    $publisher = User::findUserFullNameByIdUser($product->getIdUser());
                    $datetime = date_create($product->getDate_time());
                    $dateFormatted = date_format($datetime, "m/d/Y");
                    echo "<p class=\"card-published\"><em>Posted by</em> <strong>{$publisher}</strong> <em>at</em> {$dateFormatted}</p>";
                    
                    $value = number_format($product->getPrice(), 2, ",", ".");
                    echo "<p class='card-price'>R$ {$value}</p>";

                    echo "</div>";
                }
            ?>
        </div>

        <div class="bottom-navigation">

            <a href="#">
                <div class="anchor selected">
                    <img src="../../assets/icons/home.png" alt="Home" class="home selected">
                </div>
            </a>

            <a href="#">
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

    <script src="main.js"></script>
</body>
</html>

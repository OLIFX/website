<?php
require_once "../../settings/config.php";
session_start();
if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

if (!isset($_GET['id'])) {
    header("location: ../home");
}

$pageOfFavoriteProduct = false;

if (isset($_POST["idProduct"])) {
    $fav = new Favorite();
    
    $fav->setIdUser($_SESSION["idUser"]);
    $fav->setIdProduct($_POST["idProduct"]);
    
    $fav->save();
    $pageOfFavoriteProduct = true;
}

try {
    $product = Product::find($_GET['id']);
} catch (TypeError $error) {
    header("location: ../home");
}

$pageOfFavoriteProduct = $product->verifyIfUserHasFavorite($_SESSION["idUser"]);

$directory = "../../database/users/";
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
    <link rel="stylesheet" href="../home/nav.css">
    
    <title>View Product | <?php echo $product->getTitle() ?> </title>
</head>
<body>
    <div class="view-product-container">
        <div class="user-area">
            <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
        </div>

        <div class="dropdown" style="display: none">
            <a href="../edit-account">Edit your account</a>
            <a href="../yours">Your products</a>
            <a href="../login/logout.php">Log out</a>
        </div>
        
        <div class="product-datas">
            <div class="product-title">
                <h1><?php echo $product->getTitle() ?></h1>
            </div>
            <div class="product-image">
                <?php 
                $id = $product->getIdProduct();
                if(Media::existeMediaProduto($id)){
                    $img = Media::findMediaByProduct($id);
                    echo "<img src=\"../../database/media/{$img->getPath()}\" alt=\"Default icon\">";
                }else{
                    echo "<img src=\"../../assets/images/item.png\" alt=\"Default icon\">";
                }
                ?>
            </div>
            <div class="product-infos">
                <p class="product-info-camp">
                    <span class="info-camp-title">Price: </span>
                    <span class="info-camp-data"><?php echo "R$".number_format($product->getPrice(), 2, ',', '.') ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title">Posted data: </span>
                    <span class="info-camp-data"><?php  
                    $date = date_create($product->getDate_time());
                    echo date_format($date, 'd/m/Y');  
                    ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title">Description: </span>
                    <span class="info-camp-data"><?php echo $product->getDescription() ?></span>
                </p>
            </div>
            <div class="buttons-area">
                <?php 
                    if ($pageOfFavoriteProduct) {
                        echo "<form method=\"post\" action='undo.php?id={$id}'>";
                        $fav = "Unfavorite this";
                        $classFav = "favorited";
                    } else {
                        echo "<form method=\"post\" action='?id={$id}'>";
                        $fav = "Favorite this";
                        $classFav = "";
                    }
                    echo "<input type='number' name='idProduct' value='{$id}' hidden>";
                    echo "<input type='submit' name='favorite' value='{$fav}' class='favorite-button $classFav'>";
                ?>
                </form>
                
                <!-- Link para a API do WhatsApp com o número -->
                <a href="#" class="contact-button">Contact via WhatsApp</a>
            </div>
        </div>


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

        <?php include "../home/nav.php" ?>
        
    </div>

    <script src="../home/main.js"></script>
</body>
</html>
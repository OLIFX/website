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
    <title><?php echo $content['productPage']['viewProduct'] ?> | <?php echo $product->getTitle() ?> </title>
</head>
<body>
    <div class="view-product-container">
        <div class="user-area">
            <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
        </div>

        <div class="dropdown">
        <a href="../edit-account/"> <?php echo $content['homepage&Favorites']['dropdown']['editAccount'] ?></a>
        <a href="../edit-account/"><?php echo $content['homepage&Favorites']['dropdown']['yourProducts'] ?></a>
        <a href="../login/logout.php"><?php echo $content['homepage&Favorites']['dropdown']['logout'] ?></a>
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
                    <span class="info-camp-title"><?php echo $content['productPage']['price'] ?>: </span>
                    <span class="info-camp-data"><?php echo "R$".number_format($product->getPrice(), 2, ',', '.') ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title"><?php echo $content['productPage']['data'] ?>: </span>
                    <span class="info-camp-data"><?php  
                    $date = date_create($product->getDate_time());
                    echo date_format($date, 'd/m/Y');  
                    ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title"><?php echo $content['productPage']['description'] ?>: </span>
                    <span class="info-camp-data"><?php echo $product->getDescription() ?></span>
                </p>
            </div>
            <div class="buttons-area">
                <?php 
                    if ($pageOfFavoriteProduct) {
                        echo "<form method=\"post\" action='undo.php?id={$id}'>";
                        $fav = "{$content['productPage']['unfavorite']}";
                        $classFav = "favorited";
                    } else {
                        echo "<form method=\"post\" action='?id={$id}'>";
                        $fav = "{$content['productPage']['favorite']}";
                        $classFav = "";
                    }
                    echo "<input type='number' name='idProduct' value='{$id}' hidden>";
                    echo "<input type='submit' name='favorite' value='{$fav}' class='favorite-button $classFav'>";
                ?>
                </form>
                <?php
                
                $link = Product::whatsApp($product->getIdUser());
                echo "<a href='{$link}' class='contact-button'>$content['productPage']['contact']</a>";
                
                
                ?>
                
                
                
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
        
    </div>

    <script src="../home/main.js"></script>
</body>
</html>
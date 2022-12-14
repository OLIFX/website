<?php
require_once "../../settings/config.php";
session_start();
if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}
$product = Product::find($_GET['idProduct']);
$directory = "../../database/users/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>View Product | <?php echo $product->getTitle() ?> </title>
</head>
<body>
    <div class="view-product-container">
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
                    <span class="info-camp-data"><?php echo "R$".$product->getPrice() ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title">Posted data: </span>
                    <span class="info-camp-data"><?php echo $product->getDate_time() ?></span>
                </p>
                <p class="product-info-camp">
                    <span class="info-camp-title">Description: </span>
                    <span class="info-camp-data"><?php echo $product->getDescription() ?></span>
                </p>
            </div>
            <div class="buttons-area">
                <input type="submit" value="Favourite" class="favourite-button">
                <input type="submit" value="Contact" class="contact-button">
            </div>
        </div>
    </div>
</body>
</html>
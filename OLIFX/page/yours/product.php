<?php
require_once "../../settings/config.php";
session_start();
if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

if (!isset($_GET['id'])) {
    header("location: ../home");
}


try {
    $product = Product::find($_GET['id']);
} catch (TypeError $error) {
    header("location: ./yours");
}

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
    <link rel="stylesheet" href="../view-product/style.css">
    <link rel="stylesheet" href="../yours/product.css">
    <title>See your product | <?php echo $product->getTitle() ?> </title>
</head>
<body>
<div class="view-product-container">
    <div class="user-area">
        <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
    </div>

    <div class="dropdown" style="display: none">
        <a href="../edit-account/">Edit your account</a>
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
            <!-- Link para a API do WhatsApp com o número -->
            <a class="contact-button red-btn" id="delete">Delete</a>
            <?php echo "<a href=\"./edit.php?id={$product->getIdProduct()}\" class=\"contact-button\">Edit</a>"; ?>
        </div>
    </div>
    
    
    <div class="confirm-delete" style="display: none">
        <p class="text-confirm-delete">Do you really want to delete this item?</p>
        
        <div class="delete-buttons">
            <a id="no-delete">No</a>
            <?php echo "<a href=\"delete.php?id={$_GET["id"]}\">Yes</a>"; ?>
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
<script src="product.js"></script>
</body>
</html>
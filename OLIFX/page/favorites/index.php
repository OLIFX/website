<?php
require_once "../../settings/config.php";
session_start();
if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

$favorites = Favorite::findallByUser($_SESSION["idUser"]);

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
    <link rel="stylesheet" href="../home/nav.css">
    <title>OLIFX | Favorites</title>
</head>
<body>
<div class="container">
    <div class="superior-part">
        <div class="superior-elements">
            <form action="">
                <input name="s" type="text" class="search" placeholder="Search something...">
            </form>

            <div class="user-area">
                <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
            </div>

            <div class="dropdown" style="display: none">
                <a href="../edit-account/">Edit your account</a>
                <a href="../yours">Your products</a>
                <a href="../login/logout.php">Log out</a>
            </div>

            <span class="home-welcome">Welcome, <?php echo $_SESSION["fullName"]?>!</span>
        </div>
    </div>

    <div class="middle-part">
        <?php
            if (count($favorites) > 0) {
                foreach($favorites as $favorite) {
                    $product = Product::find($favorite->getIdProduct());
                    
                    $id = $product->getIdProduct();
                    echo "<div class=\"card\">";
                    
                    if (Media::existeMediaProduto($id)) {
                        $img = Media::findMediaByProduct($id);
                        echo "<img src=\"../../database/media/{$img->getPath()}\" alt=\"Default icon\">";
                    } else {
                        echo "<img src=\"../../assets/images/item.png\" alt=\"Default icon\">";
                    }
                    
                    echo "<a href=\"../view-product/?id={$product->getIdProduct()}\"><p class=\"card-title\">{$product->getTitle()}</p></a>";
                    echo "<p class=\"card-description\">{$product->getDescription()}</p>";

                    $publisher = User::findUserFullNameByIdUser($product->getIdUser());
                    $datetime = date_create($product->getDate_time());
                    $dateFormatted = date_format($datetime, "m/d/Y");
                    echo "<p class=\"card-published\"><em>Posted by</em> <strong>{$publisher}</strong> <em>at</em> {$dateFormatted}</p>";
                    
                    $datetime = date_create($favorite->getDate_time());
                    $dateFavorited = date_format($datetime, "m/d/Y");
                    echo "<p class=\"card-published\"><em>Favorited at</em> <strong>{$dateFavorited}</strong></p>";

                    $value = number_format($product->getPrice(), 2, ",", ".");
                    echo "<p class='card-price'>R$ {$value}</p>";

                    echo "</div>";
                }
            } else {
                echo "<div class='card'><p class='card-title'>No items favorited...</p></div>";
            }
        ?>
    </div>

    <div class="bottom-navigation">

        <a href="../home">
            <div class="anchor">
                <img src="../../assets/icons/home-o.png" alt="Home" class="home">
            </div>
        </a>

        <a href="../favorites">
            <div class="anchor selected">
                <img src="../../assets/icons/star.png" alt="Home" class="home selected">
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

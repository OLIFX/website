<?php

require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}

User::refreshSession();

if (isset($_GET["search"])) {
    $search = '%'.trim($_GET['search']).'%';
    $products = Product::findByTitle($search);
} else {
    $products = Product::findall();
}

$directory = "../../database/users/";

$lang = "en-us";
if (isset($_GET["language"]) && $_GET["language"] == "pt-br") {
  $lang = "pt-br";
}
$_SESSION['language'] = $lang;

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
    <link rel="stylesheet" href="style.css">
    <title>OLIFX | <?php echo $content['homepage&Favorites']['homepage'] ?></title>
</head>
<body>
    <div class="container">
        <div class="superior-part">
            <div class="superior-elements">
                <form action="./search.php" method="GET">
                    <input name="search" type="text" class="search" placeholder="<?php echo $content['homepage&Favorites']['search'] ?>">    
                </form>

                <div class="dropdowns-area">
                    
                    <div class="languages-area">
                        <img style="border: none; height: 30px; width: 30px;" src="../../assets/images/world_icon.svg" alt="world-icon">
                        <div class="language-dropdown">
                            <a href="./index.php?language=pt-br">pt-br</a>
                            <a href="./index.php?language=en-us">en-us</a>
                        </div>
                    </div>
                    
                    <div class="user-area">
                        <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
                    </div>
                    
    
                    <div class="dropdown">
                        <a href="../edit-account/"> <?php echo $content['homepage&Favorites']['dropdown']['editAccount'] ?></a>
                        <a href="../yours/"><?php echo $content['homepage&Favorites']['dropdown']['yourProducts'] ?></a>
                        <a href="../login/logout.php"><?php echo $content['homepage&Favorites']['dropdown']['logout'] ?></a>
                    </div>
                    
    
                    <span class="home-welcome"><?php echo $content['homepage&Favorites']['welcome'] ?> <?php echo $_SESSION["fullName"]?>!</span>
                </div>
            </div>
        </div>

        <div class="middle-part">
            <?php
                if (count($products) > 0) {
                    foreach($products as $product) {
                        $id = $product->getIdProduct();
                        if(Media::existeMediaProduto($id)){
                            $img = Media::findMediaByProduct($id);
                            echo "<div class=\"card\">";
                            echo "<img src=\"../../database/media/{$img->getPath()}\" alt=\"Default icon\">";
                        }else{

                            echo "<div class=\"card\">";
                            echo "<img src=\"../../assets/images/item.png\" alt=\"Default icon\">";
                            echo "<p class=\"card-title\">{$content['homepage&Favorites']['noProductsCard']['title']}</p>";
                            echo "<p class=\"card-description\">{$content['homepage&Favorites']['noProductsCard']['description']}</p>";
                        }
                        echo "<a href=\"../view-product/?id={$product->getIdProduct()}\"><p class=\"card-title\">{$product->getTitle()}</p></a>";
                        echo "<p class=\"card-description\">{$product->getDescription()}</p>";

                    

                        $publisher = User::findUserFullNameByIdUser($product->getIdUser());
                        $datetime = date_create($product->getDate_time());
                        $dateFormatted = date_format($datetime, "m/d/Y");
                        echo "<p class=\"card-published\"><em>Posted by</em> <strong>{$publisher}</strong> <em>at</em> {$dateFormatted}</p>";

                        $value = number_format($product->getPrice(), 2, ",", ".");
                        echo "<p class='card-price'>R$ {$value}</p>";

                        echo "</div>";
                    }
                } else {
                    echo "<div class=\"card\">";
                    if ($_GET["search"]) {
                        echo "<p class=\"card-title\">Nothing found</p>";
                    } else {
                        echo "<p class=\"card-title\">Nothing has been posted yet...</p>";
                    }

                    echo "<a href=\"../view-product/?id={$product->getIdProduct()}\"><p class=\"card-title\">{$product->getTitle()}</p></a>";
                    echo "<p class=\"card-description\">{$product->getDescription()}</p>";
                    
                    $publisher = User::findUserFullNameByIdUser($product->getIdUser());
                    $datetime = date_create($product->getDate_time());
                    $dateFormatted = date_format($datetime, "m/d/Y");
                    echo "<p class=\"card-published\"><em>{$content['homepage&Favorites']['card']['postedBy']}</em> <strong>{$publisher}</strong> <em>{$content['homepage&Favorites']['card']['midPart']}</em> {$dateFormatted}</p>";
                    
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

    <script src="main.js"></script>
</body>
</html>

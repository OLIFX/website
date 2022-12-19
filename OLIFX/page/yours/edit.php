<?php
require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}

if (isset($_POST["button"])) {
    // Price formatting
    $removedDots = str_replace(".", "", trim($_POST["price"]));
    $removedCommas = floatval(str_replace(",", ".", trim($removedDots)));

    // Description formatting
    $formattedTextDesc = trim(str_replace("\n", "</br>", $_POST["description"]));
    
    $product = new Product(trim($_POST["title"]), $formattedTextDesc, $removedCommas);
    $product->setIdProduct($_POST["idProduct"]);
//    
//    if ($_FILES["media"]["name"] != "") {
//        echo "Quer mudar";
//        die();
//    } else {
//        echo "Não quer mudar";
//        die();
//    }
    
    $product->save();
}

if (!isset($_GET["id"])) {
    header("location: ../yours");
}

$product = Product::find($_GET["id"]);

$directory = "../../database/users/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">
    <title>OLIFX | Edit product</title>
    <link rel="stylesheet" href="../new/new.css">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="../post/post.css">
    

    <!-- inclua o jQuery e o plugin de máscara -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
<div class="user-area">
    <img src="<?php echo $directory.$_SESSION["profilePic"]; ?>" alt="Default icon">
</div>

<div class="dropdown" style="display: none">
    <a href="../edit-account">Edit your account</a>
    <a href="../yours">Your products</a>
    <a href="../login/logout.php">Log out</a>
</div>

<section class="form">
    <?php
    echo "<form action='edit.php' method='POST' enctype=\"multipart/form-data\">";
        echo "<input type='hidden' name='idProduct' value='{$product->getIdProduct()}'>";
        
        echo "<h1 class=\"title-in-box\">Edit '{$product->getTitle()}'</h1>";
        
        echo "<label for=\"title\">Title</label>";
        echo "<input type=\"text\" name=\"title\" id=\"title\" value=\"{$product->getTitle()}\" required>";
        
        echo "<label for=\"description\">Description</label>";
        $desc = str_replace("</br>", "\n", $product->getDescription());
        echo "<textarea name=\"description\" id=\"description\" cols=\"30\" rows=\"10\">{$desc}</textarea>";
        
        echo "<label for=\"price\">Price</label>";
        echo "<input type=\"text\" name=\"price\" id=\"price\" value='". number_format($product->getPrice(), 2, ',', '.') ."' required>";
        ?>
        
        <label for="media">Image</label>
        <input type="file" name="media" id="media">

        <input type="submit" value="Post it" name="button">
    </form>
</section>

<!-- plugin mask -->
<script>
    $('#price').mask('#.##0,00', {reverse: true});
</script>


<div class="bottom-navigation">
    <a href="../home">
        <div class="anchor">
            <img src="../../assets/icons/home-o.png" alt="Home" class="home">
        </div>
    </a>

    <a href="../favorites">
        <div class="anchor">
            <img src="../../assets/icons/star-o.png" alt="Favorites" class="favorite">
        </div>
    </a>

    <a href="#">
        <div class="anchor">
            <img src="../../assets/icons/new-o.png" alt="New post" class="post">
        </div>
    </a>
</div>


<script src="../home/main.js"></script>
</body>
</html>

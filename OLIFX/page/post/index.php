<?php
require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}

if (isset($_POST["button"])) {
    $connection = new MySQL();
    $sql = "SELECT COUNT(*) + 1 as numero FROM product";
    $result = $connection->query($sql);
    $c = $result[0]['numero'];
    
    // Price formatting
    $removedDots = str_replace(".", "", trim($_POST["price"]));
    $removedCommas = floatval(str_replace(",", ".", trim($removedDots)));
    
    // Description formatting
    $formattedTextDesc = trim(str_replace("\n", "</br>", $_POST["description"]));
    
    $product = new Product(trim($_POST["title"]), $formattedTextDesc, $removedCommas);
    $product->setIdUser($_SESSION["idUser"]);
    
    $product->save();
    $media = new Media();
    $media->setIdProduct($c);
    $media->setPath($_FILES);
    $media->save();

    header("location: ../home");
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
    <title>OLIFX | Post a product</title>
    <link rel="stylesheet" href="../new/new.css">
    <link rel="stylesheet" href="../home/style.css">
    <link rel="stylesheet" href="post.css">

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
        <form action="index.php" method="post" enctype="multipart/form-data">
            <h1 class="title-in-box">Post a product</h1>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <label for="price">Price</label>
            <input type="text" name="price" id="price" required>

            <label for="media">Image</label>
            <input type="file" name="media" id="media" required>

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
                <img src="../../assets/icons/home-o.png" alt="Home" class="home selected">
            </div>
        </a>

        <a href="../favorites">
            <div class="anchor">
                <img src="../../assets/icons/star-o.png" alt="Favorites" class="favorite">
            </div>
        </a>

        <a href="#">
            <div class="anchor selected">
                <img src="../../assets/icons/new.png" alt="New post" class="post">
            </div>
        </a>
    </div>
    
    <script src="../home/main.js"></script>
</body>
</html>

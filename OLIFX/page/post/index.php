<?php
require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}

if (isset($_POST["button"])) {
    $product = new Product($_POST["title"], $_POST["description"], $_POST["price"]);
    $product->setIdUser($_SESSION["idUser"]);
    $product->save();

    header("location: ../home");
}

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
</head>
<body>
    <section class="form">
        <form action="index.php" method="post" enctype="multipart/form-data">
            <h1 class="title-in-box">Post a product</h1>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <label for="price">Price</label>
            <input type="number" name="price" id="price" required>

            <label for="media">Image</label>
            <input type="file" name="media" id="media" required>

            <input type="submit" value="Post it" name="button">
        </form>
    </section>
    <div class="bottom-navigation">
        <a href="../home">
            <div class="anchor">
                <img src="../../assets/icons/home-o.png" alt="Home" class="home selected">
            </div>
        </a>

        <a href="#">
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
</body>
</html>

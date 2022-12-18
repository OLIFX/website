<?php
require_once "../../settings/config.php";

session_start();
if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

if (!isset($_GET['id'])) {
    header("location: ../home");
}

$product = Product::find($_GET["id"]);
$media = Media::findMediaByProduct($product->getIdProduct());

try {
    $product->delete();
    $media->delete();
} catch (Exception $exception) {
    echo "exception: $exception";
    die();
}

header("location: ../yours");

<?php
require_once "../../settings/config.php";
session_start();

if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

// idProduct
if (!isset($_GET['id'])) {
    header("location: ../home");
}

$favorite = new Favorite();

$favorite->setIdUser($_SESSION["idUser"]);
$favorite->setIdProduct($_GET["id"]);

if (!$favorite->delete()) {
    echo "<h1>Error</h1>";
    sleep(5);
    header("../home");
} else {
    header("location: ./?id={$_GET['id']}");
}

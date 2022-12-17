<?php
require_once "../../settings/config.php";
session_start();
if (!$_SESSION["idUser"]) {
    header("location: ../login");
}

$favorites = Favorite::findallByUser($_SESSION["idUser"]);
var_dump($favorites);
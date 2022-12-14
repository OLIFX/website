<?php
require_once "../../settings/config.php";
session_start();
if (!isset($_SESSION["idUser"])) {
    header("location: ../login");
}
$product = Product::find();
$directory = "../../database/users/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product | </title>
</head>
<body>
    
</body>
</html>
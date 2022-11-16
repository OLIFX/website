<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <title>OLIFX | Login</title>
</head>
<body>
    <section class="form" enctype="multipart/form-data">
        <form action="login.php" method="post" enctype="multipart/form-data">
            <h1 class="title-in-box">Login</h1>

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login" name="button">
        </form>
    </section>
</body>
</html>
<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OLIFX | Criar Conta</title>
  <link rel="stylesheet" href="new.css">
</head>
<body>
    <section class="form" enctype="multipart/form-data">
        <form action="login.php" method="post" enctype="multipart/form-data">
            <h1 class="title-in-box">Criar conta</h1>
            <label for="fullname">Nome completo</label>
            <input type="text" name="fullname" id="fullname" required>

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required>

            <label for="cellphone">Telefone</label>
            <input type="tel" name="cellphone" id="cellphone" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <label for="city">Cidade</label>
            <input type="text" name="city" id="city" required>

            <label for="profilepic">Foto de perfil</label>
            <input type="file" name="profilepic" id="profilepic">

            <input type="submit" value="Criar" name="button">
        </form>
    </section>
</body>
</html>
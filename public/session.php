<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['name'] = $_POST['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webtech Demo</title>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php require_once "../src/components/header.php" ?>
    <?php require_once "../src/components/navbar.php" ?>
    <main>
      <?php if (isset($_SESSION['name'])): ?>
        <div class="container">
          <div>Hello there, <?=$_SESSION['name']?></div>
        </div>
      <?php else: ?>
        <form class="container" method="post">
          <h1>Who are you?</h1>
          <input id="name-input" name="name" placeholder="Enter your name...">
          <input type="submit" class="btn-primary" value="Submit">
        </form>
      <?php endif; ?>
    </main>
    <?php require_once "../src/components/footer.php" ?>
  </body>
</html>

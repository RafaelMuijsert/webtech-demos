<?php

/**
 * Demo page used to demonstrate security.
 * Contains an XSS-vulnerable comment system.
 *
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Rafael Alexander Muijsert <rafael@muijsert.org>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

require "../src/database.php";
require "../src/comments.php";

try {
    $databaseConnection = connectToDatabase();
} catch (Exception $e) {
    die("Could not connect to database");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $postSuccesful = postComment($databaseConnection, $_POST['username'], $_POST['text']);
    } catch (Exception $e) {
        $GLOBALS['error'] = "Could not post comment: $e";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webtech Demo</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/partial/security.css" type="text/css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php require_once "../src/components/header.php" ?>
    <?php require_once "../src/components/navbar.php" ?>
    <main>
      <form method="post" class="container">
        <h1>Post a comment</h1>
        <?php if (isset($postSuccesful)) : ?>
          <?php if ($postSuccesful === true) : ?>
            <p class="success">Post succesful</p>
          <?php else : ?>
            <p class="error">
              Post failed: <?php echo $GLOBALS['error']?>
            </p>
          <?php endif; ?>
        <?php endif; ?>
        <input name="username" placeholder="Username">
        <input name="text" placeholder="Comment">
        <input type="submit" class="btn-primary" value="Post comment">
      </form>
      <?php foreach (getComments($databaseConnection) as $comment) : ?>
        <div class="container comment">
          <div>
            <b><?php echo $comment['username']?>:</b>
            <a><?php echo $comment['text']?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </main>
    <?php require_once "../src/components/footer.php" ?>
  </body>
</html>

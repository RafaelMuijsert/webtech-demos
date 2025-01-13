<?php
require "../src/database.php";

function getComments()
{
    try {
        $databaseConnection = connectToDatabase();
    } catch (Exception $exception) {
        die("Could not connect to database");
    }

    $sql = "SELECT username, text FROM Comment";
    $result = $databaseConnection->query($sql);
    while ($row = $result->fetch_assoc()) {
        yield $row;
    }
}

function postComment($username, $text)
{
    try {
        $databaseConnection = connectToDatabase();
    } catch (Exception $exception) {
        $GLOBALS['error'] = "Could not connect to database";
        return false;
    }

    $statement = <<<'SQL'
    INSERT INTO Comment(username, text)
    VALUES (?, ?);
    SQL;

    try {
        $prepared = $databaseConnection->prepare($statement);

        // $encodedName = htmlspecialchars($username);
        // $encodedText = htmlspecialchars($text);

        // $prepared->bind_param('ss', $encodedName, $encodedText);

        $prepared->bind_param('ss', $username, $text);
        $prepared->execute();
        $databaseConnection->commit();
    } catch (Exception $e) {
        $GLOBALS['error'] = "Could not post comment";
        return false;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postSuccesful = postComment($_POST['username'], $_POST['text']);
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
    <link rel="stylesheet" href="/css/partial/security.css" type="text/css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php require_once "../src/components/header.php" ?>
    <?php require_once "../src/components/navbar.php" ?>
    <main>
      <form method="post" class="container">
        <h1>Post a comment</h1>
        <input name="username" placeholder="Username">
        <input name="text" placeholder="Comment">
        <input type="submit" class="btn-primary" value="Post comment">
      </form>
      <?php foreach (getComments() as $comment): ?>
        <div class="container comment">
          <div>
            <b><?=$comment['username']?>:</b>
            <a><?=$comment['text']?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </main>
    <?php require_once "../src/components/footer.php" ?>
  </body>
</html>

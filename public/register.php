<?php
require_once("../src/database.php");

function handleRegistration() {
  $PASSWORD_MIN_CHARACTERS = 8;

  $email = $_POST['user-email'];
  $password = $_POST['user-password'];

  if (strlen($password) < $PASSWORD_MIN_CHARACTERS) {
    $GLOBALS['error'] = "Password should be at least $PASSWORD_MIN_CHARACTERS characters";
    return false;
  } else {
    try {
      $databaseConnection = connectToDatabase();
    } catch (Exception $exception) {
      $GLOBALS['error'] = "Could not connect to database";
      return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement = <<<'SQL'
      INSERT INTO User(email, password)
      VALUES (?, ?);
      SQL;

    try {
      $prepared = $databaseConnection->prepare($statement);
      $prepared->bind_param('ss', $email, $password);
      $prepared->execute();
      $databaseConnection->commit();
    } catch (Exception $e) {
      $GLOBALS['error'] = "Could not create user";
      return false;
    }
  }
  return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $registrationSuccesful = handleRegistration();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webtech Demo</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/partial/register.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <?php include "../src/components/header.php" ?>
    <?php include "../src/components/navbar.php" ?>
    <main>
        <form method="post" action="/register.php" class="container">
          <h1>Register</h1>
          <?php if (isset($registrationSuccesful)): ?>
            <?php if ($registrationSuccesful === true): ?>
              <p class="success">Registration succesful</p>
            <?php else: ?>
              <p class="error">Registration failed: <?=$GLOBALS['error']?></p>
            <?php endif; ?>
          <?php endif; ?>
          <input name="user-email" type="email" placeholder="me@mail.org">
          <input name="user-password" type="password" placeholder="********">
          <input id="register-btn" class="btn-primary btn-register" type="submit" value="Submit">
        </form>
    </main>
    <?php include "../src/components/footer.php" ?>
  </body>
</html>

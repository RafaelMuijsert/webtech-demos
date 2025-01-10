<?php
// Er kunnen verschillende requests worden gestuurd.
// Als de pagina wordt opgevraagd, gaat dit via een GET request.
// Als een form wordt verstuurd, gaat dit via een POST request.
// Ons registratieformulier wordt dus met een POST request verzonden.
// De request-methode staat opgeslagen in $_SERVER['REQUEST_METHOD'].
// $_SERVER is een array met informatie, waaronder:
// - headers
// - paths
// - script locations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Haal de benodigde informatie uit de request
  $email = $_POST['user-email'];
  $password = $_POST['user-password'];

  // Plaats de nieuwe user in de database
  // $databaseConnection = connectToDatabase();

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webtech Demo</title>
    <link rel="stylesheet" href="/register/style.css">
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <main>
        <form method="post" class="register-form">
          <h2>Register</h2>
          <input name="user-email" type="email" placeholder="me@mail.org">
          <input name="user-password" type="password" placeholder="********">
          <input id="register-btn" type="submit" value="Submit">
        </form>
    </main>
  </body>
</html>

<?php
$HOST = 'localhost';
$DATABASE = 'webtechdemo';

/*
 * Connects to the server's database
 * Returns a database connection if succesful, otherwies dies.
 */
function connectToDatabase()
{
    $file = file_get_contents("../database-creds.xml", true);
    $xml = simplexml_load_string($file);
    $user = $xml->userName;
    $password = $xml->password;
    $connection = new mysqli(
        $GLOBALS['HOST'],
        $user,
        $password,
        $GLOBALS['DATABASE'],
    );
    if ($connection->connect_error) {
        die ('Connection failed: ' . $connection->connect_error);
    }
    $connection->autocommit(false);
    return $connection;
}
?>

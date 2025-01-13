<?php
/**
 * Utility file used to connect to the database.
 * Reads database credentials from ../database-creds.xml.
 * 
 * PHP version 8
 *
 * @category Webtech_Demo
 * @package  Webtech_Demo
 * @author   Rafael Alexander Muijsert <rafael@muijsert.org>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://localhost/
 */

$HOST = 'localhost';
$DATABASE = 'webtechdemo';

/**
 * Connect to the database.
 *
 * @return mysqli: active connection to the database.
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
        die('Connection failed: ' . $connection->connect_error);
    }
    $connection->autocommit(false);
    return $connection;
}

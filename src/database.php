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


/**
 * Connect to the database.
 *
 * @return mysqli: active connection to the database.
 */
function connectToDatabase()
{
    $HOST = 'localhost';
    $DATABASE = 'webtechdemo';
    // Using __DIR__ ensures the path is always relative
    // to the directory of the current file.
    $file = file_get_contents(__DIR__ . "/../config/database-creds.xml", true);
    if ($file === false) {
        die("Could not read database credentials");
    }
    $xml = simplexml_load_string($file);
    if ($xml === false) {
        die("Database credentials file contains invalid XML");
    }
    $user = $xml->userName;
    $password = $xml->password;
    $connection = new mysqli(
        $HOST,
        $user,
        $password,
        $DATABASE,
    );
    if ($connection->connect_error) {
        die('Connection failed: ' . $connection->connect_error);
    }
    $connection->autocommit(false);
    return $connection;
}

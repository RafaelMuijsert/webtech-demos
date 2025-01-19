<?php

/**
 * Contains functions regarding user comments.
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
 * Fetch comments from database.
 *
 * @param mysqli $databaseConnection an active database connection.
 *
 * @return Generator<array<string, string>>
 */
function getComments($databaseConnection)
{
    $sql = "SELECT username, text FROM Comment";
    $result = $databaseConnection->query($sql);
    if ($result === false) {
        die("Could not read comments from database");
    }
    if ($result === true) {
        return [];
    }
    while ($row = $result->fetch_assoc()) {
        yield $row;
    }
}

/**
 * Insert a comment into the database.
 *
 * @param mysqli $databaseConnection an active database connection.
 * @param string $username username of the comment.
 * @param string $text     text of the comment.
 *
 * @return bool: true if the comment was posted succesfully.
 */
function postComment($databaseConnection, $username, $text)
{
    $statement = <<<'SQL'
    INSERT INTO Comment(username, text)
    VALUES (?, ?);
    SQL;

    try {
        $prepared = $databaseConnection->prepare($statement);
        if ($prepared === false) {
            $GLOBALS['error'] = "Could not prepare statement";
            return false;
        }

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

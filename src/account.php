<?php

/**
 * Contains functions regarding user accounts.
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
 * Register a new user.
 *
 * @param mysqli $databaseConnection: an active database connection.
 * @param string $email:              the email address of the user.
 * @param string $password:           the password of the user.
 *
 * @return bool: true if the comment was posted succesfully.
 */
function registerUser($databaseConnection, $email, $password)
{
    $PASSWORD_MIN_CHARACTERS = 8;

    if (strlen($password) < $PASSWORD_MIN_CHARACTERS) {
        $error = "Password should be at least $PASSWORD_MIN_CHARACTERS characters";
        $GLOBALS['error'] = $error;
        return false;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statement = <<<'SQL'
            INSERT INTO User(email, password)
            VALUES (?, ?);
        SQL;

        try {
            $prepared = $databaseConnection->prepare($statement);
            if ($prepared === false) {
                $GLOBALS['error'] = "Could not prepare statement";
                return false;
            }
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

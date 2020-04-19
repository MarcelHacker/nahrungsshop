<?php

function getCurrentUser(int $userId)
{
    $db = getDB();
    if (!$db) {
        die();
    } else {
        $statement = $db->prepare("SELECT * FROM users WHERE id = :userId");
        $statement->execute(array('userId' => $userId));
        $user = $statement->fetch();    // User schon vorhanden?
    }
    return $user;
}

function getUserWithEmail(string $email)
{
    $db = getDB();
    if (!$db) {
        die();
    } else {

        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(array('email' => $email));
        $user = $statement->fetch();    // Alle User mit der Email
    }
    return $user;
}

function isLoggedIn(): bool     // Checking if user is logged in
{
    return isset($_SESSION['userId']);
}

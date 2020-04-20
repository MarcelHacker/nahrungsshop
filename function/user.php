<?php

function getCurrentUser(int $userId)    // Get current user with user id
{
    $db = getDB();  // Database connection
    if (!$db) {
        die();
    } else {
        $statement = $db->prepare("SELECT * FROM users WHERE id = :userId");
        $statement->execute(array('userId' => $userId));
        $user = $statement->fetch();    // User schon vorhanden?
    }
    return $user;
}

function getUserWithEmail(string $email)    // Get user data with email
{
    $db = getDB();  // Database connection
    if (!$db) {
        die();
    } else {

        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(array('email' => $email));
        $user = $statement->fetch();    // All from user with email
    }
    return $user;
}

function isLoggedIn(): bool     // Checking if user is logged in
{
    return isset($_SESSION['userId']); // session user id variable
}

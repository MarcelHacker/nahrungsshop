<?php

function getCurrentUser(int $userId)
{
    $sql = "SELECT * FROM users where id = '$userId";

    $result = getDB()->query($sql);
    if (!$result) {
        return [];
    }
    $user = [];
    while ($row = $result->fetch()) {
        $user[] = $row;
    }
    return $user;
}

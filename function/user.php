<?php
function getUser($sql)
{
    //$sql = "SELECT * FROM users";

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
?>
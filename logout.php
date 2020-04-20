<?php

/**
 * Php file for the user logout
 * 
 * Used for the logout website
 * 
 */
session_start();
session_start();
session_unset();
session_destroy();

sleep(0.5);     // waits 0,5 seconds
header("Location: index.php"); // Got to home
exit;           // Prevents loading page

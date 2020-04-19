<?php
session_start();
session_unset();
session_destroy();

sleep(0.5);   // waits 0,5 seconds
header("Location: index.php"); // Got to home
exit;   // Prevents loading page

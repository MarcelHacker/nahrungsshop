<?php
session_start();
include_once("template/header.php");
if (!isset($_SESSION['userId'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userId = $_SESSION['userId'];

echo "Hallo User: " . $userId;
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
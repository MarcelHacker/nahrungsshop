<?php
session_start();

if (!isLoggedIn()) {      // Not logged in?
    header("Loctaion: index.php");      // Go to index
    exit;                               // Prevents loading when poor connection
}

include_once("template/header.php");
//Abfrage der Nutzer ID vom Login
$userId = $_SESSION['userId'];

echo "Hallo User: " . $userId;

include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
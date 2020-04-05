<?php
session_start();

if (!isset($_SESSION['userId'])) {      // nicht eigeloggt
    header("Loctaion: index.php");
    exit;                               //verhindert laden der Seite
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
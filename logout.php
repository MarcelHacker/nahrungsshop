<?php
session_unset();
session_destroy();
include_once("template/header.php");

echo "Logout erfolgreich";
include_once("template/footer.php");
sleep(2); //1,5s warten
header("Location: index.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
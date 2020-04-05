<?php
session_start();
session_unset();
session_destroy();
include_once("template/header.php");

include_once("template/footer.php");
header("Location: index.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
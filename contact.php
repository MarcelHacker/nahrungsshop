<?php
include_once("template/header.php");

if (isset($_POST['contact'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $subj = $_POST['subject'];
    $mesg = $_POST['message'];

    $db = getDB();
    if (!$db) {
        echo "Error database connection";
        die();
    } else {
        $sql = "insert into contact(email,name,subject,message) values('$email','$name','$subj',$mesg');";
        $statement = $db->prepare($sql);
        $result = $statement->execute(array('email' => $email, 'name' => $name, 'subject' => $subj, 'message' => $mesg));

        if (!$result == false) {
            echo "<font>Message sent successfully</font>";
        } else {
            echo "Error contact message";
        }
    }
}
?>
<div class="fixed-bottom">
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
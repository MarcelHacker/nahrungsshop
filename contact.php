<?php

extract($_REQUEST);
if(isset($sub))
 {
    $email=$_POST['email'];
    $name=$_POST['name'];
    $subj=$_POST['subject'];
    $mesg=$_POST['message'];

    $sql="insert into contact values('$email','$name','$subj',$mesg')";

    if(mysqli_query($conn,$sql))
    {
	    echo "<font>Message sent successfully</font>";
    }
    else
    {
        echo "Error";
    }
 }
?>
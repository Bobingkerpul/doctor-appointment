<?php

// session_start();
require_once '../connection.php';

if (isset($_POST['update'])) {
    $email_result = $database->query("SELECT * FROM webuser");
    $id = $_POST['id'];
    $fname = $_POST['dfname'];
    $mNumber = $_POST['dtel'];
    $oldemail = $_POST['oldemail'];
    $email = $_POST['dmail'];
    $dpassword = $_POST['dpassword'];
    $dcpassword = $_POST['dcpassword'];
    $dspecial = $_POST['dspecial'];


    if ($dpassword == $dcpassword) {

        $email_result = $database->query("SELECT doctor.id FROM doctor INNER JOIN webuser ON doctor.docemail=webuser.email  WHERE webuser.email= '$email'");

        if ($email_result->num_rows == 1) {

            $id2 = $email_result->fetch_assoc()['id'];
        } else {
            $id2 = $id;
        }

        if ($id2 == $id) {
            $database->query("UPDATE doctor SET docemail='$email',docname='$fname',docpassword='$dpassword',doctel='$mNumber',specialties='$dspecial' WHERE id = '$id'");
            $database->query("UPDATE webuser SET email='$email',usertype='d' WHERE email = '$oldemail'");
            header("location:./doctors.php");
        }
    }
}

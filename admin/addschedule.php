<?php
require_once '../connection.php';

session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if (isset($_POST['submit'])) {
    $session = $_POST['session'];
    $doctorid = $_POST['doctorid'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // echo "INSERT INTO schedule(docid, title, scheduledate, scheduletime) VALUES ('$doctorid','$session','$date','$time')";
    // exit;

    $database->query("INSERT INTO schedule(docid, title, scheduledate, scheduletime) VALUES ('$doctorid','$session','$date','$time')");

    header('location:schedule.php');
}

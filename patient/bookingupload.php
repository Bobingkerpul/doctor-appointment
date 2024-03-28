<?php

session_start();
require_once "../connection.php";

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION["usertype"] != "p") {
        header("location: ../login.php");
    } else {
        $usermail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}


if (isset($_POST['booknow'])) {
    $patientid = $_POST['patientid'];
    $apponum = $_POST['apponum'];
    $scheduleid = $_POST['scheduleid'];
    $date = $_POST['date'];

    $database->query("INSERT INTO appointment(pid, apponum, scheduleid, appodate) VALUES ('$patientid','$apponum','$scheduleid','$date')");

    header('location:schedule.php');
}

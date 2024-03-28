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


if ($_GET) {
    $id = $_GET['id'];

    $database->query("DELETE FROM appointment WHERE appoid = '$id'");

    header('location:appointment.php');
}

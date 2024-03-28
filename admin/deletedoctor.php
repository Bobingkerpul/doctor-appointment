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

if ($_GET) {
    $id = $_GET['id'];

    $doc_remove = $database->query("SELECT * FROM doctor WHERE id = '$id'");
    $doc_email = $doc_remove->fetch_assoc()['docemail'];
    $sql = $database->query("DELETE  FROM webuser WHERE email = '$doc_email'");
    $sql = $database->query("DELETE  FROM doctor WHERE docemail = '$doc_email'");
    header('location: doctors.php');
    // echo $doc_email;
}

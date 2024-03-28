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


$id = $_GET['id'];

$doctors = $database->query("SELECT * FROM doctor WHERE id = '$id'");
$doctors = $doctors->fetch_array(MYSQLI_ASSOC);


echo json_encode($doctors);

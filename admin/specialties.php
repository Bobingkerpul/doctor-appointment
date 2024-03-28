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

$specialties = $database->query("SELECT * FROM specialties WHERE id = '$id'");

while ($spec = $specialties->fetch_assoc()) {
    echo '<option value="' . $spec['id'] . '">' . $spec['name'] . '</option>';
}

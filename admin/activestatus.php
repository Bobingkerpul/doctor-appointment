<?php

require_once '../connection.php';


$id = $_GET['id'];
$status = $_GET['status'];

$database->query("UPDATE doctor SET status='$status' WHERE id = '$id'");
header('location:doctors.php');

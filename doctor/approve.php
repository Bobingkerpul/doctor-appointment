<?php

require_once '../connection.php';


$id = $_GET['id'];
$status = $_GET['status'];

$database->query("UPDATE appointment SET status='$status' WHERE appoid ='$id'");
header('location:appointment.php');

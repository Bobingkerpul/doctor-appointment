<?php

require_once '../connection.php';

$id = $_GET['id'];

$doctors = $database->query("SELECT * FROM doctor WHERE id = '$id'");
$doctors = $doctors->fetch_array(MYSQLI_ASSOC);


echo json_encode($doctors);

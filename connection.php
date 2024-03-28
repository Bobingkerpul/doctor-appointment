<?php

$database = new mysqli("localhost", "root", "", "doctor_appointment");
if ($database->connect_error) {
    die("Connecton failed!: " . $database->connect_error);
}

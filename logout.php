<?php
session_start();
require_once "connection.php";

$usermail = $_SESSION["user"];

$database->query("UPDATE doctor SET status = 0 WHERE docemail = '$usermail'");

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
}

session_destroy();

header("location: login.php?action=logout");
exit;

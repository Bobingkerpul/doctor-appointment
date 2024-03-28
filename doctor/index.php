<?php

session_start();
require_once "../connection.php";



date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;


if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION["usertype"] != "d") {
        header("location: ../login.php");
    } else {
        $usermail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

$user = $database->query("SELECT * FROM doctor WHERE docemail = '$usermail'");

$userfetch = $user->fetch_assoc();
$docid = $userfetch["id"];
$name = $userfetch["docname"];
$username = $userfetch["docemail"];
$profile = $userfetch["uploadprofile"];
$status = $userfetch["status"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/jquery-3.6.1.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/doctors.css">
    <link rel="stylesheet" href="../css/layout.css">
    <title>Appointment</title>
    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/poppins.css">
</head>

<body>
    <div>
        <?php include_once('./theme/sidemenu.php') ?>
        <div class="dashboard">
            <div class="dashboard-status d-flex flex-row justify-content-between">
                <div class="search col" style="padding-right:8%">
                    <h2>Dashboard</h2>
                </div>
                <div class="date">
                    <span>Today's Date</span>
                    <p style="font-size:1.5em"><?= $date ?></p>
                </div>
            </div>
            <div class="doctor-bg">
                <div class="search col mb-4" style="padding-right:8%">
                    <h4>Welcome</h4>
                </div>
                <div class="intro">
                    <h1><?= $name ?></h1>
                    <p style="width: 70%;" class="mb-5">We're thrilled to have you as part of our medical team. Your expertise, compassion, and dedication to patient care are invaluable assets to our practice. As you embark on this journey with us, know that your contributions will make a meaningful difference in the lives of those we serve.</p>
                    <a href="appointment.php"><button class="btn btn-primary">View My Appointment</button></a>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
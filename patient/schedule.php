<?php

session_start();
require_once "../connection.php";

date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION["usertype"] != "p") {
        header("location: ../login.php");
    } else {
        $usermail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

$user = $database->query("SELECT * FROM patient WHERE pemail = '$usermail'");
$userfetch = $user->fetch_assoc();
// $userid = $userfetch["pid"];
$name = $userfetch["pname"];
$usermail = $userfetch["pemail"];
$profile = $userfetch['uploadprofile'];



// Show All Schedule Sessions
$sessions = $database->query("SELECT * FROM schedule AS s INNER JOIN doctor AS d ON s.docid=d.id ORDER BY s.scheduledate DESC");

$sessionsched = $sessions->fetch_all(MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/jquery-3.6.1.min.js"></script>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/schedule.css">
    <link rel="stylesheet" href="../css/layout.css">
    <title>Sessions</title>
    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/poppins.css">
</head>

<body>
    <div>
        <?php include_once('./theme/sidemenu.php'); ?>
        <div class="dashboard">
            <div class="dashboard-status d-flex flex-row justify-content-between">
                <div class="search col" style="padding-right:8%">
                    <form action="" method="post" autocomplete="off">
                        <div class="d-flex flex-row gap-2">
                            <input type="search" name="search" class="form-control col" placeholder="Search Doctor Name or Email">
                            <button type="submit" class="btn btn-primary" style="width: 16%;">Search</button>
                        </div>
                    </form>
                </div>
                <div class="date">
                    <span>Today's Date</span>
                    <p style="font-size:1.5em"><?= $date ?></p>
                </div>
            </div>
            <h1>Scheduled Sessions</h1>
            <hr class="mb-5">
            <div class="row gap-4">

                <?php foreach ($sessionsched as $session) : ?>
                    <div class="col-md-6 schedule shadow rounded p-4" style="width: 48%;">
                        <h2><?= $session['title'] ?></h2>
                        <hr>
                        <div class="doctor-detail mt-4">
                            <h6>Doctor Name: <span class="poppins-regular"><?= $session['docname'] ?></span></h6>
                            <h6>Session Date: <span class="poppins-regular"><?= $session['scheduledate'] ?></span></h6>
                            <h6>Start: @ <span class="poppins-regular"><?= $session['scheduletime'] ?> (24h)</span></h6>
                            <a href="booking.php?id=<?= $session['scheduleid'] ?>"><button class="btn btn-primary form-control mt-5">Book Now</button></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
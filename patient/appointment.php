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

// User
$user = $database->query("SELECT * FROM patient WHERE pemail = '$usermail'");
$userfetch = $user->fetch_assoc();
$userid = $userfetch["pid"];
$name = $userfetch["pname"];
$usermail = $userfetch["pemail"];
$profile = $userfetch['uploadprofile'];

// echo $userid;
// exit;

// View Booking Query
$mybookings = $database->query("SELECT ap.appoid,
s.scheduleid,
s.title,
d.docname,
p.pname,
s.scheduledate,
s.scheduletime,
ap.apponum,
ap.status,
ap.appodate FROM schedule AS s INNER JOIN appointment AS ap 
ON s.scheduleid=ap.scheduleid INNER JOIN patient AS p 
ON p.pid=ap.pid INNER JOIN doctor AS d
ON s.docid=d.id  WHERE  p.pid = '$userid' ORDER BY ap.appodate DESC");


// echo "SELECT ap.appoid,
// s.scheduleid,
// s.title,
// d.docname,
// p.pname,
// s.scheduledate,
// s.scheduletime,
// ap.apponum,
// p.appodate FROM schedule AS s INNER JOIN appointment AS ap 
// ON s.scheduleid=ap.scheduleid INNER JOIN patient AS p 
// ON p.pid=ap.pid INNER JOIN doctor AS d
// ON s.docid=d.id  WHERE  p.pid = '$userid'";
// exit;
$bookings = $mybookings->fetch_all(MYSQLI_ASSOC);




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
    <title>Appointments</title>
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

            <div class="row gap-4">
                <div class="text-content my-4">
                    <h1 class="poppins-semibold">My Booking Sessions</h1>
                    <p class="poppins-light" style="width: 70%;">Our user-friendly interface allows you to easily schedule appointments with just a few clicks, whether you're at home or on the go. Say goodbye to the hassle of making appointments and book your next one with ease.
                    </p>
                </div>
                <hr>
                <?php if ($mybookings->num_rows == 0) : ?>
                    <h2 class="text-center poppins-light">We could not locate <br> Any booking appointment record.</h2>
                    <img src="../images/icons/notfound.svg" alt="Not Found" style="width: 40%; margin:auto">
                <?php else : ?>
                    <?php foreach ($bookings as $booking) : ?>
                        <div class="col-md-6 shadow p-5 mt-4 rounded schedule" style="width: 48%;">
                            <?php if ($booking['status'] == 1) : ?>
                                <div class="d-flex flex-row gap-4 align-items-center mb-5">
                                    <span class="circle-app"></span>
                                    <span class="text-success">Approved</span>
                                </div>
                            <?php else : ?>
                                <div class="d-flex flex-row gap-4 align-items-center mb-5">
                                    <span class="circle-not"></span>
                                    <span class="text-danger">Not Approved</span>
                                </div>
                            <?php endif; ?>
                            <p>Booking Date: <?= $booking['appodate'] ?></p>
                            <p>Reference Number: <?= $booking['appoid'] ?></p>
                            <p><?= $booking['title'] ?></p>
                            <p> Appointment Number: <br />0<?= $booking['apponum'] ?></p>
                            <p> Doctor: <?= $booking['docname'] ?></p>
                            <p> Scheduled Date: <?= $booking['scheduledate'] ?></p>
                            <p> Starts: <?= $booking['scheduletime'] ?> (24h)</p>

                            <!-- Button trigger modal View Doctor -->
                            <button type="submit" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#appointment">
                                Cancel Appointment
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>



    <!-- Modal View -->
    <div class=" modal modal-lg fade" id="appointment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class=" modal-header  d-flex flex-row justify-content-center" style="background-color: #F6B216;">
                    <h2 class="modal-title fs-5  text-white poppins-black">WARNING!!</h2>
                </div>
                <div class="modal-body p-5">
                    <div class="d-flex flex-row justify-content-center mb-4">
                        <img src="../images/icons/warning.svg" alt="Warning" class="warning-icon">
                    </div>
                    <p class="m-auto text-center mb-5" style="width: 70%;">Please confirm if you would like to cancel your appointment. Please note that if you choose to cancel your appointment, it will be permanently removed.
                    </p>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="d-flex flex-row gap-4">
                            <a href="cancelapp.php?id=<?= $booking['appoid'] ?>" class="w-100"><button class="btn btn-danger w-100">YES</button></a>
                            <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal" aria-label="Close">NO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
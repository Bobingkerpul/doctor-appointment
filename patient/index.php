<?php

session_start();
require_once "../connection.php";


// Include the functions for managing login status
function set_user_active()
{
    $_SESSION["active"] = true;
}

function set_user_inactive()
{
    $_SESSION["active"] = false;
}

// Set the user status to active upon session start
set_user_active();



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
$userid = $userfetch["pid"];
$name = $userfetch["pname"];
$usermail = $userfetch["pemail"];
$profile = $userfetch['uploadprofile'];



// Count All Patients
$patients = $database->query("SELECT COUNT(*)AS patients FROM patient");
$patient = $patients->fetch_assoc();


// Count All Doctors
$doctors = $database->query("SELECT COUNT(*)AS doctors FROM doctor");
$doctor = $doctors->fetch_assoc();

// Count All Appointment
$appointments = $database->query("SELECT COUNT(*)AS appo FROM appointment WHERE pid = '$userid' AND status !=0");
$appointment = $appointments->fetch_assoc();

// Count All Session
$schedules = $database->query("SELECT COUNT(*)AS sched FROM schedule");
$schedule = $schedules->fetch_assoc();
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
    <title>Patient <?= $name ?></title>
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
            <div class="dashboard-count mb-5">
                <?php if (isset($_SESSION['active'])) : ?>
                    <?php if ($_SESSION['active']) : ?>
                        <p>Status: Active</p>
                    <?php else : ?>
                        <p>Status: Inactive</p>
                    <?php endif; ?>
                <?php endif; ?>
                <h4>Status</h4>
                <div class="d-flex flex-row gap-2 mt-2 mb-4">
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $doctor['doctors'] ?></span>
                            <p>Doctors</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/doctor.svg" alt="Doctor">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $patient['patients'] ?></span>
                            <p>Patients</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/patients.svg" alt="Patient">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $appointment['appo'] ?></span>
                            <p>Booking</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/schedule1.svg" alt="Booking">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $schedule['sched'] ?></span>
                            <p>Session</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/schedule1.svg" alt="Session">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <script src="../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
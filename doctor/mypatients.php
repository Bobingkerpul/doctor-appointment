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

// Count All Appointments
$allappoint = $database->query("SELECT COUNT(*) AS allappointment, ap.appoid,
d.docname,
p.pname,
ap.apponum,
ap.appodate FROM schedule AS s INNER JOIN appointment AS ap 
ON s.scheduleid=ap.scheduleid INNER JOIN patient AS p 
ON p.pid=ap.pid INNER JOIN doctor AS d
ON s.docid=d.id  WHERE  d.id = '$docid'");
$allappoint = $allappoint->fetch_assoc();


// Vew All Appointments
$myappointments = $database->query("SELECT * FROM appointment
 INNER JOIN patient AS p ON p.pid=appointment.pid 
 INNER JOIN schedule AS s ON s.scheduleid=appointment.scheduleid 
 WHERE s.docid='$docid'");

$appointments = $myappointments->fetch_all(MYSQLI_ASSOC);
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
    <title>My Patients</title>
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
                    <h2>My Patients</h2>
                </div>
                <div class="date">
                    <span>Today's Date</span>
                    <p style="font-size:1.5em"><?= $date ?></p>
                </div>
            </div>
            <div class="shadow-lg p-4 rounded">
                <div class="all-doctor">
                    <p>My Patients (<?= $allappoint['allappointment'] ?>)</p>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary p-3 text-uppercase text-white" style="border-radius: 10px 0px 0px 0px;">Patient Name</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Tel Num</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Email</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Date of Birth</th>
                            <th class="bg-primary p-3 text-uppercase text-white text-center" style="border-radius: 0px 10px 0px 0px;">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment) : ?>
                            <tr>
                                <td><?= $appointment['pname'] ?></td>
                                <td><?= $appointment['ptel'] ?></td>
                                <td><?= $appointment['pemail'] ?></td>
                                <td><?= $appointment['pdob'] ?></td>
                                <td>
                                    <button type="submit" class="btn btn-outline-primary">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
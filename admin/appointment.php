<?php

session_start();
require_once '../connection.php';

date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION["usertype"] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}



$patientappo = $database->query("SELECT ap.appoid,
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
ON s.docid=d.id");

$patientsappo = $patientappo->fetch_all(MYSQLI_ASSOC);


// Count All Appointment
$appointments = $database->query("SELECT COUNT(*)AS appo FROM appointment WHERE status != 0");
$appointment = $appointments->fetch_assoc()['appo'];

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
                    <h2>Appointment Manager</h2>
                </div>
                <div class="date">
                    <span>Today's Date</span>
                    <p style="font-size:1.5em"><?= $date ?></p>
                </div>
            </div>
            <div class="shadow-lg p-4 rounded">
                <div class="all-doctor">
                    <p>All Appointment (<?= $appointment ?>)</p>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary p-3 text-uppercase text-white" style="border-radius: 10px 0px 0px 0px; font-size:14px">Patient Name</th>
                            <th class="bg-primary p-3 text-uppercase text-white" style="font-size:14px">Appoint Number</th>
                            <th class="bg-primary p-3 text-uppercase text-white" style="font-size:14px">Doctor</th>
                            <th class="bg-primary p-3 text-uppercase text-white" style="font-size:14px">Appoint Title</th>
                            <th class="bg-primary p-3 text-uppercase text-white" style="font-size:14px"><small>Session Date & Time</small></th>
                            <th class="bg-primary p-3 text-uppercase text-white" style="font-size:14px">Appoint Date</th>
                            <th class="bg-primary p-3 text-uppercase text-white text-center" colspan="2" style="border-radius: 0px 10px 0px 0px;">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patientsappo as $patient) : ?>
                            <tr>
                                <td><?= $patient['pname'] ?></td>
                                <td><?= $patient['apponum'] ?></td>
                                <td><?= $patient['docname'] ?></td>
                                <td><?= $patient['title'] ?></td>
                                <td><?= $patient['scheduledate'] . ' <br/>' . $patient['scheduletime'] ?></td>
                                <td><?= $patient['appodate'] ?></td>
                                <td><button class="btn btn-outline-primary">Cancel</button></td>
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
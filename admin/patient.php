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



$allpatients = $database->query("SELECT * FROM patient");


// All Patients 
$patients = $database->query("SELECT COUNT(*)AS patients FROM patient");
$patient = $patients->fetch_assoc();

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
    <title>Patients</title>
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
                    <form action="searchdoctor.php" method="post" autocomplete="off">
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
            <hr>
            <div class="d-flex justify-content-between mb-5 mt-5">
                <h2>All Patients</h2>
            </div>
            <div class="shadow-lg p-4 rounded overflow-auto" style="height:450px">
                <div class="all-doctor">
                    <p>All Patients (<?= $patient['patients'] ?>)</p>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary p-3 text-uppercase text-white" style="border-radius: 10px 0px 0px 0px; font-size:14px">Patient Name</th>
                            <th class="bg-primary p-3 text-uppercase text-white " style="font-size:14px">Patient Email</th>
                            <th class="bg-primary p-3 text-uppercase text-white " style="font-size:14px">Address</th>
                            <th class="bg-primary p-3 text-uppercase text-white " style="font-size:14px">Phone Number</th>
                            <th class="bg-primary p-3 text-uppercase text-white " colspan="2" style="border-radius: 0px 10px 0px 0px; font-size:14px">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($patient = $allpatients->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $patient['pname'] ?></td>
                                <td><?= $patient['pemail'] ?></td>
                                <td><?= $patient['paddress'] ?></td>
                                <td><?= $patient['ptel'] ?></td>

                                <!-- Button trigger modal View Doctor -->
                                <td>
                                    <button type="submit" class="btn btn-warning view" data-bs-toggle="modal" data-bs-target="#viewpatient" value="<?= $patient['id'] ?>">
                                        <img src="../images/icons/view.svg" class="icon-svg m-0" alt="View">
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal View -->
    <div class=" modal modal-lg fade" id="viewpatient">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">View Details</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <input type="hidden" id="id">
                    <h4>Full Name</h4>
                    <input id="fullname" class="form-control border-0" readonly>
                    <h4>Email</h4>
                    <input id="email" class="form-control border-0" readonly>
                    <h4>Contact Number</h4>
                    <input id="cnumber" class="form-control border-0" readonly>
                    <h4>Position</h4>
                    <select id="position" class="border-0" disabled>
                        <?php
                        $specs2 = $database->query("SELECT * FROM specialties ORDER BY sname ASC");
                        while ($spec = $specs2->fetch_assoc()) {
                        ?>
                            <option value="<?= $spec['id'] ?>" disabled><?= $spec['sname'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>





    <script src="../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
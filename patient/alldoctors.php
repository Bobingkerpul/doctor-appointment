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




$patients = $database->query("SELECT COUNT(*)AS patients FROM patient");
$patient = $patients->fetch_assoc();


$doctors = $database->query("SELECT * FROM doctor");
$specialists = $database->query("SELECT * FROM specialties ORDER BY sname ASC");

$doctorsCount = $database->query("SELECT COUNT(*)AS doctors FROM doctor");
$doctor = $doctorsCount->fetch_assoc();

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
    <title>All Doctor's</title>
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
            <div class="search col" style="padding-right:8%">
                <form action="searchdoctor.php" method="post" autocomplete="off">
                    <div class="d-flex flex-row gap-2">
                        <input type="search" name="search" class="form-control col" placeholder="Search Doctor Name or Email">
                        <button type="submit" class="btn btn-primary" style="width: 16%;">Search</button>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-between mb-5 mt-5">
                <h2>All Doctor's</h2>
            </div>
            <div class="shadow-lg p-4 rounded">
                <div class="all-doctor">
                    <p>All Doctors (<?= $doctor['doctors'] ?>)</p>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary p-3 text-uppercase text-white" style="border-radius: 10px 0px 0px 0px;">Doctor Name</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Email</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Expertise</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Status</th>
                            <th class="bg-primary p-3 text-uppercase text-white text-center" style="border-radius: 0px 10px 0px 0px;">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($doctor = $doctors->fetch_assoc()) {
                            $spec = $doctor['specialties'];
                            $specialties =  $database->query("SELECT * FROM specialties WHERE id = $spec");

                            $spec_fetch = $specialties->fetch_assoc();
                        ?>
                            <tr>
                                <td><?= $doctor['docname'] ?></td>
                                <td><?= $doctor['docemail'] ?></td>
                                <td><?= $spec_fetch['sname'] ?></td>
                                <td>
                                    <?php if ($doctor['status'] == 1) : ?>
                                        <button class="btn btn-outline-success" disabled>Active</button>
                                    <?php else : ?>
                                        <button class="btn btn-outline-danger" disabled>Inactive</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Button trigger modal View Doctor -->
                                    <button type="submit" class="btn btn-warning view" data-bs-toggle="modal" data-bs-target="#viewdoctor" value="<?= $doctor['id'] ?>">
                                        <img src="../images/icons/view.svg" class="icon-svg" alt="View">
                                        View
                                    </button>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal View -->
    <div class=" modal modal-lg fade" id="viewdoctor">
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
    <script src="../js/viewdoctorpatient.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
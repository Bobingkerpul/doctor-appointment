<?php

session_start();
require_once '../connection.php';

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" or $_SESSION["usertype"] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

$doctors = $database->query("SELECT * FROM doctor");
$specialists = $database->query("SELECT * FROM specialties ORDER BY sname ASC");

// Add New Doctor 
if (isset($_POST['submit'])) {
    $email_result = $database->query("SELECT * FROM webuser");
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $name = $fname . " " . $lname;
    $mNumber = $_POST['mNumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $special = $_POST['special'];

    if ($password == $cpassword) {
        $email_result = $database->query("SELECT * FROM webuser WHERE email = '$email'");
        if ($email_result->num_rows == 1) {
            $error = '1';
        } else {
            $database->query("INSERT INTO doctor(docemail, docname, docpassword, doctel, specialties) VALUES ('$email','$name','$password','$mNumber','$special')");
            $database->query("INSERT INTO webuser(email, usertype) VALUES ('$email','d')");

            header("location: doctors.php");
        }
    }
}

$doctorsCount = $database->query("SELECT COUNT(*)AS doctors FROM doctor");
$doctor = $doctorsCount->fetch_assoc();

// Search Form
if ($_POST) {
    $keyword = $_POST['search'];

    $search = "SELECT * FROM doctor WHERE docemail='$keyword' or docname='$keyword' OR docname LIKE '$keyword%' OR docname LIKE '%$keyword' OR docname LIKE'%$keyword%'";
}


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
    <title>Doctor</title>
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
            <div class="d-flex justify-content-between mb-5">
                <h2>Doctor's Details</h2>
                <div class="addnewdoctor">
                    <!-- Button trigger modal Add New Doctor -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addnewdoctor">
                        <img src="../images/icons/add.svg" class="icon-svg-add">
                        Add New Doctor
                    </button>
                </div>
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
                            <th class="bg-primary p-3 text-uppercase text-white">Position</th>
                            <th class="bg-primary p-3 text-uppercase text-white text-center" colspan="3" style="border-radius: 0px 10px 0px 0px;">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row = $database->query($search);
                        if ($row->num_rows == 0) { ?>
                            <tr>
                                <td colspan="6" class="text-center ">
                                    <img style="width:40%" src="../images/notfound.svg" alt="Not Found" class="mt-5">
                                    <p class="mt-4">I'm sorry, but the Doctor you are looking for cannot be found. <br />It seems like that Doctor you are searching for may have been removed, deleted, or <br /> <span style="color: #8E0D0D; font-weight:500">DOES NOT EXIST.</span></p>

                                    <a href="doctors.php"><button class="btn btn-primary"> Show All Doctors</button></a>

                                </td>
                            </tr>
                            <?php } else {
                            while ($rowSearch = $row->fetch_assoc()) {
                                $spec = $rowSearch['specialties'];
                                $specialties =  $database->query("SELECT * FROM specialties WHERE id = $spec");

                                $spec_fetch = $specialties->fetch_assoc(); ?>
                                <tr>
                                    <td><?= $rowSearch['docname'] ?></td>
                                    <td><?= $rowSearch['docemail'] ?></td>
                                    <td><?= $spec_fetch['sname'] ?></td>
                                    <td>
                                        <!-- Button trigger modal Edit Doctor -->
                                        <button type="submit" class="btn btn-primary update" data-bs-toggle="modal" data-bs-target="#editdoctor" value="<?= $rowSearch['id'] ?>">
                                            <img src="../images/icons/edit.svg" class="icon-svg" alt="Edit">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal View Doctor -->
                                        <button type="submit" class="btn btn-warning view" data-bs-toggle="modal" data-bs-target="#viewdoctor" value="<?= $rowSearch['id'] ?>">
                                            <img src="../images/icons/view.svg" class="icon-svg" alt="View">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Doctor -->
    <div class="modal modal-lg fade" id="addnewdoctor" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Add New Doctor</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <div class="col right">
                        <div class="input-box">
                            <form action="" method="post" autocomplete="off">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="input-field col-md-6">
                                        <input type="text" class="input" name="fname" required="">
                                        <label>First Name</label>
                                    </div>
                                    <div class="input-field col-md-6">
                                        <input type="text" class="input" name="lname" required="">
                                        <label>Last Name</label>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <input type="mail" class="input" name="email" required="">
                                    <label>Email</label>
                                </div>
                                <div class="input-field">
                                    <input type="tel" class="input" name="mNumber" required="">
                                    <label>Mobile Number</label>
                                </div>
                                <div class="input-field">
                                    <select class="form-select" name="special">
                                        <option value="">Select Specialties</option>
                                        <?php while ($specialist = $specialists->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $specialist['id'] ?>"><?= $specialist['sname'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="input-field col-md-6">
                                        <input type="password" class="input" name="password" required="">
                                        <label>Password</label>
                                    </div>
                                    <div class="input-field col-md-6">
                                        <input type="password" class="input" name="cpassword" required="">
                                        <label>Confirm Password</label>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <input type="submit" name="submit" class="submit" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class=" modal modal-lg fade" id="editdoctor">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Edit Doctor</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="oldemail" id="oldemail">

                        <div class="col right">
                            <div class="input-box">
                                <div class="input-field">
                                    <input type="text" class="input" id="fname" name="dfname" required="">
                                    <label>Full Name</label>
                                </div>
                                <div class="input-field">
                                    <input type="email" class="input" id="mail" name="dmail" required="">
                                    <label>Email</label>
                                </div>
                                <div class="input-field">
                                    <input type="tel" class="input" id="tel" name="dtel" required="">
                                    <label>Mobile</label>
                                </div>
                                <div class="input-field">
                                    <select class="form-select" id="dspecial" name="dspecial">
                                        <option value="">Select Specialties</option>
                                        <?php
                                        $specs = $database->query("SELECT * FROM specialties ORDER BY sname ASC");
                                        while ($spec = $specs->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $spec['id'] ?>"><?= $spec['sname'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="input-field col-md-6">
                                        <input type="password" class="input" id="dpassword" name="dpassword" required="">
                                        <label>Password</label>
                                    </div>
                                    <div class="input-field col-md-6">
                                        <input type="password" class="input" name="dcpassword" required="">
                                        <label>Confirm Password</label>
                                    </div>
                                </div>
                                <div class="input-field">
                                    <input type="submit" name="update" class="submit" value="Update">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
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


    <script src="../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
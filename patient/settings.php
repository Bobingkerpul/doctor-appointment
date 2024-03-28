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
$userid = $userfetch["pid"];
$name = $userfetch["pname"];
$usermail = $userfetch["pemail"];
$profile = $userfetch['uploadprofile'];
$pass = $userfetch['ppassword'];

// echo $profile;
// exit;


// Upload Profile Image
$images = "images-profile/";
$uploadOk = 1;

if (isset($_POST['submit'])) {
    $image = $_FILES['upload-image']['name'];
    $target_file = $images . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "gif") {
        $errorimage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    } else if (move_uploaded_file($_FILES['upload-image']['tmp_name'], $target_file)) {

        // echo "UPDATE patient SET uploadprofile='$image' WHERE pid = '$userid'";
        // exit;

        $database->query("UPDATE patient SET uploadprofile='$image' WHERE pid = '$userid'");
        header('location: settings.php');
    }
}


// Change Password
if (isset($_POST['changepass'])) {
    $id = $_POST['id'];
    $oldpass = $_POST['oldpass'];
    $currentpass = $_POST['currentpass'];
    $newpass = $_POST['newpass'];

    if ($oldpass !== $currentpass) {
        $errorpass = 'Unknow Password, Please try again.';
    } else {
        $database->query("UPDATE patient SET ppassword='$newpass' WHERE pid = '$id'");
        $successpass = 'Password Change Successfully';
    }
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
    <title>Patient <?= $name ?></title>
    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/poppins.css">

    <!-- Settings CSS -->
    <link rel="stylesheet" href="../css/settings.css">
</head>

<body>
    <div>
        <?php include_once('./theme/sidemenu.php'); ?>
        <div class="dashboard">
            <div class="intro mb-5">
                <h1>Account Settings</h1>
            </div>
            <div class="setting my-4">
                <nav>
                    <ul class="d-flex flex-row gap-4 p-0">
                        <li><a href="settings.php">General Settings</a></li>
                        <li><a href="settings.php">Update Account</a></li>
                    </ul>
                </nav>
            </div>
            <hr>
            <div class="d-flex flex-row gap-4 mt-5">
                <div style="width: 60%; border:1px solid rgba(0, 0, 0, 0.3); overflow:hidden;" class="shadow rounded p-5">
                    <?php if (isset($errorimage)) {
                    ?>
                        <p style="color: #8E0D0D; font-size: 14px;"><?= $errorimage ?></p>
                    <?php
                    }
                    ?>
                    <?php if (empty($profile)) : ?>
                        <h4>Profile Details</h4>
                        <div class="d-flex flex-row align-items-center gap-4 mt-4">
                            <div class="image-wrapper">
                                <img src="../images/user.png" alt="User" srcset="" class="image-profile">
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <form method="post" action="settings.php" enctype="multipart/form-data">
                                    <div class="d-flex flex-row">
                                        <label for='upload-image' class="custom-file-upload">Upload Profile Photo
                                            <input type='file' name='upload-image' id='upload-image' required>
                                        </label> <br />
                                        <input type='submit' name='submit' value='Upload' style="background: #003083; border:0;">
                                    </div>
                                </form>
                                <p style="font-size: 12px;" class="poppins-light-italic">Only jpg, jpeg, png & gif files are allowed.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-row gap-4 mt-4">
                            <div class="info d-flex flex-column gap-2 w-100">
                                <span style="font-size: 12px;" class="poppins-bold">Username:</span>
                                <span style="padding: 12px 32px 12px 8px; border:1px solid rgba(0, 0, 0, 0.3)" class="poppins-medium rounded"><?= $name ?></span>
                            </div>
                            <div class="info d-flex flex-column gap-2 w-100">
                                <span style="font-size: 12px;" class="poppins-bold">Email:</span>
                                <span style="padding: 12px 32px 12px 8px; border:1px solid rgba(0, 0, 0, 0.3)" class="poppins-medium rounded"><?= $usermail ?></span>
                            </div>

                        </div>

                    <?php else : ?>
                        <h4>Profile Details</h4>
                        <div class="d-flex flex-row align-items-center gap-4 mt-4">
                            <div class="image-wrapper">
                                <img src="./images-profile/<?= $profile ?>" alt="User" class="image-profile">
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <form method="post" action="settings.php" enctype="multipart/form-data">
                                    <div class="d-flex flex-row">
                                        <label for='upload-image' class="custom-file-upload">Upload Profile Photo
                                            <input type='file' name='upload-image' id='upload-image'>
                                        </label> <br />
                                        <input type='submit' name='submit' value='Upload' style="background: #003083; border:0; color:#fff; padding-inline:12px">
                                    </div>
                                </form>
                                <p style="font-size: 12px;" class="poppins-light-italic">Only jpg, jpeg, png & gif files are allowed.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-row gap-4 mt-4">
                            <div class="info d-flex flex-column gap-2 w-100">
                                <span style="font-size: 12px;" class="poppins-bold">Username:</span>
                                <span style="padding: 12px 32px 12px 8px; border:1px solid rgba(0, 0, 0, 0.3)" class="poppins-medium rounded"><?= $name ?></span>
                            </div>
                            <div class="info d-flex flex-column gap-2 w-100">
                                <span style="font-size: 12px;" class="poppins-bold">Email:</span>
                                <span style="padding: 12px 32px 12px 8px; border:1px solid rgba(0, 0, 0, 0.3)" class="poppins-medium rounded"><?= $usermail ?></span>
                            </div>

                        </div>
                    <?php endif; ?>

                </div>

                <div style="width: 40%; border:1px solid rgba(0, 0, 0, 0.3); overflow:hidden;" class="shadow rounded p-5 d-flex flex-column justify-content-between">
                    <?php if (isset($errorpass)) : ?>
                        <h6 style="color: #8E0D0D; font-size: 14px;" class="text-center"><?= $errorpass ?></h6>
                    <?php elseif (isset($successpass)) : ?>
                        <h6 style="color: green; font-size: 14px;" class="text-center"><?= $successpass ?></h6>
                    <?php endif; ?>
                    <h4 class="text-center">Change Password</h4>
                    <p class="text-center" style="font-size: 14px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus laudantium debitis repellendus fuga officia voluptatem pariatur quo ipsum impedit quos?</p>
                    <!-- Button trigger modal View Doctor -->
                    <button type="submit" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#changepass">
                        Change Password
                    </button>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal Change Password -->
    <div class="modal modal-md fade" id="changepass" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Change Password</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <div>
                        <div>
                            <div class="input-box">
                                <form action="" method="post" autocomplete="off">
                                    <div class="input-field">
                                        <input type="hidden" name="id" value="<?= $userid ?>">
                                        <input type="hidden" name="oldpass" value="<?= $pass ?>">
                                        <input type="password" class="input" id="currentpass" name="currentpass" required="">
                                        <label for="currentpass">Current Password</label>
                                    </div>
                                    <div class="input-field">
                                        <input type="password" class="input" id="newpass" name="newpass" required="">
                                        <label for="newpass">New Password</label>
                                    </div>
                                    <div class="input-field">
                                        <input type="submit" name="changepass" class="submit" value="Update Password">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
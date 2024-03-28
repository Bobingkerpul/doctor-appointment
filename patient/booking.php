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
                <div class="search col d-flex flex-row justify-content-between gap-5" style="padding-right:8%">
                    <a href="schedule.php"><button class="btn btn-primary form-control"><img src="../images/icons/back.svg" alt="Back"> Back</button></a>
                    <form action="" method="post" autocomplete="off" style="width: 80%;">
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
            <br>
            <div class="row">
                <?php if (isset($_GET['id'])) :
                    $id = $_GET["id"];
                    // Show All Schedule Sessions
                    $sessions = $database->query("SELECT * FROM schedule AS s INNER JOIN doctor AS d ON s.docid=d.id WHERE s.scheduleid='$id' ORDER BY s.scheduledate DESC");
                    $sessionsched = $sessions->fetch_all(MYSQLI_ASSOC);

                    $apponum1 = $database->query("SELECT * FROM appointment WHERE scheduleid = '$id'");
                    $apponum2 = ($apponum1->num_rows) + 1;
                ?>

                    <div class="d-flex gap-4 flex-row">
                        <?php foreach ($sessionsched as $session) : ?>
                            <div style="width: 60%; border:1px solid rgba(0, 0, 0, 0.3); overflow:hidden;" class="shadow rounded">
                                <h3 class="poppins-light-italic sessionhead">Session Details</h3>
                                <div class="p-4 ">
                                    <h4 class="mb-4"><span class="poppins-bold sessiondet"> Doctor Name:</span> <?= $session['docname'] ?></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span class="poppins-bold sessiondet"> Doctor Email:</span> <br> <?= $session['docemail'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span class="poppins-bold sessiondet"> Session Title:</span> <br> <?= $session['title'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span class="poppins-bold sessiondet"> Session Schedule Date:</span> <br> <?= $session['scheduledate'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p> <span class="poppins-bold sessiondet"> Session Schedule Time:</span> <br> <?= $session['scheduletime'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 40%; border:1px solid rgba(0, 0, 0, 0.3);" class="p-4 shadow rounded d-flex flex-column justify-content-between">

                                <h3 class="text-center poppins-light">Your Appointment Number</h3>
                                <span class="display-2 text-center py-5 apponum"><?= $apponum2 ?></span>
                                <form action="bookingupload.php" method="POST">
                                    <input type="hidden" name="patientid" value="<?= $userid ?>">
                                    <input type="hidden" name="scheduleid" value="<?= $session['scheduleid'] ?>">
                                    <input type="hidden" name="apponum" value="<?= $apponum2 ?>">
                                    <input type="hidden" name="date" value="<?= $date ?>">
                                    <button type="submit" name="booknow" class="btn btn-outline-primary form-control">Book Now</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>


                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
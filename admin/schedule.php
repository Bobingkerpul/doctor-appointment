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

// Select Doctors
$doctors = $database->query("SELECT * FROM doctor ORDER BY docname ASC");
$doctors = $doctors->fetch_all(MYSQLI_ASSOC);






$sessionCount = $database->query("SELECT COUNT(*) AS sessions  FROM schedule");
$sessionCount = $sessionCount->fetch_assoc();



// Filter






if ($_POST) {

    $sqlpt1 = "";
    if (!empty($_POST["scheduledate"])) {
        $sheduledate = $_POST["scheduledate"];
        $sqlpt1 = "$sheduledate";
    }

    $sqlpt2 = "";
    if (!empty($_POST["docid"])) {
        $docid = $_POST["docid"];
        $sqlpt2 = "$docid ";


        // Show All Schedule Sessions
    }
    // echo $sqlpt1;
    // exit;
    $mainsql = $database->query("SELECT s.scheduleid,s.title,d.docname,s.scheduledate,s.scheduletime FROM schedule AS s INNER JOIN doctor AS d ON s.docid=d.id WHERE s.docid = '$sqlpt2'
    OR s.scheduledate = '$sqlpt1'OR (s.docid = '$sqlpt2' AND s.scheduledate = '$sqlpt1')");
    $main = $mainsql->fetch_all(MYSQLI_ASSOC);


    // $main = $mainsql2->fetch_all(MYSQLI_ASSOC);
} else {
    // Show All Schedule Sessions
    $mainsql = $database->query("SELECT s.scheduleid,s.title,d.docname,s.scheduledate,s.scheduletime FROM schedule AS s INNER JOIN doctor AS d ON s.docid=d.id");
    $main = $mainsql->fetch_all(MYSQLI_ASSOC);
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
    <title>Schedule</title>
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
                    <h1>Schedule Manager</h1>
                </div>
                <div class="date">
                    <span>Today's Date</span>
                    <p style="font-size:1.5em"><?= $date ?></p>
                </div>
            </div>
            <div class="row1 mb-5">
                <div class="col-md-6 d-flex flex-row gap-5">
                    <h4>Schedule a Session</h4>
                    <!-- Button trigger Add Session -->
                    <button type="submit" class="btn btn-primary update" data-bs-toggle="modal" data-bs-target="#addSession">
                        <img src="../images/icons/add.svg" class="icon-svg-add">
                        Add a Session
                    </button>

                </div>
            </div>

            <div class="shadow-lg p-4 rounded">
                <div class="all-doctor">
                    <p>All Sessions (<?= $sessionCount['sessions'] ?>)</p>
                </div>

                <div class="filter shadow mb-4 p-4 rounded " style="border: 1px solid rgba(0,0,0,0.2);">
                    <form action="" method="post">
                        <div class="d-flex flex-row gap-4">


                            <div class="col-md-6">
                                <label for="scheduledate">Date:</label>
                                <input type="date" name="scheduledate" id="scheduledate" class="form-control">
                            </div>
                            <div class="col-md-6 d-flex flex-row  ustify-content-center align-items-end form-group">
                                <div class="select">
                                    <label for="scheduledate">Doctor:</label>
                                    <select name="docid" id="" class="form-control">
                                        <option value="" disabled selected hidden>Choose Doctor Name from the list</option>
                                        <?php foreach ($doctors as $doctor) : ?>
                                            <option value="<?= $doctor['id'] ?>"><?= $doctor['docname'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <input type="submit" value="Filter" name="filter" style="width: 20%; height:40px" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary p-3 text-uppercase text-white" style="border-radius: 10px 0px 0px 0px;">Session Name</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Doctor</th>
                            <th class="bg-primary p-3 text-uppercase text-white">Scheduled Date & Time</th>
                            <th class="bg-primary p-3 text-uppercase text-white text-center" colspan="2" style="border-radius: 0px 10px 0px 0px;">Events</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($mainsql->num_rows == 0) : ?>
                            <tr>
                                <td colspan="4">
                                    <p class="text-center">No Data Found!</p>
                                </td>
                            </tr>

                        <?php else : ?>
                            <?php foreach ($main as $session) : ?>
                                <tr>
                                    <td><?= $session['title'] ?></td>
                                    <td><?= $session['docname'] ?></td>
                                    <td><?= $session['scheduledate'] . " " . $session['scheduletime'] ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-outline-primary">View</button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal Schedule -->
    <div class="modal modal-lg fade" id="addSession" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5">Add New Session</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <div class="col right">
                        <div class="input-box">
                            <form action="addschedule.php" method="post" autocomplete="off">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="input-field col-md-6">
                                        <input type="text" class="input" name="session" required="">
                                        <label>Name of this session</label>
                                    </div>
                                    <div class="input-field col-md-6">
                                        <select name="doctorid" class="form-control">
                                            <option disabled selected hidden>Choose Doctor Name from the list</option>
                                            <?php foreach ($doctors as $doctor) : ?>
                                                <option value="<?= $doctor['id']; ?>">Dr. <?= $doctor['docname']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="input-field col-md-6">
                                        <input type="date" class="input" name="date" required="" placeholder="Session Date">
                                    </div>
                                    <div class="input-field col-md-6">
                                        <input type="time" class="input" name="time" required="">
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-between mt-4">
                                    <div class="input-field col-md-6">
                                        <input type="reset" class="submit form-control" value="Reset">
                                    </div>
                                    <div class="input-field col-md-6">
                                        <input type="submit" name="submit" class="submit form-control" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
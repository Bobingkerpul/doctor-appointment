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


// =================================================
// Analytics
$appointment_query = "SELECT scheduleid FROM appointment WHERE status != 0";
$appointment_result = $database->query($appointment_query);


if ($appointment_result->num_rows > 0) {
    $appointmentschart = array();
    while ($row = $appointment_result->fetch_assoc()) {
        $appointmentschart[] = $row['scheduleid'];
    }
}

$schedule_query = "SELECT scheduleid, docid, title, scheduledate, scheduletime FROM schedule";
$schedule_result = $database->query($schedule_query);


if ($schedule_result->num_rows > 0) {
    $schedule_data = array();
    while ($row = $schedule_result->fetch_assoc()) {
        $schedule_data[] = $row;
    }
}

// =================================================

$patients = $database->query("SELECT COUNT(*)AS patients FROM patient");
$patient = $patients->fetch_assoc()['patients'];

$doctors = $database->query("SELECT COUNT(*)AS doctors FROM doctor");
$doctor = $doctors->fetch_assoc()['doctors'];



// Count All Appointment
$appointments = $database->query("SELECT COUNT(*)AS appo FROM appointment WHERE status != 0");
$appointment = $appointments->fetch_assoc()['appo'];


// Count All Session
$schedules = $database->query("SELECT COUNT(*)AS sched FROM schedule");
$schedule = $schedules->fetch_assoc()['sched'];

// Patients
$patients2 = $database->query("SELECT * FROM patient");
$patients2 = $patients2->fetch_all(MYSQLI_ASSOC);
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script src="../js/chartjs.js"></script>
    <title>Admin</title>
    <style>
        .chart-dashboard {
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid rgba(0, 0, 0, 0.2);
            flex-direction: column;
            gap: 20px;
            overflow: hidden;
        }
    </style>
    <!-- Settings CSS -->
    <link rel="stylesheet" href="../css/settings.css">
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
            <div class="dashboard-count mb-5">
                <h4>Status</h4>
                <div class="d-flex flex-row gap-2 mt-2 mb-4">
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $doctor ?></span>
                            <p>Doctors</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/doctor.svg" alt="Doctor">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $patient ?></span>
                            <p>Patients</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/patients.svg" alt="Patient">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $appointment ?></span>
                            <p>Booking</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/schedule1.svg" alt="Patient">
                        </div>
                    </div>
                    <div class="count shadow rounded p-4">
                        <div class="patient-count">
                            <span> <?= $schedule ?></span>
                            <p>Session</p>
                        </div>
                        <div class="icon-display">
                            <img src="../images/icons/schedule1.svg" alt="Patient">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex flex-row gap-4">
                <div class="shadow rounded  chart-dashboard mt-5">
                    <h6 class="p-4 text-white poppins-light w-100 text-center" style="background: #031027;">Insights into Patient Appointment Data</h4>
                        <div class="p-4">
                            <!-- Create a canvas for the chart -->
                            <canvas id="myChart" width="400" height="400"></canvas>
                        </div>
                </div>
                <div class="shadow rounded  chart-dashboard mt-5">
                    <h6 class="p-4 text-white poppins-light w-100 text-center" style="background: #031027;">Comprehensive Status Update</h4>
                        <div class="p-4">
                            <!-- Create a canvas for the chart -->
                            <canvas id="statusadmin" width="400" height="400"></canvas>
                        </div>
                </div>
            </div>
            <div class="shadow allpatient mt-5 rounded overflow-hidden" style="border: 1px solid rgba(0, 0, 0, 0.2);">
                <h5 class="p-4 text-white poppins-light w-100 text-center" style="background: #031027;">All Patients</h5>
                <br>
                <div class="p-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="poppins-bold">Profile</th>
                                <th class="poppins-bold">Name</th>
                                <th class="poppins-bold">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients2 as $patient1) : ?>
                                <tr>
                                    <td>
                                        <div class="profile-name">
                                            <div class="image-wrapper--1">
                                                <img src="../patient/images-profile/<?= $patient1['uploadprofile'] ?>" alt="" class="image-profile">
                                            </div>
                                            <span class="show-name"><?= $patient1['pname'] ?></span>
                                        </div>

                                    </td>
                                    <td><?= $patient1['pname'] ?></td>
                                    <td><?= $patient1['paddress'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================ -->
    <!-- Insights into Patient Appointment Data -->
    <script>
        var data = <?php echo json_encode($schedule_data); ?>;
        var appointments = <?php echo json_encode($appointmentschart); ?>;

        var appointmentCounts = {};
        appointments.forEach(function(scheduleid) {
            appointmentCounts[scheduleid] = (appointmentCounts[scheduleid] || 0) + 1;
        });

        var labels = [];
        var counts = [];
        data.forEach(function(schedule) {
            labels.push(schedule.title);
            counts.push(appointmentCounts[schedule.scheduleid] || 0);
        });

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Appointments',
                    data: counts,
                    backgroundColor: [
                        'rgba(0, 48, 131, 1)',
                        'rgba(106, 113, 190, 1)',
                        'rgba(104, 159, 255, 1)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],

                    borderColor: [
                        'rgba(255, 255, 255, 1)',

                    ],
                    borderWidth: 2
                }]
            },
        });
    </script>
    <!-- ============================ -->


    <!-- ============================ -->
    <!-- Comprehensive Status Update -->
    <script>
        var ctx = document.getElementById('statusadmin').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Patients', 'Doctors', 'Appointments', 'Schedules'],
                datasets: [{
                    label: 'Total Count',
                    data: [<?= "$patient, $doctor, $appointment, $schedule"; ?>],
                    backgroundColor: [
                        'rgba(0, 48, 131, 1)',
                        'rgba(106, 113, 190, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],

                    borderColor: [
                        'rgba(0, 0, 0, 0.5)',

                    ],
                    borderWidth: 1
                }],
            },
            options: {
                indexAxis: 'x',
            }
        });
    </script>
    <!-- ============================ -->


    <script src=" ../js/doctor.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>
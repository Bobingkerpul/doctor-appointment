<?php
session_start();

require_once 'connection.php';

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;

// Function to check if user is logged in
function is_logged_in()
{
    return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
}

// Function to set user status to active
function set_user_active()
{
    $_SESSION["active"] = true;
}

// Function to set user status to inactive
function set_user_inactive()
{
    $_SESSION["active"] = false;
}

if ($_POST) {

    $usermail = $_POST['email'];
    $userpassword = $_POST['password'];

    // echo $userpassword . '' . $usermail;
    // exit;

    $getemail = $database->query("SELECT * FROM webuser WHERE email = '$usermail'");

    if ($getemail->num_rows == 1) {

        $usertype = $getemail->fetch_assoc()['usertype'];
        // echo $usertype;

        if ($usertype == 'p') {
            // Patient Login
            $validate = $database->query("SELECT * FROM patient WHERE pemail = '$usermail' AND ppassword = '$userpassword'");

            if ($validate->num_rows == 1) {

                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'p';
                $_SESSION["logged_in"] = true; // Set user as logged in
                set_user_active(); // Set user status to active

                header('location: patient/index.php');
                exit;
            } else {
                $error = "Wrong credentials: Invalid Email or Password!";
            }
        } else if ($usertype == 'a') {
            // Admin Login
            $validate = $database->query("SELECT * FROM admin WHERE aemail = '$usermail' AND apassword = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'a';
                $_SESSION["logged_in"] = true; // Set user as logged in
                set_user_active(); // Set user status to active

                header('location: admin/index.php');
                exit;
            } else {
                $error =  "Wrong credentials: Invalid Email or Password!";
            }
        } else if ($usertype == 'd') {

            // Doctor Login
            $validate = $database->query("SELECT * FROM doctor WHERE docemail = '$usermail' AND docpassword = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'd';
                $_SESSION["logged_in"] = true; // Set user as logged in
                set_user_active(); // Set user status to active

                header('location: doctor/index.php');
                exit;
            } else {
                $error =  "Wrong credentials: Invalid Email or Password!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <?php if (is_logged_in()) : ?>
        <p>Status: <?php echo ($_SESSION["active"] ? "Active" : "Inactive"); ?></p>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if ($doctor['status'] == 1) : ?>
        <a href="activestatus.php?id=<?= $doctor['id'] ?>&status=0">
            <button class="btn btn-outline-success">Active</button>
        </a>
    <?php else : ?>
        <a href="activestatus.php?id=<?= $doctor['id'] ?>&status=1">
            <button class="btn btn-outline-danger">Inactive</button>
        </a>
    <?php endif; ?>
</body>

</html>
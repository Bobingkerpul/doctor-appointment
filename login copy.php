<?php
session_start();

require_once 'connection.php';

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";


date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;


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

                header('location: patient/index.php');
            } else {
                $error = "Wrong credentials: Invalid Email or Password!";
            }
        } else if ($usertype == 'a') {
            // Admin Login
            $validate = $database->query("SELECT * FROM admin WHERE aemail = '$usermail' AND apassword = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'a';

                header('location: admin/index.php');
            } else {
                $error =  "Wrong credentials: Invalid Email or Password!";
            }
        } else if ($usertype == 'd') {

            // Doctor Login
            $validate = $database->query("SELECT * FROM doctor WHERE docemail = '$usermail' AND docpassword = '$userpassword'");

            if ($validate->num_rows == 1) {
                $_SESSION['user'] = $usermail;
                $_SESSION['usertype'] = 'd';

                header('location: doctor/index.php');
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
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="font/font_family.css">
    <link rel="stylesheet" href="font/global_font.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="backdrop">
                        <!-------------      image     ------------->

                        <a href="index.php"><img src="images/logo/logo-white.svg" alt=""></a>
                        <div class="text text-center">
                            <h4 style="color: #fff; text-transform:uppercase">Welcome Back!</h4>
                            <p>Login with your details to continue</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 right">

                    <div class="input-box">
                        <form action="" method="post" autocomplete="off">
                            <div class="input-field">
                                <input type="text" class="input" id="email" name="email" required="">
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <input type="password" class="input" id="pass" name="password" required="">
                                <label for="pass">Password</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" value="Login">
                            </div>
                            <div class="signin">
                                <p>Don't have an account&#63; <a href="signup.php">Sign Up</a></p>
                            </div>
                            <?php
                            if (isset($error)) {
                            ?>
                                <p style="color: #8E0D0D; font-size: 14px;" class="text-center"><?= $error ?></p>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
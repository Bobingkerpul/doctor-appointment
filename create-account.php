<?php
session_start();

require_once 'connection.php';

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";


date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;


if ($_POST) {

    $email_result = $database->query("select * from webuser");

    $fname = $_SESSION["personal"]['fname'];
    $lname = $_SESSION["personal"]['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION["personal"]['address'];
    $dob = $_SESSION["personal"]['dob'];
    $email = $_POST['email'];
    $mnumber = $_POST['mobile-number'];
    $npassword = $_POST['npassword'];
    $cpassword = $_POST['cpassword'];



    if ($npassword == $cpassword) {
        $email_result = $database->query("select * from webuser where email='$email';");
        if ($email_result->num_rows == 1) {

            $error = "Already have an account for this Email address.";
        } else {

            $database->query("INSERT INTO patient(pemail, pname, ppassword, paddress, pdob, ptel) VALUES ('$email','$name','$npassword','$address','$dob','$mnumber')");
            $database->query("INSERT INTO webuser(email, usertype) VALUES ('$email','p')");

            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = "p";
            $_SESSION['username'] = $fname;

            // echo "INSERT INTO patient(pemail, pname, ppassword, paddress, pdob, ptel) VALUES ('$email','$name','$npassword','$address','$dob','$mnumber')";

            $success =  "Account Successfully Created";
        }
    } else {

        $error = "Password Confirmation Error! Reconfirm Password.";
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
    <link rel="stylesheet" href="css/create-account.css">
    <title>Create Account</title>
</head>

<body class="container">
    <div class="wrapper">
        <div class="container main">
            <div class="row">
                <div class="col-md-6 side-image">
                    <div class="backdrop">
                        <!-------------      image     ------------->
                        <a href="index.php"><img src="images/logo/logo-white.svg" alt=""></a>
                        <div class="text text-center">
                            <h4 style="color: #fff; text-transform:uppercase">Let's Get Started</h4>
                            <p>It's Okey, Now Create User Account</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <form action="" method="post" autocomplete="off">
                            <?php
                            if (isset($success)) {
                            ?>
                                <p><?= $success ?></p>
                            <?php
                            }
                            ?>
                            <div class="d-flex flex-row">
                                <div class="input-field col-md-6">
                                    <input type="mail" class="input" id="email" name="email" required="">
                                    <label for="email">Email</label>
                                </div>
                                <div class="input-field col-md-6">
                                    <input type="tel" class="input" id="mobile-number" name="mobile-number" required="">
                                    <label for="mobile-number">Mobile Number</label>
                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <div class="input-field col-md-6">
                                    <input type="password" class="input" id="npassword" name="npassword" required="">
                                    <label for="npassword">Create New Password</label>
                                </div>
                                <div class="input-field col-md-6">
                                    <input type="password" class="input" id="cpassword" name="cpassword" required="">
                                    <label for="cpassword">Confirm Password</label>
                                </div>
                            </div>

                            <div class="input-field d-flex flex-row">
                                <input type="reset" class="active col-md-6" value="Reset">
                                <input type="submit" class="submit col-md-6" value="Submit">
                            </div>
                            <div class="signin">
                                <p>Already have an account&#63; <a href="login.php">Login</a></p>
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
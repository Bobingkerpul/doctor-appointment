<?php

session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";


date_default_timezone_set('America/New_York');

$date = date('Y-m-d');

$_SESSION["date"] = $date;


if ($_POST) {

    $_SESSION["personal"] = array(
        'fname' => $_POST["fname"],
        'lname' => $_POST["lname"],
        'address' => $_POST["address"],
        'dob' => $_POST["dob"]
    );
    // print_r($_SESSION["personal"]);
    header('location: create-account.php');
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
    <link rel="stylesheet" href="css/sign-up.css">
    <title>Signup</title>
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
                            <p>Add Your Personal Details to Continue</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <div class="input-box">
                        <form action="" method="post" autocomplete="off">
                            <div class="d-flex flex-row">
                                <div class="input-field col-md-6">
                                    <input type="text" class="input" id="name" name="fname" required="">
                                    <label for="name">Name</label>
                                </div>
                                <div class="input-field col-md-6">
                                    <input type="text" class="input" name="lname" required="">
                                    <label for="lname">Last Name</label>
                                </div>
                            </div>

                            <div class="input-field">
                                <input type="text" class="input" id="address" name="address" required="">
                                <label for="address">Address:</label>
                            </div>
                            <div class="input-field">
                                <input type="date" class="input" id="dob" name="dob">
                                <label for="dob">Date of Birth:</label>
                            </div>
                            <div class="input-field d-flex flex-row">
                                <input type="reset" class="active col-md-6" value="Reset">
                                <input type="submit" class="submit col-md-6" value="Next">
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
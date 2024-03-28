<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="font/font_family.css">
    <link rel="stylesheet" href="font/global_font.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="icon" href="./images/logo/favicon.ico">
    <title>Doctor Appointment</title>
    <!-- Poppins Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/poppins.css">
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.php" style="color:black;">
                        <img src="images/logo/logo.svg" alt=" Doctor Appointment">
                    </a>
                    <a href="index.php" style="color:black;">
                        <img src="images/logo/logo-white.svg" alt=" Doctor Appointment" class="logo-white">
                    </a>
                </div>

                <div class="header-menu">
                    <div class="hamburger-menu" id="hamburger-menu">
                        <img src="./images/icons/menu.svg" alt="Menu">
                    </div>
                    <nav class="navbar" id="navbar">
                        <ul>
                            <li><a href="login.php"><img src="images/icons/login.svg" alt="Login"> Login</a></li>
                            <li><a href="signup.php"><img src="images/icons/register.svg" alt="Register"> Register</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="row">
            <div class="main-container col-6">
                <div class="rotate-svg">
                    <img src="images/background.svg" alt="Background">
                </div>
                <div class="main-wrapper">
                    <div class="main-content">
                        <div>
                            <span class="sub-heading">Patient-Centric Solutions</span>
                            <span class="sub-heading">Intelligent Internet-Based Scheduling with</span>
                        </div>
                        <h1><span style="color:#003083">Data Analytics</span> <span style="color: #8E0D0D;">Transforming Doctor's Appointments</span></h1>
                        <p>As traditional appointment systems face challenges, this dynamic solution seeks to redefine the healthcare experience</p>
                    </div>
                    <a href="login.php"><button class="btn-pramary-1 btn btn-primary">Make Appointment<img src="images/icons/arrow.svg" class="btn-icon" alt="Arrow"></button></a>
                </div>
            </div>

            <div class="background-image col-6">
                <!-- <img src="images/Background.png" alt="Background"> -->
            </div>
        </div>

        <div class="row about-us">
            <div class="row  px-5 pb-5">
                <div class="col-md-6 ">
                    <div class="image">
                        <img src="./images/AboutUs-1.png" class="about-image">
                    </div>
                </div>
                <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                    <h2 class="poppins-bold" style="color:#003083">About Us</h2>
                    <p>At <span class="poppins-bold">City Health Office(CHO)</span>, we understand the importance of efficient and convenient healthcare services. Our Doctor's Appointment System is designed to streamline the appointment booking process, making it easier for patients to access the care they need when they need it.</p>
                </div>
            </div>
            <div class="row px-5">

                <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                    <h2 class="poppins-bold" style="color:#003083">Our Mission</h2>
                    <p>Our mission is to provide exceptional healthcare services that prioritize patient comfort, convenience, and well-being. With our user-friendly appointment system, we aim to empower patients to take control of their healthcare journey by facilitating seamless communication between patients, doctors, and administrative staff.</p>
                </div>
                <div class="col-md-6 ">
                    <div class="image2">
                        <img src="./images/AboutUs-2.png" class="about-image w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-5">
            <div class="intro text-center py-5" style="background-color: white;">
                <h2 class="poppins-bold" style="color:#003083">Our Services</h2>
                <p>Lorem ipsum dolor sit amet consectetur <br />adipisicing elit. Ipsam, aperiam.</p>
            </div>

            <div class="col-4 p-0 services">
                <img src="./images/doctor.jpg" class="services-image">
                <p class="p-5 text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis non eum maxime rerum, nostrum ad quas labore sunt repellat corporis?</p>
            </div>
            <div class="col-4 p-0 services">
                <p class="p-5 text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis non eum maxime rerum, nostrum ad quas labore sunt repellat corporis?</p>
                <img src="./images/signup-bg.jpg" class="services-image">
            </div>
            <div class="col-4 p-0 services">
                <img src="./images/create-bg.jpg" class="services-image">
                <p class="p-5 text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis non eum maxime rerum, nostrum ad quas labore sunt repellat corporis?</p>
            </div>
        </div>
        <div class="row">
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3320.839603048609!2d126.35164177886168!3d8.186018754060756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32fdbbd49e0ca90b%3A0xee7ffb680d8d92f1!2sMangagoy%20City%20Health%20Office!5e0!3m2!1sen!2sph!4v1710342631293!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

    </main>

    <footer class="footer">
        <div class="d-flex flex-row gap-5 justify-content-between">
            <div class="col-3 d-flex flex-column gap-4">
                <div class="logo">
                    <a href="index.php">
                        <img src="./images/logo/logo-white.svg" alt="Logo">
                    </a>
                </div>
                <div class="text">
                    <p class="text-white poppins-extralight" style="font-size: 14px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem, repellendus! Obcaecati aut excepturi velit blanditiis exercitationem ratione quod sint sed!</p>
                </div>
            </div>
            <div class=" col-3">
                <h4 class="text-white">ADDRESS</h4>
                <div class="address">
                    <ul class="p-0">
                        <li class="text-white poppins-light" style="font-size: 14px;">BIslig, Surigao del Sur</li>
                        <li><a href="mailto:lahdz6tbdots@gmail.com" class="text-white poppins-light" style="font-size: 14px;">lahdz6tbdots@gmail.com</li></a>
                        <li class="text-white poppins-light" style="font-size: 14px;">REGION XIII (CARAGA)</li>
                    </ul>
                </div>
            </div>
            <div class="col-3">
                <h4 class="text-white">SOCIAL MEDIA</h4>
                <div class="address">
                    <ul class="p-0 d-flex flex-row gap-2">
                        <li><a href="#"><img src="./images/icons/facebook.svg" alt="Facebook" style="width: 40px;"></a></li>
                        <li><a href="#"><img src="./images/icons/instagram.svg" alt="Facebook" style="width: 40px;"></a></li>
                        <li><a href="#"><img src="./images/icons/linkedin.svg" alt="Facebook" style="width: 40px;"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="./js/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hamburger-menu').click(function() {
                $('#navbar').toggleClass('active').stop(true, true).slideToggle(300);
            });
        });
    </script>
</body>

</html>
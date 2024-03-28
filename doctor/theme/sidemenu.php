<div class="menu">
    <div class="menu-container mt-4">
        <div class="profile-container d-flex flex-row gap-3 align-items-center mb-4">
            <?php if (empty($profile)) : ?>
                <div class="active-doctor">
                    <div class="image">
                        <img src="../images/user.png" alt="User">
                    </div>
                    <?php if ($status == 1) : ?>
                        <span class="active-doctor-dots"></span>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="active-doctor">
                    <div class="image">
                        <img src="./images-profile/<?= $profile ?>" alt="User">
                    </div>
                    <?php if ($status == 1) : ?>
                        <span class="active-doctor-dots"></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="patient-name">
                <p class="profile-title text-white m-0"><?= substr($name, 0, 13) ?></p>
                <p class="profile-title text-white m-0"><?= substr($usermail, 0, 22) ?></p>
            </div>
        </div>
        <div class="logout mb-5">
            <a href="../logout.php"><button type="submit" class="logout-btn btn btn-light w-100"> Log Out</button></a>
        </div>
        <div>
            <ul class="menu-dashboard">
                <li class="menu-row">
                    <a href="index.php" class="d-flex gap-3 text-white">
                        <img src="../images/icons/dashboard.svg" class="icon-svg" alt="Dashboard">Dashboard
                    </a>
                </li>
                <li class="menu-row">
                    <a href="appointment.php" class="d-flex gap-3 text-white">
                        <img src="../images/icons/doctor.svg" class="icon-svg" alt="Doctor">My Appointment
                    </a>
                </li>
                <li class="menu-row">
                    <a href="schedule.php" class="d-flex gap-3 text-white">
                        <img src="../images/icons/schedule.svg" class="icon-svg" alt="Schedule">My Sessions
                    </a>
                </li>
                <li class="menu-row">
                    <a href="mypatients.php" class="d-flex gap-3 text-white">
                        <img src="../images/icons/appointment.svg" class="icon-svg" alt="Appointment">My Patients
                    </a>
                </li>
                <li class="menu-row">
                    <a href="settings.php" class="d-flex gap-3 text-white">
                        <img src="../images/icons/settings.svg" class="icon-svg" alt="Patients">Settings
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
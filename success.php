<?php
ob_start();
session_start();
include 'connection.php';

$user = null;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = $pdo->prepare("SELECT customer_name.cid,customer_name.cfname, customer_name.cmname, customer_name.clname, loginscred.username, loginscred.email, customer_info.contact_no FROM customer_name JOIN loginscred ON customer_name.cid = loginscred.cid JOIN customer_info on customer_name.cid = customer_info.cid WHERE loginscred.username = :username");
    $query->execute(['username' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="pentastyle.css">

</head>
<body>
    <div class="bodies">
    <header>
    <div class="header-content">
        <a href="index.php" class="logo-name">Studio Ponkan</a>
        <nav class="navbar">
            <ul class="menu-links">
                <li><a href="#Home-section">Home</a></li>
                <li><a href="booking.php">Book</a></li>
                <li><a href="#down-section">Download</a></li>
                <li><a href="#about-section">FAQs</a></li>
                <li class="login-link">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<a href="profile.php">' . $_SESSION['username'] . '</a>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="profile.php">' . $_SESSION['username'] . '</a>';
                        echo '<a href="Account_management.php">Settings</a>';
                        echo '<a href="order.php">Schedule</a>';
                        echo '<a href="logout.php">Logout</a>';
                        echo '</div>';
                    } else {
                        echo '<a href="login.php">LogIn</a>';
                        echo '<div class="dropdown-content">';
                        echo '<a href="login.php">LogIn</a>';
                        echo '<a href="register.php">Register</a>';
                        echo '</div>';
                    }
                    ?>
                </li>
            </ul>
        </nav>
    </div>
</header>

        <section class="penta">
        <div class="quadra">
            <h1>Thank You For Choosing our Service!!</h1>
            <h4>We Ensure That We Will Perform Our Duty On The Given Date <br> <br>
                Click The Schedule To See Your Reservation
            </h4>
            <button class="sched" id="scheds">Home</button>
            <button class="blk" id="blks">Schedule</button>
    </div>

        </section>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var homeButton = document.getElementById('scheds');
    var scheduleButton = document.getElementById('blks');

    homeButton.addEventListener('click', function() {
        window.location.href = 'index.php';
    });

    scheduleButton.addEventListener('click', function() {
        window.location.href = 'order.php';
    });


    var navLinks = document.querySelectorAll('.menu-links a[href^="#"]');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var targetSection = this.getAttribute('href');
            window.location.href = 'index.php' + targetSection;
        });
    });
});
</script>

</body>
</html>
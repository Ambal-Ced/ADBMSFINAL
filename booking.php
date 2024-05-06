<?php
session_start(); // Start the session
include 'connection.php';
$user = null; // Initialize $user to null

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
    <title>Booking</title>
    <link rel="stylesheet" href="style.css">


    <?php
require_once 'connection.php';
?>
</head>
<body>
    <div class="bodies">

<header>
    <div class="header-content">
        <a href="index.php" class="logo-name">Studio Ponkan</a>
        <nav class="navbar">
            <ul class="menu-links">
                <li><a href="index.php#Home-section">Home</a></li>
                <li><a href="booking.php">Book</a></li>
                <li><a href="index.php#down-section">Download</a></li>
                <li><a href="index.php#about-section">FAQs</a></li>
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
<!--Add more HTML here-->
<section class="package-A-portrait">
    <img src="resources/bookingpic/pa.png" alt="" srcset="" class="pht">
    <p>PORTRAIT PACKAGE A<br><br>
					Php 500 per PAX <br> <br>
					2 FINAL LAYOUTS
					PROFESSIONAL
					CAMERA AND LIGHT <br>
					SET UP.
					<br><br>
					ALL RAW AND ENHANCE PHOTO
	</p>
</section>
<section class="package-B-portrait">
<img src="resources/bookingpic/pb.png" alt="" srcset="" class="pht">
<p>PORTRAIT PACKAGE B<br>
					Php 700 per PAX <br> <br>
					4 FINAL LAYOUTS
					PROFESSIONAL
					CAMERA AND LIGHT <br>
					SET UP.
					<br> <br>
					ALL RAW
					AND ENHANCE PHOTO
				</p>
</section>
<section class="package-C-portrait">
<img src="resources/bookingpic/pc.png" alt="" srcset="" class="pht">
<p>PORTRAIT PACKAGE C<br>
					Php 1,300 per PAX <br> <br>
					6 FINAL LAYOUTS 
					PROFESSIONAL
					CAMERA AND LIGHT <br>
					SET UP.
					<br> <br>
					ALL RAW
					AND ENHANCE PHOTO
				</p>
</section>
<section class="package-A-food">
<img src="resources/bookingpic/fa.png" alt="" srcset="" class="pht">
<p>FOOD ENTICES PACKAGE A<br>Php 5,000
					10 - 15 DISHES
					<br><br>
					BASIC FOOD STYLING
					AND CONSULTATION <br>
					PROFESSIONAL
					CAMERA AND LIGHT
					SET UP. <br><br>
					3 DAYS TURN OVER <br>

				</p>
</section>
<section class="package-B-food">
<img src="resources/bookingpic/fb.png" alt="" srcset="" class="pht">
<p>FOOD ENTICES PACKAGE B<br>Php 7,000
                    20 - 30 DISHES
					<br><br>
					BASIC FOOD STYLING
					AND CONSULTATION <br>
					PROFESSIONAL
					CAMERA AND LIGHT
					SET UP. <br><br>
					3 DAYS TURN OVER <br>

				</p>
</section>
<section class="package-C-food">
<img src="resources/bookingpic/fc.png" alt="" srcset="" class="pht">
<p>FOOD ENTICES PACKAGE C<br>Php 10,000
                    40 - 50 DISHES
					<br><br>
					BASIC FOOD STYLING
					AND CONSULTATION <br>
					PROFESSIONAL
					CAMERA AND LIGHT
					SET UP. <br><br>
					3 DAYS TURN OVER <br>

				</p>
</section>
<section class="package--currated">
    <img src="resources/bookingpic/cup.png" alt="" srcset="" class="pht">
    <p>
        CURATED PACKAGE <br><br>
					3 FINAL LAYOUTS PER DISH
					<br>
					PROFESSIONAL TOP
					NOTCH CAMERA AND
					COMPLETE <br>LIGHT SET UP.
					<br><br>
					3 MIN DISHES
					PRICE VARIES ON DIFFICULTY <br>OF
					PEG AND CONCEPT
					<br><br>
					Php 2,000 per dish
	</p>
</section>
<section>
    <div class="as-whole">
    <form method="POST" action="process_booking.php">
<div class="option-container">

<div class="Addressing">
<input type="hidden" name="productvalues" id="productvalues" value="">
    <p>First Name: <?php echo $user ? htmlspecialchars($user['cfname']) : 'Not Log In'; ?></p>
    <p>Middle Name: <?php echo $user ? htmlspecialchars($user['cmname']) : 'Not Log In'; ?></p>
    <p>Last Name: <?php echo $user ? htmlspecialchars($user['clname']) : 'Not Log In'; ?></p>
    <p>Email: <?php echo $user ? htmlspecialchars($user['email']) : 'Not Log In'; ?></p>
    <p>Contact No. : <?php echo $user ? htmlspecialchars($user['contact_no']) : 'Not Log In'; ?></p>
    <p>Unique ID : <?php echo $user ? htmlspecialchars($user['cid']) : 'Not Log In'; ?></p>

    <label for="addresses">Event Address: </label>
    <input class="poutinno" type="text" name="adresses" id="addresses" autocomplete="off" required>
    <label for="eventDate"><br>Event Date:</label>
    <input type="date" id="eventDate" name="eventDate" placeholder="MM/DD/YYYY" required>
    </div>
    <div class="prduct">
    <label for="products">Product: </label>
    <input type="text" name="products" id="selectedOption" class="boxread" readonly>
    <button id="showOptions" type="button" >Show Products</button>
    <div id="options" class="options-hidden">
            <a class="option" data-value="1">Portrait Package A Php 500 per PAX 2 FINAL LAYOUTS</a>
            <a class="option" data-value="2">Portrait Package B Php 700 per PAX 4 FINAL LAYOUTS</a>
            <a class="option" data-value="3">Portrait Package C Php 1,300 per PAX  6 FINAL LAYOUTS</a>
            <a class="option" data-value="4">Food Entices Package A Php 5,000 10 - 15 DISHES</a>
            <a class="option" data-value="5">Food Entices Package B Php 7,000 20 - 30 DISHES</a>
            <a class="option" data-value="6">Food Entices Package C Php 10,000 40 - 50 DISHES</a>
            <a class="option" data-value="7">Currated Package Php 2,000 per dish 3 FINAL LAYOUTS PER DISH</a>
    </div>
    </div>
    <div class="posit">
    <button id="submit" class="sdm">Submit</button>
    </div>
</div>
    </form>
</div>
</section>
<script src="opt.js"></script>
<script src="debg.js"></script>
</div>
</body>
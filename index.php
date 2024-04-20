<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
<?php
session_start();
?>
</head>
<body>
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
                        echo '<a href="settings.php">Settings</a>';
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



<!--Home-->
    <section class="Homesection" id="Home-section">
		<div class="content">
			<h1>Studio Ponkan Serves picture with a smile</h1>
			<p>
				By serving the most promising picture we
				made everyone smile everyday. Awaken the beauty of your self
			</p>
			<button onclick="location.href = 'booking.html'">Book Now!</button>
			<button onclick="DownloadPage()">Download Your Picture</button>
		</div>
    </section>





<!--Download-->
    <section class="downsection" id="down-section">
        <div class="downcontent">
            <h1>Thank You For Choosing Our Service</h1>
                <h3>The Ponkan Staff Will Give You A Code</h3>
                    <p>We The Ponkan Studio, Do our Best to ensure youre picture quality
                    <br>will be the best and easy to download. We express our gratitude <br>
                    on choosing our studio for taking your memorable picture <br> <br>
                    </p>
                        <div class="texttinput">
                            <input type="text" placeholder="Enter Code Here" id="CodePic" class="inputtsize">
                        </div>
        <div class="dlbutton"><button id="dlpic">Download Now!</button></div>
            <br>
        </div>
	</section>






<!--About-->
        <section class="aboutsection" id="about-section">
            <div class="acontent">

                <div class="logo-ponkan"><img src="#" alt=""></div>
                
                <h1>STUDIO PONKAN</h1>
                Studio Ponkan specializes in capturing the perfect moment in the ideal
                environment. For us, photography is about letting people to be themselves
                and then capturing an image of that moment that we may treasure it forever.
                We are a devoted team of professional photographers that specialize in
                creating and advertising one-stop  creative solutions. Our studio is equipped
                with innovative photography equipment and technology, resulting in high-quality
                photographs that exceed expectations . We collaborate with businesses and
                people to create unique and specific imagery. Studio Ponkan can ensure that
                your most unforgettable moments are captured and enjoyed forever.
                Join us as we explore the wonders of life through the lenses of invention and
                creativity.
                </p>
                <div class="logo-idev"><img src="#" alt=""></div>
                
                <h1>INTERFACE DEVELOPER</h1>
                <p>A Group of 2nd Year BSIT Student Year 2023-2024, Who Aims to Help Many Company Who Needs a Lightweight System
                For Their Company. <br> <br><h1>Vision</h1> <br> Driving forward the frontiers of software development, we strive to create solutions that transform challenges into opportunities.
                <br> <br><h1> Mission </h1><br><br> Innovation: Pioneering new technologies and solutions to drive progress and efficiency.
                Sustainability: Developing solutions that are environmentally friendly and contribute to a sustainable future.
                Optimization: Continuously refining and improving systems to enhance performance and user experience
                Scalability: Designing systems that can grow and adapt to increasing demands, ensuring long-term viability and success.
                Security: Protecting data and systems from threats, ensuring the integrity and confidentiality of information.
                </p>
            </div>


    </section>






    <script src="script.js"></script>
</body>
</html>
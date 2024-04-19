<?php
session_start(); // Start the session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <?php
require_once 'resources/dtbs/connection.php';
?>
</head>
<body>
    <div class="bodies">

        <body>
            <header>
                <div class="header-content">
                <a href="index.html" class="logo-name">Studio Ponkan</a>
                <nav class="navbar">
                    <ul class="menu-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="booking.php">Book</a></li>
                        <li><a href="#download-section">Download</a></li>
                        <li><a href="#about-section">FAQs</a></li>
                        <li>                    <?php
                            if (isset($_SESSION['username'])) {
                                echo '<a href="#">' . $_SESSION['username'] . '</a>';
                            } else {
                                echo '<a href="#">Login</a>';
                            }
                            ?>
                        </li>
                    </ul>
                </nav>
            </div>
            </header>



</div>
</body>
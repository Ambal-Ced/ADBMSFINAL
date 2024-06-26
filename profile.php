<?php
ob_start(); // Start output buffering
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
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="header-content">
        <a href="index.php" class="logo-name">Studio Ponkan</a>
        <nav class="navbar">
            <ul class="menu-links">
                <li><a href="index.php#Home-div">Home</a></li>
                <li><a href="booking.php">Book</a></li>
                <li><a href="index.php#down-div">Download</a></li>
                <li><a href="index.php#about-div">FAQs</a></li>
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



<div class="user-info">
    <div class="styling">
    <h2>User Info</h2>
    <h3>Your Personal Info @Studio Ponkan <br><br>
    </h3>
    <h2>Basic Info</h2>
    <p>Username: <?php echo $user ? htmlspecialchars($user['username']) : ''; ?></p>
    <p>First Name: <?php echo $user ? htmlspecialchars($user['cfname']) : ''; ?></p>
    <p>Middle Name: <?php echo $user ? htmlspecialchars($user['cmname']) : ''; ?></p>
    <p>Last Name: <?php echo $user ? htmlspecialchars($user['clname']) : ''; ?></p>
    <p>Unique ID: <?php echo$user ? htmlspecialchars($user['cid']) : ''?></p>
    <h2>Contact Information</h2>
    <p>Email: <?php echo $user ? htmlspecialchars($user['email']) : ''; ?> </p>
    <p>Contact No.: <?php echo $user ? htmlspecialchars($user['contact_no']) : '';?> <a href="editnum.php" class="editnum"> edit</a></p>

    <div class="edit-profile-link">
        <a href="Edit.php">Edit Profile</a>
        <a href="Account_management.php">Edit Account</a>
    </div>
    </div>
</div>


</body>
</html>
<?php
ob_end_flush();
?>

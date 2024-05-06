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
<?php
include 'connection.php';
$errorMessage = '';
if (isset($_GET['error']) && $_GET['error'] == 'invalid_contact_no') {
    $errorMessage = 'Invalid Number';
}
?>
<?php
include 'connection.php';

if (isset($_POST['editnum'])) {
    $contact_no = $_POST['editnum'];
    $username = $_SESSION['username'];

    // Check if the contact number is 10 or 11 characters long
    if (strlen($contact_no) >= 10 && strlen($contact_no) <= 11) {
        // Prepare the SQL statement
        $query = $pdo->prepare("UPDATE customer_info SET contact_no = :contact_no WHERE cid = (SELECT cid FROM loginscred WHERE username = :username)");
        $query->execute(['contact_no' => $contact_no, 'username' => $username]);

        // Redirect back to the profile page or another page after successful update
        header("Location: profile.php");
        exit;
    } else {
        header("Location: editnum.php?error=invalid_contact_no");
    }
    if (isset($_GET['error']) && $_GET['error'] == 'invalid_contact_no') {
        $errorMessage = 'Invalid Number';
    } else {
        $errorMessage = '';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
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
<section class="tep">
    <div class="foll">
        <form action="editnum.php" method="post">
            <div class="asd">
                <div class="sep">
                    <a href="profile.php">X</a>
                </div>
                <label for="editnum" class="edittnumm">Contact no</label>
                <p>A contact number is a phone number that someone can be contacted on. It is used for various purposes, such as reaching out to 
                    a person or a company or facilitating communication during specific times. 
                    Contact numbers are essential for maintaining communication<br></p>
                <input class="ttextt" type="text" id="editnum" name="editnum" autocomplete="off" value="<?php echo isset($user['contact_no']) ? $user['contact_no'] : ''; ?>">
                <?php if (!empty($errorMessage)) {
                    echo '<div class="error-message">' . $errorMessage . '</div>';
                }?>
                <div class="bnt">
                    <button class="btttn" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>
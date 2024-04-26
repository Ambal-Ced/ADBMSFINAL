<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch the current user's information
$username = $_SESSION['username'];
$query = $pdo->prepare("SELECT customer_name.cfname, customer_name.cmname, customer_name.clname, loginscred.email FROM customer_name JOIN loginscred ON customer_name.cid = loginscred.cid WHERE loginscred.username = :username");
$query->execute(['username' => $username]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $midlename = $_POST['midlename'];
    $lastname = $_POST['lastname'];

    $newUsername = $_POST['newusername'];

    // Validate and sanitize input
    $firstname = filter_var($firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $midlename = filter_var($midlename, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($lastname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $newUsername = filter_var($newUsername, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Update the customer_name table
        $updateCustomerNameQuery = $pdo->prepare("UPDATE customer_name SET cfname = :firstname, cmname = :midlename, clname = :lastname WHERE cid = (SELECT cid FROM loginscred WHERE username = :username)");
        $updateCustomerNameQuery->execute(['firstname' => $firstname, 'midlename' => $midlename, 'lastname' => $lastname, 'username' => $username]);

        // Update the loginscred table
        $updateLoginsCredQuery = $pdo->prepare("UPDATE loginscred SET username = :newUsername WHERE username = :username");
        $updateLoginsCredQuery->execute(['newUsername' => $newUsername, 'username' => $username]);

        // Commit the transaction
        $pdo->commit();

        // Update the session variable
        $_SESSION['username'] = $newUsername;

        // Redirect back to the profile page or show a success message
        header("Location: profile.php");
        exit;
    } catch (PDOException $e) {
        // Rollback the transaction on failure
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
<div class="container">
    <div class="cont">
        <div class="ainer"><a href="profile.php">X</a></div>
    <form action="Edit.php" method="post">
        <div class="field input">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($user['cfname']); ?>" required>
        </div>
        <div class="field input">
            <label for="midlename">Middle Name</label>
            <input type="text" name="midlename" id="midlename" value="<?php echo htmlspecialchars($user['cmname']); ?>" required>
        </div>
        <div class="field input">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo htmlspecialchars($user['clname']); ?>" required>
        </div>

        <div class="field input">
            <label for="newusername">New Username</label>
            <input type="text" name="newusername" id="newusername" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="field">
            <input type="submit" class="btn" value="Update Profile">
        </div>
    </form>
    </div>
</div>
</body>
</html>

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
$query = $pdo->prepare("SELECT loginscred.email, loginscred.passwords FROM loginscred WHERE username = :username");
$query->execute(['username' => $username]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['newPassword'])) {
        // Handle password update
        $newPassword = $_POST['newPassword'];
        $currentPassword = $_POST['currentPassword'];
        $newPasswordConfirm = $_POST['newPasswordConfirm'];

        // Check if new passwords match
        if ($newPassword !== $newPasswordConfirm) {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>New passwords do not match.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        // Verify the entered current password against the stored password
        if (!password_verify($currentPassword, $user['passwords'])) {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Incorrect Current Password.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Update the loginscred table
            $updateLoginsCredQuery = $pdo->prepare("UPDATE loginscred SET passwords = :passwords WHERE username = :username");
            $updateLoginsCredQuery->execute(['passwords' => $hashedPassword, 'username' => $username]);

            // Commit the transaction
            $pdo->commit();

            // Redirect back to the profile page or show a success message
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            // Rollback the transaction on failure
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['email'])) {
        // Handle email update
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        // Check if passwords match
        if ($password !== $passwordConfirm) {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Passwords do not match.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        // Verify the entered password against the stored password
        if (!password_verify($password, $user['passwords'])) {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Incorrect Password.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Update the loginscred table
            $updateLoginsCredQuery = $pdo->prepare("UPDATE loginscred SET email = :email WHERE username = :username");
            $updateLoginsCredQuery->execute(['email' => $email, 'username' => $username]);

            // Commit the transaction
            $pdo->commit();

            // Redirect back to the profile page or show a success message
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            // Rollback the transaction on failure
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
<?php
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch the current user's information
$username = $_SESSION['username'];
$query = $pdo->prepare("SELECT loginscred.email, loginscred.passwords, loginscred.cid FROM loginscred WHERE username = :username");
$query->execute(['username' => $username]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['deleteAccount'])) {
        // Handle account deletion
        $deletePassword = $_POST['deletePassword'];
        $deletePasswordConfirm = $_POST['deletePasswordConfirm'];
        $deleteConfirm = $_POST['deleteConfirm'];

        // Check if passwords match
        if ($deletePassword !== $deletePasswordConfirm) {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Password do not match.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        // Verify the entered password against the stored password
        if (!password_verify($deletePassword, $user['passwords'])) {
            echo'<link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Incorrect Password.</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        // Check if the user typed 'delete' in the confirmation field
        if ($deleteConfirm !== 'delete') {
            echo'    <link rel="stylesheet" href="style.css">
            <link rel="stylesheet" href="abt.css">';
            echo '<div class="errorr"><p>Please type "delete" to delete</p>';
            echo '<a href="Account_management.php">Go Back</a></div>';
            exit;
        }

        try {
            // Start a transaction
            $pdo->beginTransaction();

            // Delete the user from the loginscred table
            $deleteQuery = $pdo->prepare("DELETE FROM loginscred WHERE username = :username");
            $deleteQuery->execute(['username' => $username]);

            // Update the customer_name table to set the user's name to 'deleted'
            $updateCustomerNameQuery = $pdo->prepare("UPDATE customer_name SET cfname = 'deleted', cmname = 'deleted', clname = 'deleted' WHERE cid = :cid");
            $updateCustomerNameQuery->execute(['cid' => $user['cid']]);

            // Commit the transaction
            $pdo->commit();

            // Redirect to a page indicating account deletion or log the user out
            header("Location: account_deleted.php");
            exit;
        } catch (PDOException $e) {
            // Rollback the transaction on failure
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
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
    <link rel="stylesheet" href="abt.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<div class="contain">
<div class="cont">
    <h4>Email Address</h4>
    <p>Email addresses are essential for both personal and professional communication, allowing individuals and 
        businesses to communicate digitally. They are used in various contexts, including professional networking, 
        customer service, and personal correspondence. <br><br> Here You can Edit Your Email Address</p>
    <button id="editEmailBtn">Edit Email</button>
    <div id="emailEditForm" class="email-edit-form">
        <form method="post">
            <div class="field input">
                <div class="tree"><a href="Account_management.php">X</a></div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="field input">
                <label for="password">Current Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="field input">
                <label for="passwordConfirm">Confirm Password</label>
                <input type="password" name="passwordConfirm" id="passwordConfirm" required>
            </div>
            <div class="field">
                <input type="submit" class="btn" value="Update Profile">
            </div>
        </form>
    </div>

    <h4>Account Password</h4>
    <p>An account password is a secret word or string of characters used to authenticate a user's 
        identity and grant access to a specific account or resource. <br><br>You Can Change Your Password Here</p>
    <button id="editPasswordBtn">Change Password</button>
    <div id="passwordEditForm" class="password-edit-form">
        <form method="post">
            <div class="field input">
            <div class="tree"><a href="Account_management.php">X</a></div>
                <label for="newPassword">New Password</label>
                <input type="password" name="newPassword" id="newPassword" required>
            </div>
            <div class="field input">
                <label for="newPasswordConfirm">Confirm New Password</label>
                <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" required>
            </div>
            <div class="field input">
                <label for="currentPassword">Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" required>
            </div>
            <div class="field">
                <input type="submit" class="btn" value="Update Password">
            </div>
        </form>
    </div>
    <h4>Delete Account</h4>
    <p>An account is a user account that allows individuals to access and manage their personal space on that platform. 
        This account contains a variety of information, ranging from private details to information. 
        An account is essentially a digital identity that users create and manage on a Studio Ponkan in order to enjoy the services 
    we provide. By deleting it You will lose your progress and account information <br> <br> You can Delete Your Account Here</p>
    <button id="deleteAccountBtn">Delete Account</button>
    <div id="deleteAccountForm" class="delete-account-form" style="display: none;">
        <form method="post">
            <div class="field input">
            <div class="tree"><a href="Account_management.php">X</a></div>
                <label for="deletePassword">Current Password</label>
                <input type="password" name="deletePassword" id="deletePassword" required>
            </div>
            <div class="field input">
                <label for="deletePasswordConfirm">Confirm Password</label>
                <input type="password" name="deletePasswordConfirm" id="deletePasswordConfirm" required>
            </div>
            <div class="field input">
                <label for="deleteConfirm">Type 'delete' to confirm</label>
                <input type="text" name="deleteConfirm" id="deleteConfirm" required>
            </div>
            <div class="field">
                <input type="submit" class="btn" name="deleteAccount" value="Delete Account">
            </div>
        </form>
    </div>
    </div>
</div>
<script src="abt.js"></script>
<script>
$(document).ready(function() {
    $('#deleteAccountBtn').click(function() {
        $('#deleteAccountForm').toggle();
    });
});
</script>
</body>
</html>
<?php
session_start();

include("connection.php");

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $Contact = $_POST['Contact'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['midlename'];

    // Hash the password using the PASSWORD_DEFAULT algorithm
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a unique ID
    do {
        $GenerateNumber = mt_rand(1, 99999);
        $IDCODENumber = sprintf('%05d', $GenerateNumber);

        // Check if the ID exists in the customer_name table
        $checkSql = "SELECT * FROM customer_name WHERE cid = :cid";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':cid', $IDCODENumber);
        $checkStmt->execute();
    } while ($checkStmt->rowCount() > 0);

    // Check if the email or username already exists
    $checkUserSql = "SELECT * FROM loginscred WHERE email = :email OR username = :username";
    $checkUserStmt = $pdo->prepare($checkUserSql);
    $checkUserStmt->bindParam(':email', $email);
    $checkUserStmt->bindParam(':username', $username);
    $checkUserStmt->execute();

    if ($checkUserStmt->rowCount() > 0) {
        echo "Email or username already registered!";
        exit;
    }

    // Insertion of created data into customer_name table
    $insertSql = "INSERT INTO customer_name (cid, cfname, cmname, clname) VALUES (:cid, :firstname, :midlename, :lastname)";
    $insertStmt = $pdo->prepare($insertSql);
    $insertStmt->bindParam(':cid', $IDCODENumber);
    $insertStmt->bindParam(':firstname', $firstname);
    $insertStmt->bindParam(':midlename', $middlename);
    $insertStmt->bindParam(':lastname', $lastname);
    $insertStmt->execute();

    // Insertion of created data into loginscred table
    $sql = "INSERT INTO loginscred (email, passwords, username, cid) VALUES (:email, :password, :username, :cid)";
    $stmt = $pdo->prepare($sql);



    // Bind the parameters
    $stmt->bindParam(':cid', $IDCODENumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':username', $username);

    //Insertion of created data into customer_info
    $asql = "INSERT INTO customer_info (cuid, cid, contact_no) VALUES (:cid, :cid, :Contact)";
    $astmt = $pdo->prepare($asql);
    // Bind the parameters for customer_info
    $astmt->bindParam(':cid', $IDCODENumber);
    $astmt->bindParam(':Contact', $Contact);



    if($astmt->execute()){
        if($stmt->execute()){
            // Registration successful
            header("Location: login.php");
            exit;
        } else {
            // Registration failed
            echo "Registration failed!";
        }
    } else {
        // Registration failed
        echo "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
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
    <div class="positioning">

    </div>
    <div class="container">
        <div class="box form-box">
            <header class="login-header">Sign Up
                <ul><li><a href="index.php">X</a></li></ul>
            </header>
            <form action="" method="post">
            <div class="field input">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" autocomplete="off" required>
                </div>
            <div class="field input">
                    <label for="midlename">Middle Name</label>
                    <input type="text" name="midlename" id="midlename" autocomplete="off" required>
                </div>
            <div class="field input">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="Contact">Contact No.</label>
                    <input type="text" name="Contact" id="Contact" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="register" value="Register">
                </div>
                <div class="links">
                    Already Have Account?<a href="login.php"> Log in Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

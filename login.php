<?php
session_start();

include 'connection.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['passwords'] ?? null;

    // Debugging: Echo the submitted email and password
    echo "Submitted email: " . htmlspecialchars($email) . "<br>";
    echo "Submitted password: " . htmlspecialchars($password) . "<br>";

    // Prepare the SQL query
    $query = $pdo->prepare("SELECT * FROM loginscred WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and the password matches
    if($user && isset($user['passwords']) && $password !== null && password_verify($password, $user['passwords'])) {
        // Credentials are correct, proceed with the login process
        $_SESSION['username'] = $user['username']; // Set the session variable with the username
        header("Location: index.php");
        exit;
    } else {
        // Credentials are incorrect, display an error message
        $error_message = "Invalid email or password.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
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
    <div class="container">
        <div class="box form-box">
            <header class="login-header">Login
                <ul><li><a href="index.php">X</a></li></ul>
            </header>
            <form action="login.php" method="post">
                <div class="field input">
                    <label for="email">Email</label> <!-- Corrected label -->
                    <input type="email" name="email" id="email" required> <!-- Corrected input name -->
                </div>

                <div class="field input">
                    <label for="passwords">Password</label>
                    <input type="password" name="passwords" id="passwords" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login"> <!-- Corrected name attribute -->
                </div>
                <div class="links">
                    Don't Have Account?<a href="register.php"> Sign Up Now</a>
                </div>
            </form>
            <?php if(isset($error_message)): ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
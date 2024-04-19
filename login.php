<?php
include 'connection.php';

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['passwords'] ?? null;

    // Debugging: Echo the submitted email and password
    echo "Submitted email: " . htmlspecialchars($email) . "<br>";
    echo "Submitted password: " . htmlspecialchars($password) . "<br>";

    // Prepare the SQL query
    $sql = "SELECT * FROM loginscred WHERE email = :email";
    $stmt = $pdo->prepare($sql);

    // Bind the email parameter
    $stmt->bindParam(':email', $email);

    // Execute the query
    $stmt->execute();

    // Fetch the user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: Echo the retrieved email and hashed password
    // echo "Retrieved email: " . htmlspecialchars($user['email']) . "<br>";
    // echo "Retrieved hashed password: " . htmlspecialchars($user['passwords']) . "<br>";

    // Check if the user exists and the password matches
    if($user && isset($user['passwords']) && $password !== null && password_verify($password, $user['passwords'])) {
        // Credentials are correct, proceed with the login process
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
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
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

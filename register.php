<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header class="login-header">Sign Up
                <ul><li><a href="index.php">X</a></li></ul>
            </header>
            <form action="" method="post">
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
<?php
include("connection.php");

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $Contact = $_POST['Contact'];

    // Hash the password using the PASSWORD_DEFAULT algorithm
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion of created data
    $sql = "INSERT INTO loginscred (email, passwords, username, cid) VALUES (:email, :password, :username, :cid)";
    $stmt = $pdo->prepare($sql);

    $GenerateNumber = mt_rand(1, 99999);
    $IDCODENumber = sprintf('%05d', $GenerateNumber);

    // Bind the parameters
    $stmt->bindParam(':cid',$IDCODENumber);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':username', $username);

    // Execute the query
    if($stmt->execute()){
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Registration failed!";
    }
}
?>

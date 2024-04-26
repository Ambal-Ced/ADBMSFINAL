<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Account Deleted</h1>
    <p>Your account has been successfully deleted. You will be redirected to the login page shortly.</p>
</body>
</html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Destroy the session
    session_destroy();

    // Redirect to the index page
    header("Location: index.php");
    exit;
    ?>
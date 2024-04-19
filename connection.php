<?php
try {
    $pdo = new PDO("pgsql:host=localhost;dbname=ADBMS_WEB", "postgres", "postgres");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Ensure the script stops if the connection fails
}
?>

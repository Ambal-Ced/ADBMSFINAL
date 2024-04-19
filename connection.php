<?php
try {
    $pdo = new PDO("pgsql:host=localhost;dbname=ADBMS_WEB", "postgres", "postgres");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>

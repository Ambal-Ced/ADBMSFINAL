<?php
session_start();

include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login.php
    header("Location: login.php");
    exit;
}


$username = $_SESSION['username'];
$query = $pdo->prepare("SELECT customer_name.cid, customer_name.cfname, customer_name.cmname, customer_name.clname, loginscred.username, loginscred.email, customer_info.contact_no FROM customer_name JOIN loginscred ON customer_name.cid = loginscred.cid JOIN customer_info on customer_name.cid = customer_info.cid WHERE loginscred.username = :username");
$query->execute(['username' => $username]);
$user = $query->fetch(PDO::FETCH_ASSOC);
$_SESSION['cid'] = $user['cid'];

//check
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $cid = $_SESSION['cid'];
        $poid = $_POST['productvalues'];
        $ev_address = $_POST['adresses'];
        $reservation_date = $_POST['eventDate'];

        $poid = filter_var($poid, FILTER_VALIDATE_INT);
        if ($poid === false) {
            throw new Exception("Invalid product value.");
        }

        function randomNumberExists($pdo, $randomNumber) {
            $query = $pdo->prepare("SELECT uniqid FROM productavail WHERE uniqid = :uniqid");
            $query->execute(['uniqid' => $randomNumber]);
            return $query->rowCount() > 0;
        }

        do {
            // Generate an 8-digit random number
            $uniqid = mt_rand(10000000, 99999999);
        } while (randomNumberExists($pdo, $uniqid));

        // Insert into productavail table
        $query = $pdo->prepare("INSERT INTO productavail (cid, poid, uniqid) VALUES (:cid, :poid, :uniqid)");
        $query->execute(['cid' => $cid, 'poid' => $poid, 'uniqid' => $uniqid]);

        // Insert into eventinfo table
        $query = $pdo->prepare("INSERT INTO eventinfo (cid, ev_address, reservation_date, uniqid) VALUES (:cid, :ev_address, :reservation_date, :uniqid)");
        $query->execute(['cid' => $cid, 'ev_address' => $ev_address, 'reservation_date' => $reservation_date, 'uniqid' => $uniqid]);

        // Insert into pstatus table
        $query = $pdo->prepare("INSERT INTO pstatus (cid, status, uniqid) VALUES (:cid, :status, :uniqid)");
        $query->execute(['cid' => $cid, 'status' => 'Inprogress', 'uniqid' => $uniqid]);

        // Redirect
        header("Location: success.php");
        exit;
    } catch (Exception $e) {
        // Handle errors, e.g., by displaying an error message or redirecting to an error page
        echo "Error: " . $e->getMessage();
    }
}
?>

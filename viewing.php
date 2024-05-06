<?php
session_start();
include 'connection.php';
$user = null;
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = $pdo->prepare("SELECT customer_name.cid,customer_name.cfname, customer_name.cmname, customer_name.clname, 
    loginscred.username, loginscred.email, customer_info.contact_no FROM customer_name JOIN loginscred ON customer_name.cid = 
    loginscred.cid JOIN customer_info on customer_name.cid = customer_info.cid WHERE loginscred.username = :username");
    $query->execute(['username' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
}
$uniqid = $_GET['uniqid'];

$stmt = $pdo->prepare('SELECT DISTINCT(customer_name.cid), customer_name.cfname, customer_name.cmname, customer_name.clname,
productavail.poid, productavail.uniqid, loginscred.email, product.price, product.pinfo, customer_info.contact_no,
eventinfo.reservation_date, eventinfo.ev_address, product.package_order, pstatus.status, loginscred.username
FROM customer_name 
JOIN productavail ON customer_name.cid = productavail.cid
JOIN product ON productavail.poid = product.poid
JOIN pstatus ON productavail.uniqid  = pstatus.uniqid
JOIN eventinfo ON eventinfo.uniqid = productavail.uniqid 
JOIN loginscred ON loginscred.cid = customer_name.cid
JOIN customer_info ON customer_info.cid = customer_name.cid
WHERE pstatus.status = :fetchstat AND loginscred.username = :username AND productavail.uniqid IS NOT NULL
AND pstatus.uniqid = :uniqid');

// Correctly binding parameters
$stmt->execute([
    'username' => $username,
    'fetchstat' => 'Inprogress',
    'uniqid' => $uniqid
]);

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Receipt</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="printss.css">
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




<section class="sct">
    
    <div class="printing">
        <div class="rent">
        <div class="ret">
    <h2>Reservation Details<br><br></h2>
    <?php foreach ($result as $row):?>
        <div id="content">
            <p>Customer Name: <?= htmlspecialchars($row['cfname'])?> <?= htmlspecialchars($row['cmname'])?> <?= htmlspecialchars($row['clname'])?></p>
            <p>Username: <?= htmlspecialchars($row['username'])?></p>
            <p>Email: <?= htmlspecialchars($row['email'])?></p>
            <p>Contact no.: <?= htmlspecialchars($row['contact_no'])?></p>
            <p>Customer ID.: <?= htmlspecialchars($row['cid'])?> <br> <br></p>

            <p>Event Address: <?= htmlspecialchars($row['ev_address'])?></p>
            <p>Product: <?= htmlspecialchars($row['package_order'])?></p>
            <p>Price: Php <?= htmlspecialchars($row['price'])?></p>
            <p>Product Info: <?= htmlspecialchars($row['pinfo'])?></p>
            <p>Receipt Id: <?= htmlspecialchars($row['uniqid'])?></p>
            </div>
        </div>
        <div class="btn-con" id="print-btns">
        <button class="print-btn">Print</button>
        </div>
        </div>
    <?php endforeach;?>
    </div>
    <div class="hide">
        <p>This is the Official Receipt for Your Availed Service <br>Serve to you by Studio Ponkan Your Photography Studio</p>
    </div>
</section>
<script src="print.js"></script>
</body>
</html>
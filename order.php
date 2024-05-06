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
where pstatus.status = :fetchstat and loginscred.username = :username and productavail.uniqid is not null;');
$stmt->execute(['username' => $username, 'fetchstat' => 'Inprogress']);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reservations = []; // Initialize an empty array to hold reservation details

foreach ($products as $product) {
    $reservations[] = [
        'package_order' => $product['package_order']?? 'N/A',
        'reservation_date' => $product['reservation_date']?? 'N/A',
        'status' => $product['status']?? 'N/A',
        'uniqid' => $product['uniqid']?? 'N/A',
        'ev_address' => $product['ev_address']?? 'N/A',
        'price' => $product['price']?? 'N/A',
        'pinfo' => $product['pinfo']?? 'N/A'
    ];
}

if (isset($_POST['cancel'])) {
    $uniqid = $_POST['cancel']; // Get the uniqid from the form submission

    try {
        $pdo->beginTransaction(); // Start a transaction
        // Prepare the statement
        $stmt = $pdo->prepare("UPDATE pstatus SET status = 'Cancelled' WHERE uniqid = :uniqid");
        // Bind the parameter
        $stmt->bindValue(':uniqid', $uniqid, PDO::PARAM_STR); // Adjust the parameter type as needed
        // Execute the statement
        $stmt->execute();
        $pdo->commit(); // Commit the transaction
        echo '<script>alert("Cancelled successfully");</script>';
        echo '<script>window.location.href = "order.php";</script>'; // Redirect to a success page or refresh the current page
    } catch (PDOException $e) {
        $pdo->rollBack(); // Rollback the transaction in case of error
        echo 'Error: '. $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
<section class="printable">
    <div class="apen">
    <div class="pom">
    <h2>Reservation Details: <br> <br></h2>
    <?php if (empty($reservations)):?>
        <p>You haven't booked anything. <a href="booking.php">Book now!</a></p>
    <?php else:?>
        <form method="post" action="">
            <?php foreach ($reservations as $reservation):?>
                <p>Reservation: <?= $reservation['package_order']?> Php <?= $reservation['price']?> <?= $reservation['pinfo']?><br>
                Event Address: <?= $reservation['ev_address']?> <br>
                Date: <?= $reservation['reservation_date']?> <br>
                Status: <?= $reservation['status']?> 
                <br>Receipt ID: <?= $reservation['uniqid']?> <br> 
                <button onclick="window.location.href='viewing.php?uniqid=<?= urlencode($reservation['uniqid'])?>';" class="view-btn" data-uniqid="<?= $reservation['uniqid']?>">View</button>
                <button class="cancel-btn" type="submit" name="cancel" value="<?= $reservation['uniqid']?>">Cancel</button><br> <br>
            </p>
            <?php endforeach;?>
        </form>
    <?php endif;?>
</div>
    </div>
    <div id="success-message" style="display:none; color:green;">Cancelled Successfully</div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var viewButtons = document.querySelectorAll('.view-btn');
    viewButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button behavior
            var uniqid = this.getAttribute('data-uniqid'); // Get the uniqid from the data-attribute
            console.log('Redirecting with uniqid:', uniqid); // Debugging line
            window.location.href = 'viewing.php?uniqid=' + encodeURIComponent(uniqid); // Append the uniqid to the URL
        });
    });
});
</script>
<script src="script.js"></script>
</body>
</html>
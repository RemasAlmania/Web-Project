<?php
session_start();
require_once "../database/config.php";

// Check if the admin is logged in
// I added this to prevent unauthorized access
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Fetch all bookings joined with user info and event info
// This gives the admin a full view of every booking
$query = "
SELECT 
    bookings.*, 
    users.name AS customer_name, 
    users.email AS customer_email,
    events.name AS event_name,
    events.date_time AS event_date
FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN events ON bookings.event_id = events.id
ORDER BY bookings.booking_date DESC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Bookings</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="container">

    <!-- Include the admin sidebar (shared across all admin pages) -->
    <?php include 'admin_sidebar.php'; ?>

    <!-- Main content section -->
    <div class="main-section">
        <h2>All Bookings</h2>

        <table border="1" class="table-bookings">
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Booking Date</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Tickets</th>
                <th>Total Price</th>
            </tr>

            <!-- Loop through all booking records and display them -->
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['customer_name'] ?></td>
                <td><?= $row['customer_email'] ?></td>
                <td><?= $row['booking_date'] ?></td>
                <td><?= $row['event_name'] ?></td>
                <td><?= $row['event_date'] ?></td>
                <td><?= $row['qty'] ?></td>
                <td><?= $row['total_price'] ?> SAR</td>
            </tr>
            <?php endwhile; ?>
        </table>

    </div>

</div>

</body>
</html>

<?php
session_start();
include("../database/config.php");

if(!isset($_SESSION['admin'])){
    header("Location: admin.php");
    exit();
}

if(!isset($_GET['id'])){
    echo "Invalid Event ID";
    exit();
}

$event_id = $_GET['id'];

// To retrieve the event information
$query = "SELECT * FROM events WHERE id=$event_id";
$result = mysqli_query($conn, $query);
$event = mysqli_fetch_assoc($result);

// Making sure The event was not booked 
$checkBookings = mysqli_query($conn, "SELECT * FROM bookings WHERE event_id=$event_id");

$hasBookings = mysqli_num_rows($checkBookings) > 0;

// upon Booking confirmation
if(isset($_POST['confirm_delete'])){

    if($hasBookings){
        echo "<p style='color:red;'>Cannot delete this event because it has bookings!</p>";
    } else {

        mysqli_query($conn, "DELETE FROM events WHERE id=$event_id");

        header("Location: manageEvents.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php include("sidebar.php"); ?>

<div class="main-content">
    <h2>Delete Event</h2>

    <p><strong>Event Name:</strong> <?php echo $event['name']; ?></p>
    <p><strong>Date:</strong> <?php echo $event['date_time']; ?></p>
    <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
    <p><strong>Price:</strong> <?php echo $event['price']; ?></p>

    <?php if($hasBookings): ?>
        <p style="color:red;">⚠ Cannot delete this event because it already has bookings!</p>

    <?php else: ?>
        <form method="POST">
            <button type="submit" name="confirm_delete" style="background:red;">Yes, Delete this Event</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

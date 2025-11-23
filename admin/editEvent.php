<?php
session_start();
include("../database/config.php");

// Make sure that the admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin.php");
    exit();
}

// event ID 
if(!isset($_GET['id'])){
    echo "Invalid Event ID";
    exit();
}

$event_id = $_GET['id'];

// Retrieve the event information
$query = "SELECT * FROM events WHERE id = $event_id";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0){
    echo "Event not found";
    exit();
}

$event = mysqli_fetch_assoc($result);

// Update Event
if(isset($_POST['update'])){
    
    $name       = $_POST['name'];
    $date_time  = $_POST['date_time'];
    $location   = $_POST['location'];
    $price      = $_POST['price'];
    $max_tickets = $_POST['max_tickets'];

    //  Updating the information
    $update = "UPDATE events 
               SET name='$name',
                   date_time='$date_time',
                   location='$location',
                   price='$price',
                   max_tickets='$max_tickets'
               WHERE id=$event_id";

    mysqli_query($conn, $update);

    // After updating, it will be back to the manage event page
    header("Location: manageEvents.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<?php include("sidebar.php"); ?>  

<div class="main-content">
    <h2>Edit Event</h2>

    <form method="POST">

        <label>Event Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>

        <label>Date & Time:</label>
        <input type="datetime-local" name="date_time" value="<?php echo date('Y-m-d\TH:i', strtotime($event['date_time'])); ?>" required>

        <label>Location:</label>
        <input type="text" name="location" value="<?php echo $event['location']; ?>" required>

        <label>Price:</label>
        <input type="number" name="price" value="<?php echo $event['price']; ?>" required>

        <label>Maximum Tickets:</label>
        <input type="number" name="max_tickets" value="<?php echo $event['max_tickets']; ?>" required>

        <button type="submit" name="update">Update Event</button>

    </form>
</div>

</body>
</html>

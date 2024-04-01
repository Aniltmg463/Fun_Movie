<?php
//session_start(); // Start the session
// Include your database connection file (connect.php)
include('connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='login.php';  </script>";
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>

<?php
// Initialize variables
$title = $description = $releasedate = $image = $rating = $catid = $date = $timing = $theater_name = '';

// Check if theater ID is provided
if (isset($_POST['theater_id'])) {
    $theater_id = $_POST['theater_id'];
    
    // Retrieve movie and theater details based on theater ID
    $sql = "SELECT movies.*, theater.date, theater.timing, theater.theater_name, theater.location, theater.price FROM movies INNER JOIN theater ON movies.movieid = theater.movieid WHERE theater.theaterid = ?";
    $stmt = $con->prepare($sql); // Use $con instead of $conn
    $stmt->bind_param("i", $theater_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $releasedate = $row['releasedate'];
        $image = $row['image'];
        $rating = $row['rating'];
        $catid = $row['catid'];
        $date = $row['date'];
        $timing = $row['timing'];
        $theater_name = $row['theater_name']; 
        $location = $row['location'];
        $price = $row['price'];

    } else {
        echo "No movie found for this theater.";
        exit;
    }
} else {
    echo "Theater ID not provided.";
    exit;
}
?>

<div class='booking-container'>
    <img src='admin/uploads/<?php echo $image; ?>' alt='Movie Poster' class='booking-image'>
    <div class='movie-details'>
        <h1><?php echo $title; ?></h1>
        <p><span>Description:</span> <?php echo $description; ?></p>
        <p><span>Release Date:</span> <?php echo $releasedate; ?></p>
        <p><span>Show Time:</span> <?php echo $timing; ?></p>
        <p><span>Theater Name:</span> <?php echo $theater_name; ?></p>
        <p><span>Location:</span> <?php echo $location; ?></p>
        <p><span>Price:</span> <?php echo $price; ?></p>
    </div>
</div>


<div class='booking-form'>
    <h2>Select Date and Time</h2>
    <form action='seats.php' method='post'>
        <label for='selected_date'>Select Date:</label><br>
        <select name='selected_date' class='booking-date'>
            <option value='<?php echo $date; ?>'><?php echo $date; ?></option>
        </select>

        Show:
        <select name='selected_show_time' class='booking-show'>
            <option value='<?php echo $timing; ?>'><?php echo $timing; ?></option>
        </select>

        <input type='hidden' name='movie_id' value='<?php echo $row['movieid']; ?>'>
        <input type='hidden' name='theater_id' value='<?php echo $theater_id; ?>'>
        <br>

        <input type='submit' name='bookSeats' value='Book Seats' class='booking-button'>
    </form>
</div>

</body>
</html>

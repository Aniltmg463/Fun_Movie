<?php

// Include your database connection file (connect.php)
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='login.php';  </script>";
    exit; // Stop further execution
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate data
    $selected_date = $_POST['selected_date'];
    $selected_show_time = $_POST['selected_show_time'];
    $movie_id = $_POST['movie_id'];
    $seats = $_POST['seats'];
    
    // Check if seats are selected
    if (!empty($seats)) {
        // Prepare and bind parameters for insertion
        $sql = "INSERT INTO booking (movie_id, show_date, show_time, seat_num, total_price, booking_date, booking_time, user_id, paid, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("isiiissssss", $movie_id, $selected_date, $selected_show_time, $seat_num, $total_price, $booking_date, $booking_time, $user_id, $paid, $image_path, $status);
        
        // Set parameters and execute the statement for each selected seat
        foreach ($seats as $seat_num) {
            $user_id = $_SESSION['uid']; // Get user ID from session
            $booking_date = date("Y-m-d"); // Get current date
            $booking_time = date("H:i:s"); // Get current time
            $total_price = 0; // Set total price
            $paid = ''; // Set paid status
            $image_path = ''; // Set image path
            $status = 'Pending'; // Set status
            
            // Execute the prepared statement
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Redirect to booking success page
        header("Location: booking_success.php");
        exit;
    } else {
        echo "Please select at least one seat.";
    }
} else {
    echo "Invalid request.";
}
?>

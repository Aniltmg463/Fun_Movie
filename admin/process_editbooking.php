<?php
include('../connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['uid'])) {
    // Redirect to the login page
    header("Location: ../login.php");
    exit(); // Stop executing further code
}

if (isset($_POST['btnedit'])) {
    // Get the data from the form
    $editBookingId = $_POST['editbookingid'];
    $bookingdate = $_POST['bookingdate'];
    $person = $_POST['person'];
    $userid = $_POST['userid'];
    $seat = $_POST['seat'];
    $status = $_POST['status'];

    // Perform the update in the database
    $updateSql = "UPDATE `booking` SET `bookingdate` = '$bookingdate', `person` = '$person', `userid` = '$userid', `seat` = '$seat', `status` = '$status' WHERE `bookingid` = '$editBookingId'";

    if (mysqli_query($con, $updateSql)) {
        // Booking updated successfully
        echo "<script>alert('Booking updated successfully!');</script>";
        echo "<script>window.location.href='viewallbooking.php';</script>";
    } else {
        // Failed to update booking
        echo "<script>alert('Failed to update booking. Please try again.');</script>";
        echo "<script>window.location.href='viewallbooking.php';</script>";
    }
} else {
    // If the form is not submitted properly, redirect to the viewallbooking.php page
    header("Location: viewallbooking.php");
    exit();
}
?>

<?php
include('connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='login.php';  </script>";
    exit; // Stop further execution
}

if (isset($_POST['ticketbook'])) {
    $person = $_POST['person'];
    $date = $_POST['date'];
    $theaterid = $_POST['theaterid'];
    $seat = $_POST['seat'];

    $uid = $_SESSION['uid'];

    // Ensure $con is defined (from your connect.php file)
    if (!isset($con)) {
        echo "<script> alert('Database connection error'); </script>";
        exit; // Stop further execution
    }

    // Escape user inputs for security
    $person = mysqli_real_escape_string($con, $person);
    $date = mysqli_real_escape_string($con, $date);
    $theaterid = mysqli_real_escape_string($con, $theaterid);
    $seat = mysqli_real_escape_string($con, $seat);
    $uid = mysqli_real_escape_string($con, $uid);

    $sql = "INSERT INTO `booking` (`theaterid`, `bookingdate`, `person`, `seat`, `userid`) VALUES ('$theaterid', '$date', '$person', '$seat', '$uid')";

    if (mysqli_query($con, $sql)) {
        echo "<script> alert('Ticket booked successfully!!') </script>";
        echo "<script> window.location.href='index.php';  </script>";
    } else {
        echo "<script> alert('Ticket not booked'); </script>";
    }
}
?>

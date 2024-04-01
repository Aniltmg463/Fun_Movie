<?php
include('../connect.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the SQL query to delete the image record
    $query = "DELETE FROM tb_upload WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    
    if($result) {
        // Image deleted successfully
        echo "<script>alert('Image deleted successfully');</script>";
        echo "<script>window.location.href='classes.php';</script>"; // Redirect to your page
        exit();
    } else {
        // Error occurred while deleting the image
        echo "<script>alert('Error deleting image');</script>";
        echo "<script>window.location.href='classes.php';</script>"; // Redirect to your page
        exit();
    }
} else {
    // No image ID provided
    echo "<script>alert('No image ID provided');</script>";
    echo "<script>window.location.href='classes.php';</script>"; // Redirect to your page
    exit();
}
?>

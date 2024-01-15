<?php 
include('../connect.php');

if(!isset($_SESSION['uid'])){
    echo "<script> window.location.href='../login.php';  </script>";
}

// Check if the logged-in user has admin privileges
if(isset($_SESSION['role_type']) && $_SESSION['role_type'] != 1){
    echo "<script> alert('You do not have permission to access this page')</script>";
    echo "<script> window.location.href='viewallusers.php' </script>";
}

if(isset($_GET['userid'])){
    $userid = $_GET['userid'];

    $select_sql = "SELECT * FROM `users` WHERE `userid`='$userid'";
    $result = mysqli_query($con, $select_sql);

    if(mysqli_num_rows($result) > 0){
        $user_data = mysqli_fetch_array($result);
    } else {
        echo "<script> alert('User not found')</script>";
        echo "<script> window.location.href='viewallusers.php' </script>";
    }
} else {
    echo "<script> window.location.href='viewallusers.php' </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<?php include('header.php') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form action="edituser.php" method="post">
                <input type="hidden" name="userid" value="<?= $user_data['userid'] ?>">
                <div class="form-group mb-4">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= $user_data['name'] ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?= $user_data['email'] ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" value="<?= $user_data['password'] ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label for="roteype">Role Type:</label>
                    <select name="roteype" class="form-control" required>
                        <option value="1" <?= ($user_data['roteype'] == 1) ? 'selected' : '' ?>>ADMIN</option>
                        <option value="2" <?= ($user_data['roteype'] == 2) ? 'selected' : '' ?>>USER</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update User" name="update">
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

</body>
</html>

<?php
if(isset($_POST['update'])){
    $userid = mysqli_real_escape_string($con, $_POST['userid']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $roteype = mysqli_real_escape_string($con, $_POST['roteype']);

    $update_sql = "UPDATE `users` SET `name`='$name', `email`='$email', `password`='$password', `roteype`='$roteype' WHERE `userid`='$userid'";

    if(mysqli_query($con, $update_sql)){
        echo "<script> alert('User updated successfully')</script>";
        echo "<script> window.location.href='viewallusers.php' </script>";
    } else {
        echo "<script> alert('User not updated')</script>";
    }
}
?>

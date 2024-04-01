<?php
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION['uid'])) {
    echo "<script> window.location.href='login.php'; </script>";
    exit; // Stop executing further code
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Booking</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include('header.php') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Theater</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Seat</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                // Get the user ID from the session
                $uid = $_SESSION['uid'];

                // SQL query to fetch booking details
                $sql = "SELECT booking.bookingid, theater.theater_name, movies.title, categories.catname, booking.show_date, booking.show_time, theater.price, booking.seat_num,theater.location, booking.status
                        FROM booking
                        INNER JOIN theater ON theater.movieid = booking.movie_id
                        INNER JOIN users ON users.userid = booking.user_id
                        INNER JOIN movies ON movies.movieid = booking.movie_id
                        INNER JOIN categories ON categories.catid = movies.catid 
                        WHERE booking.user_id = '$uid'";

                // Execute the SQL query
                $res = mysqli_query($con, $sql);

                // Check if there are rows returned
                if (mysqli_num_rows($res) > 0) {
                    while ($data = mysqli_fetch_array($res)) {
                        ?>
                        <tr>
                            <td><?= $data['bookingid'] ?></td>
                            <td><?= $data['theater_name'] ?></td>
                            <td><?= $data['title'] ?></td>
                            <td><?= $data['catname'] ?></td>
                            <td><?= $data['show_date'] ?></td>
                            <td><?= $data['show_time'] ?></td>
                            <td><?= $data['price'] ?></td>
                            <td><?= $data['seat_num'] ?></td>
                            <td><?= $data['location'] ?></td>
                            <td>
                                <?php
                                // Check status and apply appropriate badge
                                if ($data['status'] == 'Pending') {
                                    echo "<span class='badge badge-warning'>Pending</span>";
                                } else {
                                    echo "<span class='badge badge-success'>Approved</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($data['status'] == 'Approved'): ?>
                                    <a href='approve_booking.php?bookingid=<?= $data['bookingid'] ?>' class='btn btn-primary'>Download Bill</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    // If no bookings found, display a message
                    echo '<tr><td colspan="10">No booking found</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php') ?>

</body>
</html>

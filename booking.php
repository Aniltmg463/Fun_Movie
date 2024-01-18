<?php
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking</title>

     <!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

    <style>
    /* Your existing styles */
    .seat {
        width: 30px;
        height: 30px;
        margin: 5px;
        cursor: pointer;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seat.selected {
        background-color: #5cb85c; /* Green for selected seats */
        color: #fff;
    }

    .seat-chart-row {
        margin-bottom: 10px;
        display: flex;
        justify-content: center; /* Center the seats horizontally in the row */
    }

    .btn-primary {
        margin-top: 10px;
        background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
    }
    .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        form {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        form label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px 20px 10px 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        select.form-control {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }
</style>

</head>

<body>

    <?php
    $theaterid = $_GET['id'];
    ?>

    <section id="team" class="team section-bg">
        <!--div class="container aos-init aos-animate" data-aos="fade-up" -->
        <div class="container aos-init aos-animate border border-dark rounded p-4" data-aos="fade-up">

            <div class="section-title">
                <h2>Ticket Booking for Theater</h2>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-3 col-md-6 d-flex align-items-stretch aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <form action="booking_process.php" method="post">
                        <div class="row">

                            <input type="hidden" name="theaterid" value="<?= $theaterid ?>">

                            <div class="col form-group mb-3">
                                <input type="text" class="form-control" name="person" placeholder="Enter no of People" required="">
                            </div>

                            <div class="col form-group mb-3">
                                <input type="date" class="form-control" name="date" required="">
                            </div>

                            <!-- Seat Selection Dropdown -->
                            <div class="col form-group mb-3">
                                <label for="seat">Select Seat:</label>
                                <select class="form-control" name="seat" id="seat" required="">
                                    <!-- Seat options will be dynamically added using JavaScript -->
                                </select>
                            </div>

                        </div>

                        <div id="seatChart" class="text-center">
                            <!-- Seat chart will be dynamically added using JavaScript -->
                        </div>

                        <div class="text-center"><button type="submit" class="btn btn-primary" name="ticketbook">Ticket Book</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section>

    <script>
        // Add your JavaScript code for dynamically generating seat options and chart
        document.addEventListener("DOMContentLoaded", function () {
            var seatDropdown = document.getElementById("seat");
            var seatChartContainer = document.getElementById("seatChart");

            // Assuming 35 people for the example
            var totalSeats = 35;
            var seatOptions = generateSeatOptions(totalSeats);

            // Populate seat dropdown
            seatOptions.forEach(function (seat) {
                var option = document.createElement("option");
                option.value = seat;
                option.text = seat;
                seatDropdown.add(option);
            });

            // Generate seat chart
            var seatsPerRow = 5; // You can adjust this based on your layout
            var currentRow = document.createElement("div");
            currentRow.classList.add("seat-chart-row");

            seatOptions.forEach(function (seat, index) {
                var seatElement = document.createElement("div");
                seatElement.classList.add("seat");
                seatElement.innerText = seat;
                seatElement.addEventListener("click", function () {
                    // Update selected seat in the dropdown
                    seatDropdown.value = seat;
                    // Toggle selected class for styling
                    seatElement.classList.toggle("selected");
                });

                currentRow.appendChild(seatElement);

                // Start a new row after a certain number of seats
                if ((index + 1) % seatsPerRow === 0 || index === seatOptions.length - 1) {
                    seatChartContainer.appendChild(currentRow);
                    currentRow = document.createElement("div");
                    currentRow.classList.add("seat-chart-row");
                }
            });

            function generateSeatOptions(totalSeats) {
                var seatOptions = [];
                for (var i = 1; i <= totalSeats; i++) {
                    seatOptions.push("Seat " + i);
                }
                return seatOptions;
            }
        });
    </script>

    <?php

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

    // Check if the seat is available
    $seatAvailabilitySql = "SELECT * FROM `booking` WHERE `theaterid`='$theaterid' AND `bookingdate`='$date' AND `seat`='$seat'";
    $seatAvailabilityResult = mysqli_query($con, $seatAvailabilitySql);

    if (mysqli_num_rows($seatAvailabilityResult) > 0) {
        echo "<script> alert('Seat already booked. Please choose another seat.'); </script>";
    } else {
        // Book the seat
        $sql = "INSERT INTO `booking`(`theaterid`, `bookingdate`, `person`, `seat`, `userid`) VALUES ('$theaterid','$date','$person','$seat','$uid')";

        if (mysqli_query($con, $sql)) {
            echo "<script> alert('Ticket booked successfully!!') </script>";
            echo "<script> window.location.href='index.php';  </script>";
        } else {
            echo "<script> alert('Ticket not booked'); </script>";
        }
    }
}
?>

</body>

</html>

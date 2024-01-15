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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Booking</title>

    <!-- Include your existing head content here -->

    <style>
        /* Your existing styles */
        .seat {
            width: 30px;
            height: 30px;
            margin: 5px;
            cursor: pointer;
            border: 1px solid #ccc;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .seat.selected {
            background-color: #5cb85c; /* Green for selected seats */
            color: #fff;
        }

        .seat-chart-row {
            margin-bottom: 10px;
        }

        .btn-primary {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php
    $theaterid = $_GET['id'];
    ?>

    <section id="team" class="team section-bg">
        <div class="container aos-init aos-animate" data-aos="fade-up">

            <div class="section-title">
                <h2>Ticket Booking for Theater</h2>
            </div>

            <div class="row">

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

        //print_r($_POST);

        $sql = "INSERT INTO `booking`(`theaterid`, `bookingdate`, `person`, `seat`, `userid`) VALUES ('$theaterid','$date','$person','$seat','$uid')";

        if (mysqli_query($con, $sql)) {
            echo "<script> alert('Ticket booked successfully!!') </script>";
            echo "<script> window.location.href='index.php';  </script>";
        } else {
            echo "<script> alert('Ticket not booked'); </script>";
        }
    }

    ?>

</body>

</html>

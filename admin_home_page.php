<?php
include 'connect.php';
session_start();
$email = $_SESSION['usera'];
$sql = "select * from `admin` where email='$email'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['Name'];
} else {
    die(mysqli_error($conn));
}
?>
<html>

<head>
    <title>

    </title>
    <style>
        input {
            border: 1.5px solid #030337;
            border-radius: 4px;
            padding: 7px 30px;
        }

        input[type=submit] {
            background-color: #030337;
            color: white;
            border-radius: 4px;
            padding: 7px 45px;
            margin: 0px 135px
        }
    </style>
    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <img class="logo" src="photo.png" />
    <h1 id="title">
        CENATION AIRLINES
    </h1>

    <div>
        <ul>
            <li><a href="admin_home_page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li><a href="login_page.php"><i class="fa fa-ticket" aria-hidden="true"></i> Book Tickets</a></li>
            <li><a href="admin_home_page.php"><i class="fa fa-plane" aria-hidden="true"></i> About Us</a></li>
            <li><a href="admin_home_page.php"><i class="fa fa-phone" aria-hidden="true"></i> Contact Us</a></li>
            <li><a href="logout_page.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a></li>
        </ul>
    </div>
    <h2>Hello <?php echo $name ?></h2>

    <table cellpadding="5">

        <tr>
            <td class="admin_func"><a href="view_booked_tickets.php"><i class="fa fa-plane" aria-hidden="true"></i> View List of Booked Tickets for a Flight</a>
            </td>
        </tr>

        <tr>
            <td class="admin_func"><a href="addflight.php"><i class="fa fa-plane" aria-hidden="true"></i> Add Flight Schedule Details</a>
            </td>
        </tr>

        <tr>
            <td class="admin_func"><a href="delete_flight.php"><i class="fa fa-plane" aria-hidden="true"></i> Delete Flight Schedule Details</a>
            </td>
        </tr>
    </table>
	<div class="salesChartContainer">
	<canvas id="salesChartCanvas" ></canvas>
    </div>

    <?php
    // SQL query to fetch monthly sales data
    $sales_query = "SELECT MONTH(payment_date) AS month, SUM(payment_amount) AS total_sales FROM payment_details GROUP BY MONTH(payment_date)";
    $sales_result = mysqli_query($conn, $sales_query);

    // Initialize arrays to store month names and sales data
    $months = [];
    $sales = [];

    // Fetching data from the result set
    while ($row = mysqli_fetch_assoc($sales_result)) {
        $months[] = date("M", mktime(0, 0, 0, $row['month'], 1));
        $sales[] = $row['total_sales'];
    }
    ?>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script to generate bar graph -->
    <script>
			Chart.defaults.scale.ticks.fontSize = 16; // Increase font size
		Chart.defaults.scale.ticks.fontColor = 'rgba(3, 3, 55, 1)'; // Adjust font color
		Chart.defaults.scale.ticks.fontWeight = 'bold';
        var ctx = document.getElementById('salesChartCanvas').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Sales',
                    data: <?php echo json_encode($sales); ?>,
                    backgroundColor: 'rgba(3, 3, 55, 0.6)', // Adjust color as needed
                    borderColor: 'rgba(3, 3, 55, 1)', // Adjust color as needed
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
							
							}
                    }]
                }
            }
			
        });
    </script>



</body>

</html>

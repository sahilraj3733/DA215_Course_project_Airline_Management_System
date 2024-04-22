<?php
include 'connect.php';
    session_start();

    if(isset($_POST['flight_no']) && isset($_POST['departure_date'])) {
       $fno= $_SESSION['flight_no'] = $_POST['flight_no'];
      $sdate=  $_SESSION['departure_date'] = $_POST['departure_date'];
    }
    $fno= $_SESSION['flight_no'];
    $sdate=  $_SESSION['departure_date'];
$sql="SELECT * from `flight`where Fno= '$fno' and sdate='$sdate'";
$result= mysqli_query($conn,$sql);
if($result){
    $row = mysqli_fetch_assoc($result);
    $seatava = $row['seatava']; 
    $total = $row['total_seats'];

}

?>

<html>
<head>
    <title>View Booked Tickets</title>
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
            margin: 0px 390px;
        }
        table {
            border-collapse: collapse;
        }
        tr/*:nth-child(3)*/ {
            border: solid thin;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="style.css"/>
    
</head>
<body>
<img class="logo" src="photo.png"/>
<h1 id="title">CENATION AIRLINES</h1>
<div>
    <ul>
        <li><a href="admin_home_page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        <li><a href="admin_home_page.php"><i class="fa fa-desktop" aria-hidden="true"></i> Dashboard</a></li>
        <li><a href="logout_page.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
    </ul>
</div>




<?php
if($seatava<0){
    
    $seat=$seatava*-1;
    echo "<h2> Total Ticket:    $total ____  Unbooked Tickets : $seat WAITING </h2>";
}

else{
    echo "<h2> Total Ticket:    $total ____  Unbooked Tickets : $seatava </h2>";
}
   echo "<h2>LIST OF BOOKED TICKETS FOR THE FLIGHT</h2>";

    // Database connection
    require_once('connect.php');



    if (isset($_POST['update_status'])) {
        require_once('connect.php'); // Include your database connection file
        
        for ($i = 0; $i < count($_POST['pnr']); $i++) {
            $pnr = $_POST['pnr'][$i];
            $booking_status = $_POST['booking_status'][$i];
    
            // Fetch existing booking status for comparison
            $query = "SELECT booking_status FROM Ticket_Details WHERE pnr = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $pnr);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $existing_status);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
    
            // Check if the booking status has changed
            if (!empty($booking_status) && $existing_status != $booking_status) {
                // Update booking status
                $update_query = "UPDATE Ticket_Details SET booking_status = ? WHERE pnr = ?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, "ss", $booking_status, $pnr);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
    
                // Fetch flight details for updating remaining tickets
                $flight_query = "SELECT flight_no, no_of_passengers FROM Ticket_Details WHERE pnr = ?";
                $flight_stmt = mysqli_prepare($conn, $flight_query);
                mysqli_stmt_bind_param($flight_stmt, "s", $pnr);
                mysqli_stmt_execute($flight_stmt);
                mysqli_stmt_bind_result($flight_stmt, $flight_no, $no_of_passengers);
                mysqli_stmt_fetch($flight_stmt);
                mysqli_stmt_close($flight_stmt);
    
                // Update remaining tickets for the flight
                $update_flight_query = ($booking_status == 'CONFIRMED') ?
                    "UPDATE flight SET seatava = seatava - ? WHERE fno = ?" :
                    "UPDATE flight SET seatava = seatava + ? WHERE fno = ?";
                $update_flight_stmt = mysqli_prepare($conn, $update_flight_query);
                mysqli_stmt_bind_param($update_flight_stmt, "is", $no_of_passengers, $flight_no);
                mysqli_stmt_execute($update_flight_stmt);
                mysqli_stmt_close($update_flight_stmt);
            }
        }
    
        // Redirect back to the previous page after updating
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }

   



if(1) {
    $data_missing=array();
    if(empty($_SESSION['flight_no'])) {
        $data_missing[]='Flight No.';
    } else {
        $flight_no=trim($_SESSION['flight_no']);
    }
    if(empty($_SESSION['departure_date'])) {
        $data_missing[]='Departure Date';
    } else {
        $departure_date=$_SESSION['departure_date'];
    }

    if(empty($data_missing)) {
        require_once('connect.php');
        $query="SELECT pnr,date_of_reservation,booking_status,no_of_passengers,payment_id,customer_id FROM Ticket_Details where flight_no=? and journey_date=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,"ss",$flight_no,$departure_date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$pnr,$date_of_reservation,$booking_status,$no_of_passengers,$payment_id,$customer_id);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt)==0) {
            echo "<h3>No booked tickets information is available!</h3>";
        } else {
            echo "<form method='post' action=''>";
            echo "<table cellpadding=\"10\"";
            echo "<tr><th>PNR</th>
            <th>Date of Reservation</th>
            <th>No. of Passengers</th>
            <th>Payment ID</th>
            <th>Customer ID</th>
            <th>Booking Status</th>
            <th>Update Status</th>
            </tr>";
            while(mysqli_stmt_fetch($stmt)) {
                echo "<tr>
                <td>".$pnr."</td>
                <td>".$date_of_reservation."</td>
                <td>".$no_of_passengers."</td>
                <td>".$payment_id."</td>
                <td>".$customer_id."</td>
                <td>".$booking_status."</td>
                <td>
                    <select name='booking_status[]'>
                    <option value='' selected>Select Option</option> <!-- Default option -->
                    <option value='CONFIRMED'>Confirmed</option>
                    <option value='CANCELLED'>Cancelled</option>
                    <option value='PENDING'>Pending</option>
                    </select>
                    <input type='hidden' name='pnr[]' value='".$pnr."'> <!-- Changed to pnr[] to accept multiple values -->
                    <input type='hidden' name='no_of_pass[]' value='".$no_of_passengers."'>
                </td>
                </tr>";
            }
            echo "</table> <br>";
            echo "<input type='submit' name='update_status'>";
            echo "</form>";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "The following data fields were empty! <br>";
        foreach($data_missing as $missing) {
            echo $missing ."<br>";
        }
    }
} else {
    echo "Submit request not received";
}
?>
</body>
</html>

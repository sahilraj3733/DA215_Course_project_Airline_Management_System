<?php
include 'connect.php';
 session_start();
 $email=$_SESSION['userp'];
 $pnr=$_SESSION['pnr'];
 $Fnumber=$_SESSION['fno'];
 
$sql="select * from `admin` where email='$email'";
$result=mysqli_query($conn,$sql);
if($result){
$row=mysqli_fetch_assoc($result);
$name=$row['Name'];
}
else{
    die(mysqli_error($conn));
}
$sql="SELECT no_of_passengers from `ticket_details` where pnr = $pnr";
$result=mysqli_query($conn,$sql);
if($result){
    $row=mysqli_fetch_assoc($result);
    $num=$row['no_of_passengers'];
    }
    else{
        die(mysqli_error($conn));
    }


// Delete records from the `passengers` table
$sql_passengers = "DELETE FROM passengers WHERE pnr = $pnr";
$result_passengers = mysqli_query($conn, $sql_passengers);

// Delete records from the `ticket_details` table
$sql_ticket_details = "DELETE FROM ticket_details WHERE pnr = $pnr";
$result_ticket_details = mysqli_query($conn, $sql_ticket_details);

// Check if both deletion queries were successful
if ($result_passengers && $result_ticket_details) {
    echo "Tickets cancel Succfully .";
} else {
    echo "Error deleting records.";
}


$query_update_flight = "UPDATE flight SET seatava = seatava + $num WHERE Fno ='$Fnumber'";
$result = mysqli_query($conn, $query_update_flight);
?>
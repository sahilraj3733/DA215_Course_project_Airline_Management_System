<?php
	session_start();
	        $i=1;
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$pnr=rand(1000000,9999999);
				$date_of_res=date("Y-m-d");
				$flight_no=$_SESSION['flight_no'];
				$journey_date=$_SESSION['journey_date'];
				$no_of_pass=$_SESSION['no_of_pass'];
				$sql="SELECT seatava from`flight` where Fno=$flight_no";
				include_once('connect.php');
				$result=mysqli_query($conn,$sql);
				if($result){
					$row=mysqli_fetch_assoc($result);
					$seatava=$row['seatava'];
					if($no_of_pass<=$seatava){
						$booking_status="CONFIRMED";
					}
					else{
						$booking_status="PENDING";
					}
				}
			
				
				
			
			
				$_SESSION['pnr']=$pnr;

			

				$payment_id=rand(100000000,999999999);
				$_SESSION['payment_id']=$payment_id;
				$customer_id=$_SESSION['userp'];
				include 'connect.php';

				
					$query="SELECT price FROM flight where Fno=? and sdate=?";
					$stmt=mysqli_prepare($conn,$query);
					mysqli_stmt_bind_param($stmt,"ss",$flight_no,$journey_date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt,$ticket_price);
					mysqli_stmt_fetch($stmt);
				
				
					
				mysqli_stmt_close($stmt);
				$ff_mileage=$ticket_price/10;

				$query="INSERT INTO `Ticket_Details` (pnr,date_of_reservation,flight_no,journey_date,booking_status,no_of_passengers,payment_id,customer_id) VALUES (?,?,?,?,?,?,?,?)";
				$stmt=mysqli_prepare($conn,$query);
				mysqli_stmt_bind_param($stmt,"sssssiss",$pnr,$date_of_res,$flight_no,$journey_date,$booking_status,$no_of_pass,$payment_id,$customer_id);
				mysqli_stmt_execute($stmt);
				$affected_rows=mysqli_stmt_affected_rows($stmt);
				// echo $affected_rows.'<br>';
				
				if($affected_rows==1)
				{
					 "Successfully Submitted<br>";
				}
				else
				{
					echo "Submit Error";
					echo mysqli_error();
				}
				
				for ($i = 1; $i <= $no_of_pass; $i++) {
				// Extract passenger details from the POST array
				$pass_name = $_POST['pass_name'][$i-1];
				$pass_age = $_POST['pass_age'][$i-1];
				$pass_gender = $_POST['pass_gender'][$i-1];
				
				 
				$seat_number = $seatava-1; 
				
				// Prepare and execute the INSERT statement to insert passenger details along with the seat number
				$query = "INSERT INTO `Passengers` (passenger_id, pnr, name, age, gender, seatno) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = mysqli_prepare($conn, $query);
				
				// Check for errors in preparing the statement
				if (!$stmt) {
					echo "Error: " . mysqli_error($conn);
				}
				
				// Bind parameters
				mysqli_stmt_bind_param($stmt, "issisi", $i, $pnr, $pass_name, $pass_age, $pass_gender, $seat_number);
				
				// Execute statement
				mysqli_stmt_execute($stmt);
				
				// Check for errors in execution
				if (mysqli_stmt_errno($stmt)) {
					echo "Error: " . mysqli_stmt_error($stmt);
				}
				
				// Get affected rows
				$affected_rows = mysqli_stmt_affected_rows($stmt);
				// echo 'Passenger added ' . $affected_rows . '<br>';
				
				// Close statement
				mysqli_stmt_close($stmt);
			}
			

				
		
			
		
	
		  
			

				 header("location: payment.php");
		
		}
			
?>
<html>
	<head>
		<title>Add Ticket Details</title>
	</head>
	<body>
		
	</body>
</html>
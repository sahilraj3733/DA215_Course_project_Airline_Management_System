<?php
	session_start();
?>
<html>
	<head>
		<title>Delete Flight Schedule Details</title>
	</head>
	<body>
		<?php
			if(isset($_POST['Delete']))
			{
				
					
				
					$flight_no=trim($_POST['flight_no']);
				
				
					$departure_date=trim($_POST['departure_date']);
			
					require_once('connect.php');
					$query="DELETE FROM flight WHERE Fno=? AND sdate=?";
					$stmt=mysqli_prepare($conn,$query);
					mysqli_stmt_bind_param($stmt,"ss",$flight_no,$departure_date);
					mysqli_stmt_execute($stmt);
					$affected_rows=mysqli_stmt_affected_rows($stmt);
					//echo $affected_rows."<br>";
					// mysqli_stmt_bind_result($stmt,$cnt);
					// mysqli_stmt_fetch($stmt);
					// echo $cnt;
					mysqli_stmt_close($stmt);
					mysqli_close($conn);
					/*
					$response=@mysqli_query($dbc,$query);
					*/
					if($affected_rows==1)
					{
						echo "Successfully Deleted";
						header("location: delete_flight.php?msg=success");
					}
					else
					{
						echo "Submit Error";
						echo mysqli_error();
						header("location: delete_flight_details.php?msg=failed");
					}
				}
				
		 	
			else
			{
				echo "Delete request not received";
			}
		?>
	</body>
</html>
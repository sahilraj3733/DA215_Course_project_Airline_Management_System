<?php
include 'connect.php';
 session_start();
 $email=$_SESSION['userp'];
$sql="select * from `users` where email='$email'";
$result=mysqli_query($conn,$sql);
if($result){
$row=mysqli_fetch_assoc($result);
$name=$row['Name'];
}
else{
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
		<link rel="stylesheet"  href="style.css"/>
		
	</head>
	<body>
	<img class="logo" src="photo.png"/>
		<h1 id="title">
			CENATION AIRLINES
		</h1>
      
		<div>
			<ul>
			    <li><a href="home_page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
				<li><a href="login_page.php"><i class="fa fa-ticket" aria-hidden="true"></i> Book Tickets</a></li>
				<li><a href="home_page.php"><i class="fa fa-plane" aria-hidden="true"></i> About Us</a></li>
				<li><a href="home_page.php"><i class="fa fa-phone" aria-hidden="true"></i> Contact Us</a></li>
				<li><a href="logout_page.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a></li>

                
			</ul>
            <li>Hello <?php echo $name ?></li>
		</div>

		<br>
       

  						
		

        <?php
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$from=$_POST['origin'];
			$to=$_POST['destination'];
			$sdate=$_POST['date'];
			$pass=trim($_POST['pass']);
		 
		 
		 }
		 $_SESSION['no_of_pass'] = $pass;
        
		 $sql = "SELECT * FROM `flight` WHERE `from`='$from' AND `to`='$to' AND `sdate`='$sdate'";

		 $_SESSION['from']=$from;
		 $_SESSION['to']=$to;
		 $_SESSION['journey_date']= $sdate;

        $result=mysqli_query($conn,$sql);
		
		if ($result) {
			// Open the container for flights

			
			echo "<form action=\"book_ticket.php\" method=\"post\">";
			echo "<table cellpadding=\"10\"";
			echo "<tr><th>Flight No.</th>
			<th>Flight Name.</th>
			<th>Origin</th>
			<th>Destination</th>
			<th>Departure Date</th>
			<th>Departure Time</th>
			<th>Arrival Date</th>
			<th>Arrival Time</th>
			<th>Price</th>
			<th> Available Seats</th>
			<th>Select</th>
			</tr>";
			
			
			
		
			while ($row = mysqli_fetch_assoc($result)) {
				$fno = $row['Fno'];
				$fname = $row['Fname'];
				$stime = $row['stime'];
				$etime = $row['etime'];
				$price = $row['price'];
				$to = $row['to'];
				$from = $row['from'];
				$sdate = $row['sdate'];
				$edate = $row['edate'];
				$remainTicket=$row['seatava'];
		
				if($remainTicket>0){
				echo "<tr>
				<td>".$fno."</td>
				<td>".$fname."</td>
				<td>".$from."</td>

				<td>".$to."</td>
				<td>".$sdate."</td>
				<td>".$stime."</td>
				<td>".$edate."</td>
				<td>".$etime."</td>
				<td>&#x20b9; ".$price."</td>
                <td>".$remainTicket."</td>
				<td><input type=\"radio\" name=\"select_flight\" value=\"".$fno."\"></td>
				</tr>";
				}
				else{
					echo "<tr>
				<td>".$fno."</td>
				<td>".$fname."</td>
				<td>".$to."</td>
				<td>".$sdate."</td>
				<td>".$stime."</td>
				<td>".$edate."</td>
				<td>".$etime."</td>
				<td>&#x20b9; ".$price."</td>
                <td>".$remainTicket*-1 .'waiting' ."</td>
				<td><input type=\"radio\" name=\"select_flight\" value=\"".$fno."\"></td>
				</tr>";
				}
			
		
			echo "</table> <br>";
			echo "<input type=\"submit\" value=\"Select Flight\" name=\"Select\">";
			echo "</form>";
		}
		
	}
		?>
		
     
     
	</body>
</html>


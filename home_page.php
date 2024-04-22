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
	echo "hi";
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
		<link rel="stylesheet" href="font-awesome-4.7.0\css\font-awesome.min.css">
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
				<li><a href="pnr.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Ticket</a></li>
				
				

                
			</ul>
			<li>Hello <?php echo $name ?></li>
            
		</div>

		<br>
		<div class="for">

		
    <form  action="search.php" method="POST">
	<h2><i class="fa fa-user-plus" aria-hidden="true"></i> Search your Best Flight</h2>
	<br>
	<table cellpadding='10'>
		
		<tr>
			<td> Enter the Origin </td>
			<td><input list="destinations" name="origin" placeholder="From" required>
  						<datalist id="destinations">
  						  	<option value="Mumbai">
  						  	<option value="Delhi">
  						  	<option value="Guwahati">
  						  	<option value="Patna">
  						  	<option value="hyderabad">
  						</datalist><br><br></td>
		</tr>
		<tr>
			<td>Enter the Destination  </td>
			<td> <input list="destinations" name="destination" placeholder="To" required>
  						<br><br></td>
		</tr>
		<tr>
			<td>Enter the Departure Date</td>
			<td><input type="date" name="date" required><br><br></td>
		</tr>
		<tr>
			<td> No. of ticket </td>
			<td><input type="int" name= "pass" placeholder="Number of ticket" required><br></td>
		</tr>
		<tr>
			<td><input type="submit" value="Search for Available Flights" name="Search"></td></tr>
		</table>
		</div>

</form>
  	
	</body>
</html>
<?php
	session_start();
?>
<html>
	<head>
		<title>
			View Booked Tickets
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
    			margin: 0% 15.8%
			}
			input[type=date] {
				border: 1.5px solid #030337;
    			border-radius: 4px;
    			padding: 5.5px 44.5px;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		
	</head>
	<body>
	<img class="logo" src="photo.png"/> 
		<h1 id="title">
			Cenation AIRLINES
		</h1>
		<div>
			<ul>
			   <li><a href="home_page.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
				
				<li><a href="home_page.php"><i class="fa fa-plane" aria-hidden="true"></i>Dashboard</a></li>
				
				<li><a href="logout_page.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a></li>
			</ul>
		</div>
		<form action="ticket.php" method="post">
			<h2>Check Your Ticket Status </h2>
			<div>
			<table cellpadding="5">
				<tr>
					<td class="fix_table">Enter the PNR Number</td>
					
					
				</tr>
				<tr>
					<td class="fix_table"><input type="int" name="pnr" required></td>
				</tr>
				
				
			</table>
			<br>
			<br>
			<input type="submit" value="Submit" name="Submit">
			</div>
		</form>
	</body>
</html>
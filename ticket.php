<?php
include 'connect.php';
 session_start();
 $email=$_SESSION['userp'];
$sql="select * from `admin` where email='$email'";
$result=mysqli_query($conn,$sql);
if($result){
$row=mysqli_fetch_assoc($result);
$name=$row['Name'];
}
else{
    die(mysqli_error($conn));
}

if($_SERVER['REQUEST_METHOD']=='POST'){
 
    $pnr = $_POST['pnr'];

}
$_SESSION['pnr']=$pnr;
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
            .outer-box {
            border: 1px solid black;
            padding: 10px; 
            margin-bottom: 20px; 
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
                <li><a href="cancel_ticket.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Cancel Ticket</a></li>
				

                
			</ul>
            <!-- <li>Hello <?php echo $name ?></li> -->
		</div>

		<br>
        
        <div class="outer-box">

		
	<h2><i class="fa fa-user-plus" aria-hidden="true"></i>CENATION AIRLINES TICKET</h2>
	<br>
	<table cellpadding='10'>
        
    <tr>  <th>***** Flight Details***********</th></tr>
         
               <tr>
					<th class="fix_table"> PNR </td>
                    <th class="fix_table">  Flight No./Name  </td>
                    <th class="fix_table"> Distance  </td>
                    <th class="fix_table"> Total Price  </td>


					
				</tr>
               

				
                    <?php
                    $sql = "SELECT ticket_details.flight_no, flight.Fname, flight.Distance, flight.Fno, payment_details.payment_amount
                    FROM ticket_details
                    INNER JOIN flight ON ticket_details.flight_no = flight.Fno
                    INNER JOIN payment_details ON ticket_details.pnr = payment_details.pnr
                    WHERE ticket_details.pnr = '$pnr'";
            
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Fetching the first row
                    $row = mysqli_fetch_assoc($result);
                    $sname = $row['Fname']; 
                    $Fnumber=$row['Fno'];
                    $distance = $row['Distance']; 
                    $paisa=$row['payment_amount'];
                    
                    // Further processing if needed
                } else {
                    // No rows found
                    echo "No flight details found for the given PNR.";
                }
            } else {
                // Error handling
                echo "Error: " . mysqli_error($conn);
            }
            
                 $_SESSION['fno']= $Fnumber;
           ?>
                <th><?php echo $pnr ;?></td>
                <th class='fix_table'><?php echo  $Fnumber, "/",$sname ;?></td>
                <th class='fix_table'><?php echo $distance ;?></td>
                <th class="fix_table"><?php echo $paisa ;?></td>

				</tr>



		
		<tr>
        
    
     <?php    
    $sql = "SELECT * FROM `passengers` WHERE pnr='$pnr'";
    $result = mysqli_query($conn, $sql);
   
    echo "<tr>  <th>***** Passengers Details***********</th></tr>";

    if($result) {
      
        if(mysqli_num_rows($result) > 0) {
            // Start table
          
            echo '<tr>';
            echo '<th> sno</th>';
            echo '<th>Name</th>';
            echo '<th>Age</th>';
            echo '<th>Gender</th>';
            echo '<th>Seat Number</th>';
            echo '</tr>';

            
            while($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<th>' . $row['passenger_id'] . '</th>';
                echo '<th>' . $row['name'] . '</th>';
                echo '<th>' . $row['age'] . '</th>';
                echo '<th>' . $row['gender'] . '</th>';
                if($row['seatno']>0){
                    echo '<th>' . $row['seatno'] . '</th>';
                }
                else{
                    echo '<th>' . ($row['seatno'] * -1) . 'waiting' . '</th>';

                }
               
                echo '</tr>';
            }

            
          
        } else {
           
            echo 'No records found.';
        }
    } else {
        // Query failed
        echo 'Error: ' . mysqli_error($conn);
    }
    

?>

            
			
			
		</div>


        


  	
	</body>
</html>
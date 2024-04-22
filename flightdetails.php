<?php
include 'connect.php';
 session_start();


 if (isset($_GET['fno'])) {
    $fno = $_GET['fno'];
    
}
 

 $email=$_SESSION['usera'];
$sql="select * from `admin` where email='$email'";
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
		<link rel="stylesheet" href="font-awesome-4.7.0\css\font-awesome.min.css">
	</head>
	<body>
		<img class="logo" src="photo.jpg"/> 
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
            <li>Hello <?php echo $name ?></li>
		</div>

           
		<br>
        <div class="mid">
        
     <table class="table">
  <thead>
    <tr>
      <th scope="col">Flight Number    </th>
      <th scope="col">Flight Name   </th>
	  <th scope="col">From </th>
      <th scope="col">TO    </th>
      <th scope="col">Distance  </th>
	  <th scope="col">Starting Date </th>
      <th scope="col">Arrival Date </th>
      <th scope="col">Startion Time  </th>
	  <th scope="col">Arrival Time </th>
      <th scope="col">Total Seat   </th>
      <th scope="col">Avliable Seat  </th>
	  <th scope="col">Price</th>

      
    </tr>
  </thead>
  <tbody>
   <?php

   $sql="select * from `flight`where Fno=$fno ";
   $result=mysqli_query($conn,$sql);
   if($result){

    $row=mysqli_fetch_assoc($result);
        $Fno=$row['Fno'];
        $Fname=$row['Fname'];
        $From=$row['from'];
        $to=$row['to'];
        $price=$row['price'];
        $Distance=$row['Distance'];
        $sdate=$row['sdate'];
        $edate=$row['edate'];

        $totalSeat=$row['seatava'];
        $stime=$row['stime'];
        $etime=$row['etime'];
       
        echo  '<tr scope ="col">
            <th scope= "col">'.$Fno.'</th>
            <th scole="col">'.$Fname.'</th>
            <th scope= "row">'.$From.'</th>
            <th scole="row">'.$to.'</th>
           
            <th scole="col">'.$Distance.'</th>
            <th scope= "col">'.$sdate.'</th>
            <th scole="col">'.$edate.'</th>
			
            <th scope= "col">'.$stime.'</th>
            <th scole="col">'.$etime.'</th>
            <th scole="col">'.$totalSeat.'</th>
            <th scole="">'.$price.'</th>
          
           
          </tr>';
      
    
   }


?>
    



  </tbody>
  
</table>
    </div>
   
 

		
	</body>
</html>
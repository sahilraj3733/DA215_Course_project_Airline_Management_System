

<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $username=$_POST['username'];
    $password=$_POST['password'];
	$email=$_POST['email']; 
    $name=$_POST['name'];
	$phone=$_POST['phone_no'];
    $address=$_POST['address'];
	$gender=$_POST['gender'];
	$age=$_POST['age'];
	$role='passenger';
	
  
    $sql="select * from `users` where UID='$username'";
      $result=mysqli_query($conn,$sql);
       if($result){
          $num=mysqli_num_rows($result);
           if($num>0){
            echo "user already exist";
             }
          else{
           
	        $sql="insert into `users`(Uid,Name,email,password,Gender,Age,Mobile_No,Address,role) values('$username','$name','$email','$password','$gender','$age','$phone','$address','$role')";
                $result=mysqli_query($conn,$sql);
                if(!$result){
                    die(mysqli_error(conn));
                }
				else{
					echo "Signup Successfully";
					header('location:login_page.php');
				}
            }
        }
    
}

?>

<html>
	<head>
		<title>
			Create New User Account
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
				<li><a href="login_page.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
			</ul>
		</div>
		<br>
		<div class="for">

		
		<form class="center_form" action="signup.php" method="POST" id="new_user_from">
			<h2><i class="fa fa-user-plus" aria-hidden="true"></i> CREATE NEW USER ACCOUNT</h2>
			<br>
			<table cellpadding='10'>
				<strong>ENTER LOGIN DETAILS</strong>
				<tr>
					<td>Enter a valid username  </td>
					<td><input type="text" name="username" required><br><br></td>
				</tr>
				<tr>
					<td>Enter your desired password  </td>
					<td><input type="password" name="password" required><br><br></td>
				</tr>
				<tr>
					<td>Enter your email ID</td>
					<td><input type="text" name="email" required><br><br></td>
				</tr>
				
				
				
			</table>
			<br>
			<table cellpadding='10'>
				<strong>ENTER CUSTOMER'S PERSONAL DETAILS</strong>
				<tr>
					<td>Enter your name  </td>
					<td><input type="text" name="name" required><br><br></td>
				</tr>
				<tr>
					<td>Enter your phone no.</td>
					<td><input type="text" name="phone_no" required><br><br></td>
				</tr>
				<tr>
					<td>Enter your address</td>
					<td><input type="text" name="address" required><br><br></td>
				</tr>
				<tr>
					<td>Age</td>
					<td><input type="int" name="age" required><br><br></td>
				</tr>
				<tr>
					<td>Gender</td>
					<td> <select id="gender" name="gender" required>
                   <option value="" disabled selected>Select Gender</option>
                 <option value="Male">Male</option>
                 <option value="Female">Female</option>
             <option value="Other">Other</option>
                  </select>
				
				</td>
				</tr>
			</table>
			<br>
			<input type="submit" value="Submit" name="Submit">
			<br>
			</div>
		</form>
	</body>
</html>
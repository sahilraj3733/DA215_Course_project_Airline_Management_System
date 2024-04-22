
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
    $password=$_POST['password'];
	$email=$_POST['email']; 
	$role=$_POST['role'];
	if($role=='admin'){
		$sql="select * from `admin` where email='$email' and password='$password'";
		$result=mysqli_query($conn,$sql);
		if($result){
			$num=mysqli_num_rows($result);
			if($num>0){
				
				session_start();
				$_SESSION['usera']=$email;
				header('location:admin_home_page.php');
				
			}
		    else{
		      echo "Invalid User Name OR Password";
					
				}
		}
	}
  else{
       $sql="select * from `users` where email='$email'and password='$password'";
      $result=mysqli_query($conn,$sql);
       if($result){
          $num=mysqli_num_rows($result);
           if($num>0){
			session_start();
            $_SESSION['userp']=$email;
            header('location:home_page.php');
             }
          else{
            echo "Invalid User Name OR Password";
            }
        }
    }
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
				
				<li><a href="login_page.php"><i class="fa fa-ticket" aria-hidden="true"></i> Book Tickets</a></li>
				<li><a href="home_page.php"><i class="fa fa-plane" aria-hidden="true"></i> About Us</a></li>
				<li><a href="home_page.php"><i class="fa fa-phone" aria-hidden="true"></i> Contact Us</a></li>
				<li><a href="login_page.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
			</ul>
		</div>
		<br>
		<div class="for">

		<form class="center_form" action="login_page.php" method="POST" >
			<h2><i class="fa fa-user-plus" aria-hidden="true"></i> LOGIN ACCOUNT</h2>
			<br>
			<table cellpadding='10'>
                <tr>
					<td>Enter your email ID</td>
					<td><input type="text" name="email" required><br><br></td>
				</tr>
				
				<tr>
					<td>Enter your  password  </td>
					<td><input type="password" name="password" required><br><br></td>
				</tr>
				
				<tr>
					<td>Role</td>
					<td> <select  name="role" required>
                   <option value="" disabled selected>Role </option>
                   <option value="passenger">Passenger</option>
                 <option value="admin">Admin</option>
             
                  </select>
				
				</td>
				</tr>
				
				
			</table>

                
			<br>
			<input type="submit" value="Submit" name="Submit">
			<br>
            <a href="signup.php">Create New Account</a>
			</div>
		</form>
		
	</body>
</html>
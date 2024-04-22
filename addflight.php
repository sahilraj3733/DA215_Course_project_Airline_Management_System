<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    $num = $_POST['num'];
    $Fname = $_POST['name'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $distance = $_POST['distance'];
    $seat = $_POST['seat'];
    $sdate = $_POST['sdate'];
    $adate = $_POST['adate'];
    $stime = $_POST['stime'];
    $atime = $_POST['atime'];
    $price = $_POST['price'];

    $sql = "SELECT * FROM `flight` WHERE Fno='$num'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            echo "Flight Number already exists.";
        } else {
            $insert_sql = "INSERT INTO `flight` (Fname, Fno, `from`, `to`, price, Distance, sdate, edate, total_seats, stime, etime,seatava) VALUES ('$Fname', '$num', '$from', '$to', '$price', '$distance', '$sdate', '$adate', '$seat', '$stime', '$atime','$seat')";
            $insert_result = mysqli_query($conn, $insert_sql);
            if ($insert_result) {
                echo "Flight added successfully.";
                header('Location: admin_home_page.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    
    <title>Add Flight</title>
    
</head>
<body>

   <form action='addflight.php' method ='post'  class ='center_form'>
			<h2>ADD NEW FLIGHT</h2>
			
		
    <div class="container" >
        <div class="table">
       

             <table cellpadding ="10" >
             
           <tr>
            <td> Flight NO: </td>
            <td>  <input type="int" name='num'required><br><br> </td>
           </tr>
           <tr>
            <td> Flight Name: </td>
            <td>  <input type="int" name='name'required><br><br> </td>
           </tr>
           <tr>
            <td>From :</td>
            <td> <input type="text" name='from'><br><br></td>
           </tr>
           <tr>
            <td>TO :</td>
            <td><input type="text" name='to'required><br><br></td>
           </tr>
           <tr>
            <td>Distance :</td>
            <td><input type="int" name='distance' required><br><br></td>
           </tr>
           <tr>
            <td>Total Seats :</td>
            <td>  <input type="int" name='seat'required><br><br></td>
           </tr>
           <tr>
            <td>Start Date</td>
            <td><input type="date" name='sdate'required><br><br></td>
           </tr>
           <tr>
            <td>Arrived Date</td>
            <td><input type="date" name='adate'required><br><br></td>
           </tr>
           <tr>
            <td>Start Time :</td>
            <td> <input type="time" name='stime'required><br><br></td>
           </tr>
           <tr>
            <td>Arrived Time :</td>
            <td> <input type="time" name='atime'required><br><br></td>
           </tr>
           <tr>
            <td>Price :</td>
            <td><input type="int" name='price'required><br><br></td>
           </tr>
           <tr>
            <td></td>
            <td></td>
           </tr>

    
            
            
          <td> <button>Add </button></td>

          
        </form>
        </table>
    </div>
    </div>
</body>
</html>
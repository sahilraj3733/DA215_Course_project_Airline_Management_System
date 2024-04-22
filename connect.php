<?php
$servername="localhost";
$username="root";
$password="";
$database="airline";

$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die(mysqli_error($conn));
}

?>
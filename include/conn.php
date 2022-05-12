<?php 
$host = "localhost";
$user = "root";
$pass = "101scripting";
$db = "apple-sale";
$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn){
	 echo('MYSQL ERROR: '.mysqli_connect_error());
	 die();
 }
?>
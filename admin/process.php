<?php
if($_POST['password'] != 'YourPasswordHere')
	exit("Incorrect password!");

require("../include/conn.php");

//Clear the database
mysqli_query($conn,"DELETE FROM items");
mysqli_query($conn,"DELETE FROM categories");

//Check the filename, open the file
if(substr($_FILES['uploadedFile']['name'],-3) != "csv")
	die("Please convert to CSV, then upload again.");
$file = fopen($_FILES['uploadedFile']['tmp_name'], "r");

//Read each row of the file, add to database
$currentCategory = "";
while(($row = fgetcsv($file)) !== FALSE){ 
	if($row[1] === "SKUs"){
		$currentCategory = addCategory($conn,"AirPods");
		continue;
	}
	if($row[1] === ""){
		$currentCategory = addCategory($conn,$row[0]);
		continue;
	}

	$name = $row[0];
	$sku = $row[1];
	$retail = preg_replace('/\D/',"",$row[2]);
	$student = preg_replace('/\D/',"",$row[4]);
	$alumni = preg_replace('/\D/',"",$row[5]);

	$query = "INSERT INTO items (applePrice, studentPrice, alumniPrice, sku, item, category)
		VALUES ($retail,$student,$alumni,'$sku','$name',$currentCategory)";
	mysqli_query($conn,$query);
	echo(mysqli_error($conn));
}

function addCategory($conn,$name){
	$name = mysqli_real_escape_string($conn,$name);
	$query = "INSERT INTO categories (name) VALUES ('$name')";
	if(mysqli_query($conn,$query))
		return mysqli_insert_id($conn);
	else
		return FALSE;
}

//Close file, exit
exit("File processed successfully.");

?>

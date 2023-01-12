<?php
// connection Parameters
$servername = 'localhost';
$username = 'root';
$userpwd = '';
$dbname = 'ecad_assgdb'; 

// create connection
$conn = new mysqli($servername, $username, $userpwd, $dbname);

// check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);	
}
?>

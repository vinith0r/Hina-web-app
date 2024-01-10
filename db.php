<?php
$servername = "localhost";
$username = "vini";
$password = "vinith8001";
$dbname = "lahtp";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if($conn != NULL){
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}else{
echo "Connected successfully";
}
}
?>

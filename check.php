<?php
$servername = "localhost";
$username = "vini";
$password = "Vinith01@8001";
$dbname = "learn";

$name = "vinith";
$lastname = "raj";
$email = "vini01.me@gmail.com";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  echo $username;
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO authentication (name, lastname, password)
VALUES ('$name', '$lastname', '$email')";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

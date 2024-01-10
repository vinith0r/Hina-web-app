
<?php

// USED AS REFRENCE HOME Page
include 'library/auth.php';

if(isset($_COOKIE['username']) and isset($_COOKIE['token'])){
  $username = $_COOKIE['username'];
  $token = $_COOKIE['token'];

  if(!verify_session($username, $token)){
    header("Location: /signin.php");
  }
} else {
	header("Location: /signin.php");
}
?>
This is home, welcome <?php echo $_COOKIE['username'];?>
<br>
<a href="/lahtp/logout.php">Logout</a>

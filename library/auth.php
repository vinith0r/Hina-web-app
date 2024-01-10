<?php 

//COMPLETED 

//$salt = "kjfafh33hjhkja2o82wy";

$db_conn = NULL;
$db_servername = "localhost";
$db_username = "vini";
$db_password = "vinith8001";
$db_name = "lahtp";
function get_db_connection(){ 

global $db_conn;
global $db_servername;
global $db_username;
global $db_password;
global $db_name;

if ($db_conn != NULL) {
	return $db_conn;
} else {
	$db_conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name);
	if (!$db_conn) {
		die("Connection failed: ".mysqli_connect_error());
	} else {
		return $db_conn;
	}
}
}
get_db_connection();

function get_hashed_passwd($password){
//	global $salt;
	return md5($password);
}
/*
1. Save the details to the database
2. password has to be hashedauthentication
3. OTP has to be generated and saved
*/
function do_signup($username, $password){
	$hashed_passwd = get_hashed_passwd($password);
	$otp           = rand(100000, 999999);
	$query = "INSERT INTO `lahtp`.`authentication` (`username`, `password`, `otp`) VALUES ('$username', '$hashed_passwd', '$otp');";
	$db_conn       = get_db_connection();
	if (mysqli_query($db_conn, $query)) {
		return 1;
	} else {
		return mysqli_error($db_conn);
	}
}

/*
1. check if the OTP is same as in the saved database
2. if OTP is correct change active to 1

*/
function do_verify_signup($username, $otp){
	$query   = "SELECT * FROM lahtp.authentication WHERE username='$username';";
	$db_conn = get_db_connection();
	$result  = mysqli_query($db_conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		if ($row['otp'] == $otp) {
			return activate($username);
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}

/*
1. set active to 1
*/
function activate($username){
	$query   = "UPDATE `lahtp`.`authentication` SET `active` = '1' WHERE (`username` = '$username');";
	$db_conn = get_db_connection();
	return mysqli_query($db_conn, $query);
}
/*
1. check if user exist in the database
2. if user exist, check if the password is wright
3. if password is correct set cookies
*/
function do_login($username, $password){
	$hashed_passwd = get_hashed_passwd($password);
	$query   = "SELECT * FROM lahtp.authentication WHERE `username`='$username';";
	$db_conn = get_db_connection();
	$result  = mysqli_query($db_conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		if ($row['password'] == $hashed_passwd) {
			$token = get_hashed_passwd(rand(100000,999999));
			$expiry = time()+(60*60*30);
			return add_session($username, $token, $expiry);
		} else {
			return 0;
		}
	} else {
		return 0;
	}	
}
/*
1. on successful login genarate $token and add it ti the session
2. set the proper expriry time same as the cookie
3.
*/
function add_session($username, $token, $expiry){
	$mysqltime = date('Y-m-d H:i:s', $expiry);
	$query = "INSERT INTO `lahtp`.`session` (`username`,`token`,`expiry`) VALUES ('$username','$token','$mysqltime');";
	$db_conn       = get_db_connection();
	if (mysqli_query($db_conn, $query)) {
		setcookie('username', $username, $expiry, "/");
		setcookie('token', $token, $expiry, "/");
		return 1;
	} else {
		return mysqli_error($db_conn);
	}
}
/*
1. Everytime when a user access any page, we check the $username and $token from $_COOKIE to ensure that session is still valid and not expired
2. if valid let him through
3. if not, invaliate the session and send him to login 
*/
function verify_session($username, $token){
	$query   = "SELECT * FROM lahtp.session WHERE username='$username' AND token = '$token';";
	$db_conn = get_db_connection();
	$result  = mysqli_query($db_conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		if((int)$row['active'] == 1){
			$expiry = strtotime($row['expiry']);
			if($expiry > time()){
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}
/*
1. set the expiry to current time and set active 0.
*/
function invalidate_session($username, $token){
	$query   = "UPDATE `lahtp`.`session` SET `active` = '0' WHERE `username` = '$username' AND `token` = '$token';";
	$db_conn = get_db_connection();
	setcookie('username', $username, time()-36000, "/"); 
	setcookie('token', $token, time()-36000, "/");
	return mysqli_query($db_conn, $query);
}
// get current username from cookie to use in /post.php
function get_current_username1(){
	if(isset($_COOKIE['username']) and isset($_COOKIE['token'])){
	if(verify_session($_COOKIE['username'], $_COOKIE['token'])){
		return $_COOKIE['username'];
	} else {
		return NULL;
	}
}
}

function get_otp(){
	$conn = get_db_connection();
    $username = get_current_username1();
    $query = "SELECT `otp` AS otp FROM lahtp.authentication";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
		$posts = [];
		while($row = mysqli_fetch_assoc($result)){
			$posts[] = $row;
		}
		return end($posts);
	} else {
		return [];
	}
}
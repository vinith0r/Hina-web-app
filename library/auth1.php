<!--  Another Copy of auth.php & checking purpose
-->


<?php
$SALT = "asdjhbqwuidnwipr7y289ehiydvqiux";

$db_conn       = NULL;
$db_servername = "localhost";
$db_username   = "vini";
$db_password   = "Vinith01@8001";
$db_name       = "lahtp";

function get_db_connection() {
	global $db_conn;
	global $db_servername;
	global $db_username;
	global $db_password;
	global $db_name;

	if ($db_conn != NULL) {
		return $db_conn;
	} else {
		echo $db_username."hello";
		$db_conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name);
		if (!$db_conn) {
			die("Connection failed: ".mysqli_connect_error());
		} else {
			echo "success";
			return $db_conn;
		}
	}
}

function get_hashed_passwd($password) {
	global $SALT;
	return md5(strrev($password.$SALT));
}

/*
1. Save the details to the database
2. Password has to be hashed.
3. OTP has to be generated and saved
 */
function do_signup($username, $password) {
	$hashed_passwd = get_hashed_passwd($password);
	$otp           = rand(100000, 999999);
	$query         = "INSERT INTO `lahtp`.`authentication` (`username`, `password`, `otp`) VALUES ('$username', '$hashed_passwd', '$otp');";
	$db_conn       = get_db_connection();
	if (mysqli_query($db_conn, $query)) {
		return 1;
	} else {
		return mysqli_error($db_conn);
	}
}

/*
1. We check if the OTP is same as we saved in the database.
2. If OTP is correct, change active to 1.
 */
function do_verify_signup($username, $otp) {
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
1. Set active to 1.
 */
function activate($username) {
	$query   = "UPDATE `lahtp`.`authentication` SET `active` = '1' WHERE (`username` = '$username');";
	$db_conn = get_db_connection();
	return mysqli_query($db_conn, $query);
}

/*
1. Check if user exists in the database
2. If user exists, check if the password is right.
3. If password is right, set cookies.
 */
function do_login($username, $password) {
	$hashed_passwd = get_hashed_passwd($password);
	$query   = "SELECT * FROM lahtp.authentication WHERE username='$username';";
	$db_conn = get_db_connection();
	$result  = mysqli_query($db_conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
		if ($row['password'] == $hashed_passwd) {
			$token = get_hashed_passwd(rand(100000,999999));
			$expiry = time()+(60*60);
			return add_session($username, $token, $expiry);
		} else {
			return 0;
		}
	} else {
		return 0;
	}

}

/*
1. On successful login, we generate a $token and add it to the sessions table.
2. Set the proper expiry time for the same as the cookie.
 */
function add_session($username, $token, $expiry) {
	 $mysqltime = date('Y-m-d H:i:s', $expiry);
	 $query = "INSERT INTO `lahtp`.`session` (`username`, `token`, `expiry`) VALUES ('$username', '$token', '$mysqltime');";

	$db_conn = get_db_connection();
	if (mysqli_query($db_conn, $query)) {
		setcookie('username', $username ,$expiry,'/', 'lahtp.vhx.cloud');
		setcookie('token', $token ,$expiry,'/', 'lahtp.vhx.cloud');
		return 1;
	} else {
		return mysqli_error($db_conn);
	}
}

/*
1. Everytime when a user access any page, we check the $username and $token combo from $_COOKIE to ensure that the session is still valid and not expired.
2. If valid, let him through.
3. If not, invalidate the session and send him to login.
 */
function verify_session($username, $token) {
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
1. Set the expiry to current time and set the active to 0.
This is also logout
 */
function invalidate_session($username, $token) {
	$query   = "UPDATE `lahtp`.`session` SET `active` = '0' WHERE `username` = '$username' AND `token` = '$token';";
	$db_conn = get_db_connection();
	return mysqli_query($db_conn, $query);
}

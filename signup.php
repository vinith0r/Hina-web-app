<?php
include 'library/auth.php';

if(isset($_COOKIE['username']) and isset($_COOKIE['token'])){
	$username = $_COOKIE['username'];
	$token = $_COOKIE['token'];

	if(verify_session($username, $token)){
		header("Location: /lahtp/home.php");
	}
}

$flag = 0;
if(!isset($_GET['verify']) and isset($_POST['username']) and isset($_POST['password']) and isset($_POST['cpassword'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	if($password == $cpassword){
		if(do_signup($username, $password) == 1){
			header("Location: /lahtp/signup.php?verify=$username");
		} else {
			$flag = -2;
		}
	} else {
		$flag = -1; //password and confirm password do not match
	}
}

if(isset($_GET['verify']) or isset($_POST['otp'])){
	$otp = $_POST['otp'];
	$username = $_GET['verify'];
	if(isset($_POST['otp'])){
		if(do_verify_signup($username, $otp)){
			header("Location: /lahtp/signin.php?signup=success");
			exit();
		} else {
			$flag = -3;
		}
	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v4.1.1">
	<title>Signup</title>

	<link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

	<!-- Bootstrap core CSS -->
	<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		.newbod{
			text-align: center;
		}
		.form-signin{
			display: inline-block;
		}
		
	</style>
	<!-- Custom styles for this template -->
	<link href="sign-in.css" rel="stylesheet">
</head>
<body class="newbod">
	<?php
	if(isset($_GET['verify'])) {?>
	<form class="form-signin" action="/lahtp/signup.php?verify=<?php echo $username;?>" method="POST">
		<?php
		if($flag == -3){
			?>
			<div class="alert alert-danger" role="alert">
				Invalid OTP, try again
			</div>
			<?php
		}
		?>
		<!-- <img class="mb-4" src="" alt="" width="72" height="72"> -->
		<h6 class="h3 mb-3 font-weight-normal">OTP :<?php print_r(get_otp());
		?></h6><br>
		<h1 class="h3 mb-3 font-weight-normal">Please verify</h1>
		<label for="inputusername" class="sr-only">Enter OTP</label>
		<input name="otp" type="text" id="inputusername" class="form-control" placeholder="Enter 6 digit OTP" required autofocus>
		<br>
		<input type="hidden" id="form_id" name="form_id" value="otp_form">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Verify</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2024</p>
	</form>
	<?php } else { ?>
	<form class="form-signin" action="/lahtp/signup.php" method="POST">
		<?php
		if($flag == -1){
			?>
			<div class="alert alert-danger" role="alert">
				Password and confirm password do not match
			</div>
			<?php
		} else if($flag == -2) {
			?>
			<div class="alert alert-danger" role="alert">
				Cannot signup, username already taken.
			</div>
			<?php
		}
		?>
		<img class="mb-4" src="styles/img/icons8-login-100.png" alt="" width="72" height="72">
		<h1 class="h3 mb-3 font-weight-normal">Welcome, Signup</h1>
		<label for="inputusername" class="sr-only">Username</label>
		<input name="username" type="text" id="inputusername" class="form-control" placeholder="Username" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<div class="form-group">
			<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
			<input name="cpassword" type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>
		</div>
		<br>
		<input type="hidden" id="form_id" name="form_id" value="signup_form">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
		<a href="/lahtp/signin.php">Already have an account? Signin!</a>
		<p class="mt-5 mb-3 text-muted">&copy; 2024</p>
	</form>
	<?php } ?>
</body>
</html>
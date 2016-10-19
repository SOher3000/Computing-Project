<?php
	include_once('db/db.php');
	include_once('header.html');
	include_once('reducedMenu.php');
	
	$error = '';
	
	if(isset($_POST['submitted'])) {
	$Username=mysqli_real_escape_string($db, trim($_POST['Username']));
	$password=mysqli_real_escape_string($db, trim($_POST['password']));
	
	if(!empty($Username) && !empty($password)){
	$result = mysqli_query($db,"select * from users where name ='$Username' and password = MD5('$password')");
	if ($result->num_rows != 1) {
	$error = 'Query filed - Please try again';
	} else {
		$userData = mysqli_fetch_array($result);
	session_start();
	$_SESSION['userid'] = $userData["userid"];
	$_SESSION['user'] = $Username;
	header('Location: index.php');
	exit();
	}
	} else {
	$error = 'Please fill both';
	}
	
	}
	if(!empty($error)){
	echo "<div class='error' >$error</div>";
	}
	
	
	/*
	
	USER ACCOUNT CREATION
	
	IF NEW USER ACCOUNT NEEDED ACCESS usrAccCrtn.php TO REGISTER NEW USER
	
	*/
	
	?>
	
	<div id='content' >
		<h3>Login</h3>
		<form action='' method='POST' >
		Username&nbsp;<input type='text' name='Username'/><br/>
		Password&nbsp;<input type='password' name='password' /><br/>
		<input type='hidden' name='submitted' value='true' />
		<input type='submit' value='Login'/>
		</form>
	</div>
	
<?php
//=====DB parameters=====
$dbServer="tutorial-tvitterchat-mariadb.mariadb.database.azure.com";
$dbUser="tvitter";
$dbPassword="tvitter";
$dbName="tvitter";
//=======================

$conn=mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);
if(!$conn){
	die("DB connection failed: ").mysqli_connect_error();
}
//można dodać mechanizm po stronie bazy który automatycznie usuwa stare wiadomości, np. sprzed 3 godzin
if(array_key_exists("loginButton",$_POST)){
	$iLogin=$_POST["iLogin"];
	$iPassword=$_POST["iPassword"];
	
	$sql="select uid, login, password from users where login='".$iLogin."'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)<=0){
		echo "<script>alert('User with this name not exists!');</script>";
	}else{
		$uid=null;
		$uPassword=null;
		while($row=mysqli_fetch_assoc($result)){
			$uid=$row["uid"];
			$uPassword=$row["password"];
			break;
		}
		if(!password_verify($iPassword,$uPassword)){
			echo "<script>alert('Wrong password!');</script>";
		}else{
			$sid=substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPRSTUWXYZ"), 1, 16);
			$date=date("Y-m-d H:i:s");
			
			$sql="insert into sessions (sid, user, date) values ('".$sid."','".$uid."','".$date."')";
			if(!mysqli_query($conn, $sql)){
				echo "<script>alert('Login failed: ".mysqli_error($conn)."');</script>";
			}else{
				setcookie("cSID",$sid);
				//echo "<script>alert('Login complete');</script>";
				echo "<script>window.location.replace('index.php');</script>";
			}
		}
	}
}
	
	
if(isset($_COOKIE["cSID"])){
	$cSID=$_COOKIE["cSID"];
	
	$sql="select user from sessions where sid='".$cSID."'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		echo "<script>window.location.replace('index.php');</script>";
	}
}
?>


<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login | Tvitter-Chat</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<div id="root">
		<div id="content">
			<div class="card nav-login-register-card">
				<div class="card-body">
					<h1 class="card-title" style="color:white">Tvitter-Chat</h1>
					<h3 class="card-title" style="color:white">- Login -</h3>
				</div>
			</div>
		
			<form action="" method="POST">
				<div class="card login-register-card">
					<div class="card-body">
						<label for="iLogin" class="form-label login-register-labels">Login</label>
						<input type="text" class="form-control login-register-inputs" id="iLogin" name="iLogin" placeholder="login" required />
						<label for="iPassword login-register-labels" class="form-label login-register-labels">Password</label>
						<input type="password" class="form-control login-register-inputs" id="iPassword" name="iPassword" placeholder="password" required />
						<a href="register.php"><button type="button" class="btn btn-warning btn-lg login-register-buttons">Sign up</button></a>
						<input type="submit" value="Sign in" id="loginButton" name="loginButton" class="btn btn-success btn-lg login-register-buttons"/>
					</div>
				</div>
			</form>
		</div>
		<div class="author">40843 - Damian Osiak</div>
	</div>
</body>
</html>
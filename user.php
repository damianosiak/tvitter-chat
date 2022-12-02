<?php
//=====DB parameters=====
$dbServer="tutorial-tvitterchat-mariadb.mariadb.database.azure.com";
$dbUser="tvitter";
$dbPassword="tvitter";
$dbName="tvitter";
//=======================
$cSID=null;
$uid=null;
$login=null;
$password=null;
$email=null;

$conn=mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);
if(!$conn){
	die("DB connection failed: ").mysqli_connect_error();
	echo "<script>window.location.replace('error.php');</script>";
}


if(isset($_COOKIE["cSID"])){
	$cSID=$_COOKIE["cSID"];
	//$sql="select user from sessions where sid='".$cSID."'";
	$sql="select s.user, u.login, u.password, u.email from sessions s inner join users u on s.user=u.uid where s.sid='".$cSID."'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$uid=$row["user"];
			$login=$row["login"];
			$password=$row["password"];
			$email=$row["email"];
			break;
		}
	}else{
		echo "<script>window.location.replace('login.php');</script>";
	}
}else{
	echo "<script>window.location.replace('login.php');</script>";
}


if(array_key_exists("logoutButton",$_POST)){
	unset($_COOKIE['cSID']);
	setcookie('cSID', '', time()-3600);
	$sql="delete from sessions where sid='".$cSID."'";
	if(!mysqli_query($conn, $sql)){
		echo "<script>alert('Error: ".mysqli_error($conn)."');</script>";
	}
	echo "<script>window.location.replace('login.php');</script>";
}


if(array_key_exists("saveUserButton",$_POST)){
	$iPassword=$_POST["iPassword"];
	$iEmail=$_POST["iEmail"];
	$sql=null;
	$sqlState=0;
	
	if(($password!=$iPassword) && ($email!=$iEmail)){
		$password=password_hash($iPassword, PASSWORD_ARGON2I);
		$sql="update users set password='".$password."',email='".$iEmail."' where uid='".$uid."'";
		$sqlState=1;
	}else if(($password!=$iPassword) && ($email==$iEmail)){
		$sql="update users set password='".$password."' where uid='".$uid."'";
		$sqlState=2;
	}else if(($password==$iPassword) && ($email!=$iEmail)){
		$sql="update users set email='".$iEmail."' where uid='".$uid."'";
		$sqlState=3;
	}
	
	if(!is_null($sql)){
		if(!mysqli_query($conn, $sql)){
			echo "<script>alert('Error: ".mysqli_error($conn)."');</script>";
			$sqlState=0;
		}
	}
	
	switch($sqlState){
		case 0:
			echo "<script>alert('Nothing has been changed!');</script>";
			break;
		case 1:
			echo "<script>alert('Password and email has been successfully changed');</script>";
			break;
		case 2:
			echo "<script>alert('Password has been successfully changed');</script>";
			break;
		case 3:
			echo "<script>alert('Email has been successfully changed');</script>";
			break;
		default:
			echo "<script>alert('Nothing has been changed!');</script>";
	}
	echo "<script>window.location.replace('user.php');</script>";
}
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>User | Tvitter-Chat</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<div id="root">
		<div id="content">
			<div class="card nav-user-card">
				<div class="card-body">
					<div class="nav-buttons">
						<a href="index.php"><button type="button" class="btn btn-warning">Back</button></a>
						<form action="" method="POST" class="inline-form"><input type="submit" action="" method="POST" id="logoutButton" name="logoutButton" value="Logout" class="btn btn-danger" /></form>
					</div>
					<h1 class="card-title" style="color:white">Tvitter-Chat</h1>
					<h3 class="card-title" style="color:white">- User details -</h3>
				</div>
			</div>
		
			<div class="card user-card">
				<form action="" method="POST" onsubmit="return confirm('Are you sure you want to save?');">
					<div class="card-body">
						<label for="iLogin" class="form-label user-labels">Login</label>
						<input type="text" id="iLogin" name="iLogin" class="form-control user-inputs" value="<?php echo $login;?>" disabled />
						
						<label for="iPassword" class="form-label user-labels">Password</label>
						<input type="password" id="iPassword" name="iPassword" class="form-control user-inputs" value="<?php echo $password;?>" />
						
						<label for="iEmail" class="form-label user-labels">Email</label>
						<input type="email" id="iEmail" name="iEmail" class="form-control user-inputs" value="<?php echo $email;?>" />
						
						<button type="reset" class="btn btn-warning btn-lg user-buttons">Reset</button>
						<input type="submit" class="btn btn-success btn-lg user-buttons" value="Save" id="saveUserButton" name="saveUserButton" />
					</div>
				</form>
			</div>
		<div>
		<div class="author">40843 - Damian Osiak</div>
	</div>
		
		
</body>
</html>
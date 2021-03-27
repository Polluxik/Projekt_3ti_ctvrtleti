<?php
session_start();
if(count($_POST) == 3){
	if($_POST["passwordOld"] != "" && $_POST["passwordNew"] != "" && $_POST["passwordNewR"] != ""){
		if($_POST["passwordNew"] != $_POST["passwordNewR"]){
			echo "Password not matching";
		}
		else{
			require_once("database/join.php");

			$pdo = dbConnect();

			$sqlUpdate = 'UPDATE employee SET password="'.password_hash($_POST["passwordNew"],PASSWORD_BCRYPT).'" WHERE `login` LIKE "'.$_SESSION["username"].'"';
			$stmt = $pdo->query($sqlUpdate);
			$_SESSION = [];

			session_destroy();
			
			echo "Password changed <a href='/index.php'>Click here to login again</a>";
		}
	}
	else {
		echo "Fill all!";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<title>Change password</title>
</head>
<body class='container'>
<form class='form-label' action="/changePassword.php" method="POST">

<label for="passwordOld">Current password:</label>
<input class="form-control" type="password" id="passwordOld" name="passwordOld"><br>

<label for="passwordNew">New password:</label>
<input class="form-control" type="password" id="passwordNew" name="passwordNew"><br>

<label for="passwordNewR">Repeat password:</label>
<input class="form-control" type="password" id="passwordNewR" name="passwordNewR"><br>

<input type="submit" value="Change password" class='btn btn-primary'>
</form>
</body>
</html>
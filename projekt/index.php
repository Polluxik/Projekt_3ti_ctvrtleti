<?php
session_start();
if(array_key_exists("username",$_POST)){
	require_once("database/join.php");

	$pdo = dbConnect();

	$sqlSelect = 'SELECT * FROM employee WHERE `login` LIKE "'.$_POST["username"].'"';
	$stmt = $pdo->query($sqlSelect);

	if ($stmt->rowCount() == 0){
		echo "Username not found!";
	}
	else{
		while ($row = $stmt->fetch()) {
			if(password_verify($_POST["password"],$row["password"])){
				$_SESSION["username"] = $row["login"];
				$_SESSION["admin"] = $row["admin"];
				header("Location: /rozcestnik.php");
				die();
			}
			else {
				echo "Wrong Password!";
			}
		}
	}
}
else {
	$_SESSION = [];
	session_destroy();
}?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UaTF-8">
<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body class='container'>
<br>
<form class='form-label' action="/index.php" method="POST">

<label for="username">Username:</label>
<input class="form-control" type="text" id="username" name="username"><br>

<label for="password">Password:</label>
<input class="form-control" type="password" id="password" name="password"><br>

<input type="submit" value="Login" class='btn btn-primary'>
</form>
</body>
</html>
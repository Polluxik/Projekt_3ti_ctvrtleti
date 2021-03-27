<?php
session_start();
if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){
	header("Location: /rozcestnik.php");
	die();
}
else{
	if(count($_POST) != 0){
		require_once("database/join.php");

		$pdo = dbConnect();
		
		if($_POST["name"] != "" && $_POST["no"] != "" && $_POST["phone"] != "")
		{
			$sqlInsert = 'INSERT INTO `room`(`name`, `no`, `phone`) VALUES ("'.$_POST["name"].'", "'.$_POST["no"].'", "'.$_POST["phone"].'")';
			$stmt = $pdo->query($sqlInsert);
			unset($stmt);
			
			echo "Changes saved <a href='/mistnosti.php'>Go back</a>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<title>Create room</title>
</head>
<body class='container'>
<form class='form-label' action="/createMistnost.php" method="POST">

<label for="name">Name:</label><br>
<input class="form-control" type="text" id="name" name="name"><br>

<label for="no">Number:</label><br>
<input class="form-control" type="number" id="no" name="no"><br>

<label for="phone">Phone:</label><br>
<input class="form-control" type="number" id="phone" name="phone"><br>

<input type="submit" value="Create" class='btn btn-primary'>
</form>
</body>
</html>
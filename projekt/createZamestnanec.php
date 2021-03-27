<?php
require_once("database/join.php");
$pdo = dbConnect();

session_start();
if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){
	header("Location: /rozcestnik.php");
	die();
}
else{
	if(count($_POST) != 0){
		if($_POST["name"] != "" && $_POST["surname"] != "" && $_POST["employment"] != "" && $_POST["pay"] != "" && $_POST["username"] != "" && $_POST["password"] != ""){
           
			$admin = $_POST["admin"] ?? 0;
            $sqlInsert = 'INSERT INTO `employee`(`name`, `surname`, `job`, `wage`, `room`, `login`, `password`, `admin`) VALUES ("'.$_POST["name"].'", "'.$_POST["surname"].'", "'.$_POST["employment"].'", "'.$_POST["pay"].'","'.$_POST["room"].'", "'.$_POST["username"].'", "'.$_POST["password"].'", "'.$admin.'")';
			$stmt = $pdo->query($sqlInsert);
			unset($stmt);
			
			$sqlSelect = 'SELECT * from employee ORDER BY employee_id DESC';
			$stmt = $pdo->query($sqlSelect);
			$emplID = $stmt->fetch();
			unset($stmt);

			foreach ($_POST["keys"] as $roomIDKey){ 
				$sqlInsert = 'INSERT INTO `key` (`employee`, `room`) VALUES ("'.array_values($emplID)[0].'", "'.$roomIDKey.'")';
				$stmt = $pdo->query($sqlInsert);
				unset($stmt);
			}
			echo "Changes saved <a href='/zamestnanci.php'>Go back</a>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<meta charset="UTF-8">

<title>Create employee</title>
</head>
<body class='container'>
<form class='form-label'action="/createZamestnanec.php" method="POST">

<label for="username">Login:</label><br>
<input class='form-control'type="text" id="username" name="username"><br>

<label for="password">Password:</label><br>
<input class='form-control'type="password" id="password" name="password"><br>

<label for="admin">Admin:</label>
<input class='form-control'type="checkbox" value="1" id="admin" name="admin"><br><br>

<label for="name">Name:</label><br>
<input class='form-control'type="text" id="name" name="name"><br>

<label for="surname">Surname:</label><br>
<input class='form-control'type="text" id="surname" name="surname"><br>

<label for="employment">Employment:</label><br>
<input class='form-control'type="text" id="employment" name="employment"><br>

<label for="pay">Payment:</label><br>
<input class='form-control'type="number" id="pay" name="pay"><br>

<label for="room">Room:</label><br>
<select id="room" name="room">

<?php
$sqlSelect = 'SELECT * FROM room ORDER BY name';
$stmt = $pdo->query($sqlSelect);
if ($stmt->rowCount() == 0)
{
	echo "Error | No data";
}
else
{
	$html = "";
	while ($row = $stmt->fetch()) {
		$html .= '<option value="'.$row["room_id"].'">'.$row["name"].'</option>';
	}
	echo $html;
}
unset($stmt);
?>
</select></br>

<p>Keys:</p>
<?php
$sqlSelect = 'SELECT * FROM room ORDER BY name';
$stmt = $pdo->query($sqlSelect);
if ($stmt->rowCount() == 0)
{
	echo "Error | No data";
}
else
{
	$html = "";
	while ($row = $stmt->fetch()) {
		$html .= '<label>'.$row["name"].'<input type="checkbox" name="keys[]" value="'.$row["room_id"].'"></label><br>';
	}
	echo $html;
}
unset($stmt);
?>

<input type="submit" value="Create" class='btn btn-primary'>
</form>
</body>
</html>
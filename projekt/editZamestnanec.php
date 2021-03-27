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
		if($_POST["name"] != ""){
			$sqlUpdate = 'UPDATE employee SET name="'.$_POST["name"].'" WHERE `employee_id` LIKE "'.$_GET["employeeID"].'"';
			$stmt = $pdo->query($sqlUpdate);
			unset($stmt);
		}
		if($_POST["surname"] != ""){
			$sqlUpdate = 'UPDATE employee SET surname="'.$_POST["surname"].'" WHERE `employee_id` LIKE "'.$_GET["employeeID"].'"';
			$stmt = $pdo->query($sqlUpdate);
			unset($stmt);
		}
		if($_POST["empl"] != ""){
			$sqlUpdate = 'UPDATE employee SET job="'.$_POST["empl"].'" WHERE `employee_id` LIKE "'.$_GET["employeeID"].'"';
			$stmt = $pdo->query($sqlUpdate);
			unset($stmt);
		}
		if($_POST["pay"] != ""){
			$sqlUpdate = 'UPDATE employee SET wage="'.$_POST["pay"].'" WHERE `employee_id` LIKE "'.$_GET["employeeID"].'"';
			$stmt = $pdo->query($sqlUpdate);
			unset($stmt);
		}
		$sqlUpdate = 'UPDATE employee SET room="'.$_POST["room"].'" WHERE `employee_id` LIKE "'.$_GET["employeeID"].'"';
		$stmt = $pdo->query($sqlUpdate);
		unset($stmt);
		
		$sqlDelete = 'DELETE FROM `key` WHERE `key`.`employee` = '.$_GET["employeeID"];
		$stmt = $pdo->query($sqlDelete);
		unset($stmt);
		foreach ($_POST["keys"] as $roomKey){ 
			$sqlInsert = 'INSERT INTO `key` (`employee`, `room`) VALUES ("'.$_GET["employeeID"].'", "'.$roomKey.'")';
			$stmt = $pdo->query($sqlInsert);
			unset($stmt);
		}
		
		echo "Changes saved <a href='/zamestnanci.php'>Go back</a>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<title>Edit employee</title>
</head>
<body class='container'>
<form class='form-label' action="/editZamestnanec.php?employeeID=<?php 
echo $_GET["employeeID"];
?>" method="POST">

<label for="name">Name:</label><br>
<input class='form-control'type="text" id="name" name="name"><br>

<label for="surname">Surname:</label><br>
<input class='form-control'type="text" id="surname" name="surname"><br>

<label for="empl">Employment:</label><br>
<input class='form-control'type="text" id="empl" name="empl"><br>

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
</select>
</br>

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

<input type="submit" value="Change" class='btn btn-primary'>
</form>
</body>
</html>
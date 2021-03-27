<?php
session_start();
if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){
	header("Location: /rozcestnik.php");
	die();
}
else{
	require_once("database/join.php");
	$pdo = dbConnect();

	$sqlSelect = 'SELECT * FROM `employee` WHERE `employee`.`room` = '.$_GET["roomID"];
	$stmt = $pdo->query($sqlSelect);
	if ($stmt->rowCount() == 0)
	{
		unset($stmt);
		$sqlDelete = 'DELETE FROM `key` WHERE `key`.`room` = '.$_GET["roomID"];
		$stmt = $pdo->query($sqlDelete);
		unset($stmt);
		
		$sqlDelete = 'DELETE FROM `room` WHERE `room`.`room_id` = '.$_GET["roomID"];
		$stmt = $pdo->query($sqlDelete);

		echo "Room deleted <a href='/mistnosti.php'>Go back</a>";
	}
	else{
		echo "Error <a href='/mistnosti.php'>Go back</a>";
	}

}
?>
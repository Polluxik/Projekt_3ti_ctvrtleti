<?php
session_start();
if(!array_key_exists("username", $_SESSION) || $_SESSION["admin"] != 1){
	header("Location: /rozcestnik.php");
	die();
}
else{
	require_once("database/join.php");
	$pdo = dbConnect();
	
	$sqlDelete = 'DELETE FROM `key` WHERE `key`.`employee` = '.$_GET["employeeID"];
	$stmt = $pdo->query($sqlDelete);
	unset($stmt);
	
	$sqlDelete = 'DELETE FROM `employee` WHERE `employee`.`employee_id` = '.$_GET["employeeID"];
	$stmt = $pdo->query($sqlDelete);


	
	echo "User deleted <a href='/zamestnanci.php'>Go Back</a>";
}
?>
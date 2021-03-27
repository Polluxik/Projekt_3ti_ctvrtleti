<?php require_once("database/join.php");
session_start();
if(!array_key_exists("username", $_SESSION)){
	header("Location: /index.php");
	die();
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body class="container">
<?php

$pdo = dbConnect();

$employeeID = filter_input(INPUT_GET,'employeeID', FILTER_VALIDATE_INT);

$html = "";

$stmt = $pdo->query("SELECT `employee_id`, `surname`, `employee`.`name`, `job`, `wage`,`room_id`, `room`.`name` AS `room_name` FROM `employee`, `room` WHERE `employee_id`= $employeeID AND `room` = `room_id`");

foreach ($stmt as $row){
    $html = "<title>".$row['surname']." ".$row['name']."</title><h1>Zaměstnanec: ".$row['name']." ".$row['surname']."</h1><dl class='dl-horizontal'><dt>Jméno</dt><dd>".$row['name']."</dd><dt>Příjmení</dt><dd>".$row['surname']."</dd><dt>Pozice</dt><dd>".$row['job']."</dd><dt>Plat</dt><dd>".$row['wage']."</dd><dt>Místnost</dt><a href='mistnost.php?roomID=".$row['room_id']."'><dd>".$row['room_name']."</dd></a>";
}

$stmt = $pdo->query("SELECT `employee`, `name`, `room_id`, `employee` FROM `key`, `room` WHERE `employee` = $employeeID AND `room` = `room_id`");
$html .= "<dt>Klíče</dt>";

foreach ($stmt as $row){
    $html .= "<a href='mistnost.php?roomID=".$row['room_id']."'><dd>".$row['name']."</dd></a>";
}
$html .= "</dl><a href='mistnosti.php'>Seznam místností</a><br><a href='rozcestnik.php'>Rozcestník</a>";
    echo $html;
unset($stmt);
?>
</body>
</html>

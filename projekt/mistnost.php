<?php require_once("database/join.php");?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Místnost</title>
</head>
<body class="container">
<?php
$pdo = dbConnect();

$roomID = filter_input(INPUT_GET, 'roomID', FILTER_VALIDATE_INT);

$stmt = $pdo->query("SELECT * FROM `room` WHERE `room_id` = $roomID");
$html = "";
if ($stmt->rowCount() == 0) {
    echo "Chybí data!";
}
else {
    foreach ($stmt as $row) {
        $html .= "<title>".$row['name']."</title><h1>Místnost č. ".$row['no']."</h1><dl class='dl-horizontal'><dt>Číslo</dt><dd>".$row['no']."</dd><dt>Název</dt><dd>".$row['name']."</dd><dt>Telefon</dt><dd>".$row['phone']."</dd>";
    }
$html .= "<dt>Zaměstnanci</dt>";
$stmt = $pdo->query("SELECT * FROM `employee` WHERE `room` = $roomID");
if ($stmt->rowCount() == 0) {
    $html .= "<dd></dd> ";
}
else {
    foreach ($stmt as $row) {
        $html .= "<a href='zamestnanec.php?employeeID=".$row['employee_id']."'><dd>".$row['surname']." ".$row['name']."</dd></a>";
    }
}

$stmt = $pdo->query("SELECT `employee`, `name`, `surname`, `employee_id`, `key`.`room` FROM `key`, `employee` WHERE `key`.`room` = $roomID AND `employee` = `employee_id`;");

$html .= "<dt>Klíče</dt>";
foreach ($stmt as $row){
    $html .= "<a href='zamestnanec.php?employeeID=".$row['employee_id']."'><dd>".$row['surname']." ".$row['name']."</dd></a>";
}
}

$html .= "</dl><a href='mistnosti.php'>Seznam místností</a><br><a href='rozcestnik.php'>Rozcestník</a>";
echo $html;
unset($stmt);
?>
</body>
</html>

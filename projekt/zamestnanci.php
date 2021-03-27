<?php
require_once("database/join.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Zaměstnanci</title>
</head>
<body class = "container">
<?php

$pdo = dbConnect();
$stmt = $pdo->query("SELECT `employee_id`, `surname`, `employee`.`name`, `phone`, `job`, `room`.`name` AS `room_name` FROM `employee`, `room` WHERE `room_id`= `employee`.`room`");
$sort = (int) ($_GET["sort"] ?? 0);

$SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room';
if (isset($sort) && $sort != 0) {
    if ($sort == 1){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY name DESC';
    }
    else if ($sort == 2){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY room_name';
    }
    else if ($sort == 3){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY room_name DESC';
    }
    else if ($sort == 4){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY phone';
    }
    else if ($sort == 5){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY phone DESC';
    }
    else if ($sort == 6){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY job';
    }
    else if ($sort == 7){
        $SQLSort = 'SELECT employee.employee_id, employee.name, employee.surname, employee.job, room.name AS room_name, room.phone FROM employee, room WHERE room.room_id = employee.room ORDER BY job DESC';
    }
}

$stmt = $pdo->query($SQLSort);

if ($stmt->rowCount() == 0) {
    echo "Chybí data!";
}
else{
    $html = "<table class = 'table'>";
    $html .= "<thead>";
    $html .= "<th>Jméno a příjmení <a href=zamestnanci.php?sort=0><</a> <a href=zamestnanci.php?sort=1>></a></th>";
    $html .= "<th>Práce <a href=zamestnanci.php?sort=2><</a> <a href=zamestnanci.php?sort=3>></a></th>";
    $html .= "<th>Místnost <a href=zamestnanci.php?sort=4><</a> <a href=zamestnanci.php?sort=5>></a></th>";
    $html .= "<th>Telefon <a href=zamestnanci.php?sort=6><</a> <a href=zamestnanci.php?sort=7>></a></th>";

    $html .= "</thead>";

    $html .= "<tbody>";

    foreach ($stmt as $row) {
        $html .= "<tr>
            <td><a href='zamestnanec.php?employeeID=".$row['employee_id']."'>".$row['surname']." ".$row['name']."</a></td><td>".$row['job']."</td><td>".$row['room_name']."</td><td>".$row['phone']."</td><td><a href='/editZamestnanec.php?employeeID=".$row['employee_id']."'>Editovat</a></td><td><a href='/deleteZamestnanec.php?employeeID=".$row['employee_id']."'>Smazat</a></td></tr>";
    }
    $html .= "</table></dl><a href='mistnosti.php'>Seznam místností</a><br><a href='rozcestnik.php'>Rozcestník</a><br><a href='createZamestnanec.php'>Pridat zamestnance</a>";
    echo $html;
}
unset($html);
?>
</body>
</html>

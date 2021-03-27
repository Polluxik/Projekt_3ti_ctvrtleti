<?php require_once("database/join.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Místnosti</title>
</head>
<body class = "container">
<?php
$pdo = dbConnect();
$stmt = $pdo->query('SELECT * FROM room');
$sort = (int) ($_GET["sort"] ?? 0);

$SQLSort = 'SELECT * FROM room ORDER BY name';
if (isset($sort) && $sort != 0) {
    if ($sort == 1){
        $SQLSort = 'SELECT * FROM room ORDER BY name DESC';
    }
    else if ($sort == 2){
        $SQLSort = 'SELECT * FROM room ORDER BY no';
    }
    else if ($sort == 3){
        $SQLSort = 'SELECT * FROM room ORDER BY no DESC';
    }
    else if ($sort == 4){
        $SQLSort = 'SELECT * FROM room ORDER BY phone';
    }
    else if ($sort == 5){
        $SQLSort = 'SELECT * FROM room ORDER BY phone DESC';
    }
}

$stmt = $pdo->query($SQLSort);


if($stmt->rowCount() == 0){
    echo "Chybí data!";
}
else{
    $html = "<table class = 'table'>";
    $html .= "<thead>";
    $html .= "<th>Název místnosti <a href=mistnosti.php?sort=0><</a> <a href=mistnosti.php?sort=1>></a></th>";
    $html .= "<th>Číslo <a href=mistnosti.php?sort=2><</a> <a href=mistnosti.php?sort=3>></a></th>";
    $html .= "<th>Telefon <a href=mistnosti.php?sort=4><</a> <a href=mistnosti.php?sort=5>></a></th>";
    $html .= "</thead>";
    $html .= "<tbody>";

    foreach ($stmt as $row) {
        $html .= "<tr><td><a href='mistnost.php?roomID=".$row['room_id']."'>".$row['name']."</a></td><td>".$row['no']."</td><td>".$row['phone']."</td><td><a href='/editMistnost.php?roomID=".$row['room_id']."'>Editovat</a></td><td><a href='/deleteMistnost.php?roomID=".$row['room_id']."'>Smazat</a></td></tr>";
    }
    $html .= "</table></dl><a href='zamestnanci.php'>Seznam zaměstnanců</a><br><a href='rozcestnik.php'>Rozcestník</a><br><a href='createMistnost.php'>Vytvorit mistnost</a>";

    echo $html;
}
unset($html);
?>
</body>
</html>

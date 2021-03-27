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
        
        if($_POST["name"] != ""){
            $sqlUpdate = 'UPDATE room SET name="'.$_POST["name"].'" WHERE `room_id` LIKE "'.$_GET["roomID"].'"';
            $stmt = $pdo->query($sqlUpdate);
            unset($stmt);
        }
        if($_POST["number"] != ""){
            $sqlUpdate = 'UPDATE room SET no="'.$_POST["number"].'" WHERE `room_id` LIKE "'.$_GET["roomID"].'"';
            $stmt = $pdo->query($sqlUpdate);
            unset($stmt);
        }
        
        if($_POST["phone"] != ""){
            $sqlUpdate = 'UPDATE room SET phone="'.$_POST["phone"].'" WHERE `room_id` LIKE "'.$_GET["roomID"].'"';
            $stmt = $pdo->query($sqlUpdate);
            unset($stmt);
        }
        
        echo "Changes saved <a href='/mistnosti.php'>Go back</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<title>Edit room</title>
</head>
<body class='container'>

<form class='form-label' action="/editMistnost.php?roomID=
<?php
echo $_GET["roomID"];
?>" method="POST">

<label for="name">Room name: </label><br>
<input class='form-control'type="text" id="name" name="name"><br>

<label for="number">Number:</label><br>
<input class='form-control'type="number" id="number" name="number"><br>

<label for="phone">Phone number:</label><br>
<input class='form-control'type="number" id="phone" name="phone"><br>

<input type="submit" value="Change" class='btn btn-primary'>
</form>
</body>
</html>
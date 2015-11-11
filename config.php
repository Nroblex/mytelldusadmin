<!DOCTYPE HTML>
<html>
<title>Administrera Mytelldus</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="telldus.js"></script>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="outer">	
		
<?php
	
/**
* Läser ur sqlite databasen
*/
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off

include 'tables.php';

$db = new MyDB();
$tables = new CreateTables();

if (!$db){
	echo $db->lastErrorMsg();
} 

$sql = "SELECT * from timeschema";

echo $tables->configTable($sql);


$returnValue = $db->query($sql);
	while ($row=$returnValue->fetchArray(SQLITE3_ASSOC)){
		echo "ID = ".$row['ID'] . "<br>";
		echo "DeviceID = " .$row['deviceID'] . "<br>";
		echo "TimePoint = " .$row['timePoint'] . "<br>";
		echo "Action = " .$row['action'] . "<br>";

		echo "<br>";
	}


$db->close();

?>
<div id="TextBoxesGroup">
		<div id="TextBoxDiv1" >
			<label>TextBox #1: </label><input type="hidden" id="textbox1" >
		</div>
	</div>

	<input type='button' value='Add Button' id='addButton'>
	<input type='button' value='Remove Button' id='removeButton'>
	<input type='button' value='Get TextBox Value' id='getButtonValue'>
	</div>
</body>

</html>
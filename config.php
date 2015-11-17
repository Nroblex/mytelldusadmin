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

$tables = new CreateTables();


$sql = "SELECT * FROM devices d INNER JOIN timeschema t ON d.DeviceId = t.DeviceId ";

echo $tables->configTable($sql);

?>
</body>

<div id ="configDiv" width="100%">
	<input type="button" id="addRow" value="ny rad" name="addRow" />
</div>

</html>
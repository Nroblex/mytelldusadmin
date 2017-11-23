<?php
	

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');  //On or Off

	include 'tables.php';

	$delId = $_GET['deleteID'];

	$tables = new CreateTables();
	$tables ->deleteRecord($delId);


?>
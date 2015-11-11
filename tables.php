<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');  //On or Off

	class MyDB extends SQLite3 {
		
		function __construct(){
			$this->open('configdb.db');
		}
	}

	class CreateTables {

		$html = "<table id='topTable' width='100px' border='0' cellpadding='0'  align='center' caption='år'>"

		$db = new MyDB();

		function configTable($sql) {
			$returnValue = $db->query($sql);
				while ($row=$returnValue->fetchArray(SQLITE3_ASSOC)){
					$html = $html . "<tr>";
					$html = $html . "<td>" .$row['ID'] ."</td>";
					$html = $html . "<td>" .$row['deviceID'] ."</td>";
					$html = $html . "<td>" .$row['timePoint'] ."</td>";
					$html = $html . "<td>" .$row['action'] ."</td>";

					$html = $html . "</tr>";
				}

			$html = $html . "</table>";

			$db->close();

			

			return $html;
		}

	}

	
	
?>
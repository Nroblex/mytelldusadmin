<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');  //On or Off

	class MyDB extends SQLite3 {
		
		function __construct(){
			$this->open('configdb.db');
		}
	}

	class CreateTables {

		function configTable($sql) {

			$db = new MyDB();
			$html = "<table id='topTable' width='500px' border='0' cellpadding='0' align='center' caption='schema'>";
			$html = $html . "<th>DeviceID</th>";
			$html = $html . "<th>Namn</th>";
			$html = $html . "<th>Tidpunkt</th>";
			$html = $html . "<th>Händelse</th>";
			$html = $html . "<th>Veckodag</th>";

			$returnValue = $db->query($sql);
				while ($row=$returnValue->fetchArray(SQLITE3_ASSOC)){
					$html = $html . "<tr>";
			
					$html = $html . "<td>" .$row['deviceID'] ."</td>";
					$html = $html . "<td>" .$row['deviceName'] ."</td>";
					$html = $html . "<td>" .$row['timePoint'] ."</td>";
					$html = $html . "<td>" .$row['action'] ."</td>";
					$html = $html . "<td>" .$row['dayofweek'] ."</td>";

					$html = $html . "</tr>";
				}

			$html = $html . "</table>";

			$db->close();

			

			return $html;
		}

	}

	
	
?>
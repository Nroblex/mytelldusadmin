<?php

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'On');  //On or Off

	session_start();

	class MyDB extends SQLite3 {
		
		function __construct(){
			$this->open('configdb/configdb.db');
		}
	}

	function writeConfig() {
		echo "Writing...";
	}

	class CreateTables {

		function readDevices($sql){
			$db= new MyDB();
			$htm = "<table id='deviceTable' border='0' cellpadding='0' align='left' caption='devices'>";
			$htm = $htm . "<th>Namn</th>";
			$htm = $htm . "<th>Beskr</th>";

			$retValue = $db->query($sql);
			while ($row = $retValue->fetchArray(SQLITE3_ASSOC))  {
				$htm = $htm . "<tr align='center'>";
				$htm = $htm . "<td>" .$row['deviceID'] ."</td>";
				$htm = $htm . "<td>" .$row['deviceType'] ."</td>";
			}

			$htm = $htm . "</table>";
			$db->close();

			return $htm;

		}

		function readTimeSchema($sql) {

			$db = new MyDB();
			$html = "<table id='topTable' width='100%' border='0' cellpadding='0' align='left' caption='schema'>";
			$html = $html . "<th>DeviceID</th>";
			$html = $html . "<th>Namn</th>";
			$html = $html . "<th>Tidpunkt</th>";
			$html = $html . "<th>Händelse</th>";
			$html = $html . "<th>Veckodag</th>";

			$returnValue = $db->query($sql);
				while ($row=$returnValue->fetchArray(SQLITE3_ASSOC)){
					$html = $html . "<tr align='center'>";
			
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

		function createSelectDevices() {
			//this.form.submit()
			$db  = new MyDB();
			$html = "<div id='mainDiv' align='center'>";
			$html = $html . "<form method='POST' action=''>";
			$html = $html . "<select id='selDevice' name='deviceOption' onchange=this.form.submit();>";

			$retValue = $db->query("SELECT * FROM devices order by deviceName");

			$i=0;
			$html = $html . "<option value='0'>--Välj nedan--</option>";
			while ($row = $retValue->fetchArray(SQLITE3_ASSOC)){
				$i++;
				$html = $html . "<option value=" . $row['deviceID'] . ">" . $row['deviceName'] . "</option>";
			}
			$html = $html . "</select>";
			$html = $html . "</form>";
			$html = $html . "</div>";
			$html = $html . "<br><br><hr>";

			$db->close();
			return $html;
		}

		function createWeekLayOut($deviceId){

			$html = "";
			if ($deviceId == null){
				$html = "<div id='noSelectionDiv' align='center>";
				$html = $html . "<p> Välj enhet i listan </p>";
				$html = $html . "</div>";

				return $html;
			}
			
			$db = new MyDB();

			$cnt = 1;

			
			$dowMap = array('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');
			$actionMap = array('ON', 'OFF');

			while ($cnt < 8){
				$sql = "SELECT * FROM timeschema where deviceId = '$deviceId'";
				$html = $html . "<table id='table_$cnt' align='center'>";
				
				$html = $html . "<th>" . $dowMap[$cnt -1] .  "</th>";
				$sql = $sql . " and dayofweek = '" . $cnt . "'";
				$sql = $sql . " ORDER BY timePoint DESC; ";

				echo $sql;

				$retValue = $db->query($sql);

				$html = $html . "<table id='detailsTable_" . $cnt . "' align='center' >";
				$html = $html . "<th>Tidpunkt</th><th>Händelse</th>";

				$rowCnt=1;
				while ($row = $retValue->fetchArray(SQLITE3_ASSOC)){

					$html = $html . "<tr>";
					$html = $html . "<td>" . $row['timePoint'] . "</td>";
					$html = $html . "<td>" . $actionMap[$row['action']] . "</td>";
					$html = $html . "<td><button type='button' onClick='deleteRecord(" . $row['ID'] . ");'>Radera</button></td>";
					//$html = $html . "<td><button type='button' onClick='deleteRecord('". $row['ID'] . "')';>Radera</button></td>";
					//$html = $html . "<td><a href =" . $_SERVER['PHP_SELF']. "?deleteId=" .$row['ID'] . ">Delete</a></td>";
					$html = $html . "</tr>";

					$rowCnt++;
				}
	
				$html = $html . "</table><br>";
				$cnt++;
			}
			
			return $html;

		}

		function saveNewRecord($deviceId, $timePoint, $weekDay, $action){

			$db  = new MyDB();
			if (!$db){
				echo $db -> lastErrorMsg();
			}

			if (!isset($deviceId) || !isset($timePoint)){
				return;
			}

			if (strlen($timePoint) == 0){
				return;
			}

			$sql = " INSERT INTO timeschema(deviceId, timePoint, action, dayofweek) ";
			$sql = $sql . " VALUES ('" . $deviceId . "', '" . $timePoint . "','" . $action . "','" . $weekDay . "')";

			$ret = $db->exec($sql);

			$db->close();

			//return createWeekLayOut($deviceId);

		}

		function deleteRecord($ID){
			$db = new MyDB();
			$sql = "DELETE from timeschema WHERE ID = '$ID'";
			$ret = $db->exec($sql);
			$db->close();

			header('Location: http://localhost:8080/mytelldusadmin/add.php');

		}

	}

	
	
?>
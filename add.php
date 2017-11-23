<!DOCTYPE html>
<?php
	ini_set('display_startup_errors',1); 
	ini_set('display_errors',1);
	error_reporting(-1);

	include 'tables.php'; 
	
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

?>
<html>
	<title>Ny tidpunkt</title>
	<head>
		<meta charset="UTF-8">
	</head>
	
	<style>
		table, td{
			border: 1px solid black;
		}
		#Monday {
			width: 75%;
		}
		#Tuesday{
			width: 75%
		}
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">

		function getMe(){
			document.write('hello');
		}
		function deleteRecord(deleteID){
			//alert('delete' + deleteID);
			window.location.href="delete.php?deleteID=" + deleteID;
		}
		function callWrite(){
			$.ajax({
				url: "writexml.php",
				type: 'post',
    			data: { "executeXML": "configdb/xmldata.xml"},
    			success: function(response) { 
    				alert('Filen skrevs!');
    			}
				
			});
		}
	</script>

	<body>

		<?php 
			
			$tables = new CreateTables();

			echo $tables -> createSelectDevices();

			if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){ //Denna sker efter postback!
				


				if (isset($_POST['deviceOption'])){

					$deviceOption = $_POST['deviceOption'];	
					$_SESSION['deviceID'] = $deviceOption;
					echo $tables ->createWeekLayOut($deviceOption);

				}

				if (isset($_POST['btnNew'])){ //Vi inte tryckt på spara knappen!
					
					$timepoint = $_POST['timepoint'];
    				$weekday = $_POST['weekdays'];
    				$action = $_POST['switch'];

    				$_SESSION['weekday'] = $weekday;
    				$_SESSION['timepoint'] = $timepoint;

    				echo "timepoint - > " . $timepoint ;
    				echo "weekday -> " . $weekday;
    				echo "action -> " . $action;

    				echo "deviceId Was -> " . $_SESSION['deviceID'];
    				//echo "SAVING DATA!";
					$tables->saveNewRecord($_SESSION['deviceID'], $timepoint, $weekday, $action);
					echo $tables ->createWeekLayOut($_SESSION['deviceID']);


				} else {
					//Vi har tryckt på sparaknappen!!!

				}
				

			} else {
				echo $tables ->createWeekLayOut('0');
			}
			

			
		?>


		<?php 
			if (isset($_POST['btnNew'])) {

    			
  			}
  		
		?>

		<div id="inputdiv" align="center">
		<label id"lblInput">Spara ny tidpunkt</label>
		<form action="" id="inputForm" method="POST">
			<table id="inputTable" align="center">
				
				<th>Tidpunkt</th>
				<th>Händelse</th>
				<th>Veckodag</th>
				<tr>
					
					<td><input type="text" style="text-align:center" id="timepoint" name="timepoint"></input></td>
					<td>
						<select name="weekdays">
							<option value="1">Måndag</option>
							<option value="2">Tisdag</option>
							<option value="3">Onsdag</option>
							<option value="4">Torsdag</option>
							<option value="5">Fredag</option>
							<option value="6">Lördag</option>
							<option value="7">Söndag</option>
						</select>
					</td>
					<td>
						<select name="switch">
							<option value="0">ON</option>
							<option value="1">OFF</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"><input id="btnNew" name="btnNew" type="submit" value="spara ny" form="inputForm"></input></td>
				</tr>
				
			</table>
		</form>

		<button id="writeConfig" name="writeConfig" onclick="callWrite();">Skriv konfig!</button>

		</div>
	</body>

</html>

<?php 

	function writeXml($data){
	  	//file_put_contents($data, "\nAnders olof Selborn\n");
        doWrite($data);
        return "file: " + $data + " was written!";
    }

    if (isset($_POST['executeXML'])) {
    	writeXml($_POST['executeXML']);
        //echo writeXml($_POST['callFunc1']);
    }

	class MyDB extends SQLite3 {
		
		function __construct(){
			$this->open('configdb/configdb.db');
		}

	}
	function doWrite($fileName) {
		unlink($fileName);

		$db=new MyDB();

		$dataString = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>" . PHP_EOL;
		$dataString = $dataString . "<devices>" . PHP_EOL;

		$weekMap = array('Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag', 'Söndag');
		$onOfMap = array('ON', 'OFF');

		$sql = "SELECT * FROM timeschema t INNER JOIN devices d on d.deviceID = t.deviceID Order by t.deviceId, t.dayofweek";
		$retValue = $db->query($sql);

		$cntDevice = 0;
		$tmpString = "";
		while ($row = $retValue->fetchArray(SQLITE3_ASSOC)){

			if ($cntDevice == 0){
				$tmpString = PHP_EOL;
				$tmpString = $tmpString . "<!-- Config för " . $row['deviceName'] . " -->" . PHP_EOL;
				$dataString = $dataString . $tmpString;
				$cntDevice = $row['deviceID'];				
			}


			if ($row['deviceID'] != $cntDevice){
				 $cntDevice=0;
			}
			

			$dataString =$dataString . "	<device deviceId='" . $row['deviceID'] . "' weekday='" . $weekMap[$row['dayofweek'] -1] . "'>" . PHP_EOL;
			$dataString = $dataString . "		<id>" . $row['ID'] . "</id>" . PHP_EOL;
			$dataString = $dataString . "		<timepoint>" . $row['timePoint'] . "</timepoint>" . PHP_EOL;
			$dataString = $dataString . " 		<action>" . $onOfMap[$row['action']] . "</action>" . PHP_EOL;
			$dataString = $dataString . "	</device>" . PHP_EOL;

		}

		$dataString = $dataString . "</devices>" . PHP_EOL;
		file_put_contents($fileName, $dataString, FILE_APPEND);

		//scp 
		//$connection = ssh2_connect('10.0.1.48', 22);
		//ssh2_auth_password($connection, "pi", "lytill53");
		//ssh2_scp_send($connection, $fileName, "/home/pi/mytelldus/db/", 0644);
		//ssh2_exec($connection, 'exit');

	  $message=shell_exec("/var/www/html/mytelldusadmin/gossh.sh 2>&1");
      print_r($message);
	}


	
	  
?>
<?php 

	include "sshsend.php";

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

		$sshSender = new SSHFileSender();

		$deviceFileName="configdb/device.xml";

		unlink($fileName);
		unlink($deviceFileName);

		

		$db=new MyDB();


		//writing DeviceConfig.
		$xml = "<?xml version='1.0' encoding='UTF-8' standalone='yes'?>" . PHP_EOL;
		$xml = $xml . "<Devices>". PHP_EOL;



		$select = "select * from devices;";
		$result = $db->query($select);
		$xmldata = "";

		while ($rad = $result->fetchArray(SQLITE3_ASSOC)){

			$xmldata = $xmldata . "\t<DeviceConfig>" . PHP_EOL;
			$xmldata = $xmldata . "\t\t<DeviceName>" . $rad["deviceName"] . "</DeviceName>" . PHP_EOL;
			$xmldata = $xmldata . "\t\t<DeviceId>" . $rad["deviceID"] . "</DeviceId>" . PHP_EOL;
			$xmldata = $xmldata . "\t\t<Comment>" . $rad["deviceType"] . "</Comment>" . PHP_EOL;
			$xmldata = $xmldata . "\t</DeviceConfig>" . PHP_EOL;

		}

		$xmldata = $xmldata . "</Devices>" . PHP_EOL;
		$xml = $xml . $xmldata;

		file_put_contents($deviceFileName, $xml);

		$dstFile="/home/pi/mytelldus/db/device.xml";
		
		$sshSender->sendSSHFile($deviceFileName, $dstFile);

		#writing actual data below
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

		

		$srcFile = $fileName;
		$dstFile = "/home/pi/mytelldus/db/schema.xml";

		$sshSender->sendSSHFile($fileName, $dstFile);

		/*

		//$con = ssh2_connect("10.0.1.48", 22);
		$con = ssh2_connect("192.168.86.39", 22);
		if (!ssh2_auth_password($con, "pi", "lytill53")) {
			die('Auth failed for SSH');
		}
		$sftp = ssh2_sftp($con);

		$sftpStream = @fopen('ssh2.sftp://'.$sftp.$dstFile, 'w');

		try {
			if (!$sftpStream){
				throw new Exception("Could not open remote file", $dstFile);
			}

			$dataToSend = @file_get_contents($fileName);

			if (!$dataToSend){
				throw new Exception("Could not open local file!", $fileName);
			}

			if (@fwrite($sftpStream, $dataToSend) == false){
				throw new Exception("Could not send data from file: $srcFile.");
				
			}

			fclose($sftpStream);

		} catch(Exception $e){
			error_log('Exception: ' . $e->getMessage());
			fclose($sftpStream);
		}

		*/

		//sendFileToRaspberry()


	  //$message=shell_exec("/var/www/html/mytelldusadmin/gossh.sh 2>&1");
      //print_r($message);
	}


function sendFileToRaspberry($fileName, $remoteFileName){





}
	
	  
?>
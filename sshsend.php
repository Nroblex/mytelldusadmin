<?php

	class SSHFileSender
	{

		function sendSSHFile($fileSendFile, $dstFile){


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

				$dataToSend = @file_get_contents($fileSendFile);

				if (!$dataToSend){
					throw new Exception("Could not open local file!", $fileSendFile);
				}

				if (@fwrite($sftpStream, $dataToSend) == false){
					throw new Exception("Could not send data from file: $srcFile.");
				
				}

				fclose($sftpStream);

			} catch(Exception $e){
				error_log('Exception: ' . $e->getMessage());
				fclose($sftpStream);
			}
		}
	}

?>
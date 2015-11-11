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

			$html = "<table id='topTable' width='100px' border='0' cellpadding='0'  align='center' caption='år'>
				<tr>
					<td bgcolor=fff909><a href=?year=2008 /a>2008</td>
					<td bgcolor=fff909><a href=?year=2009 /a>2009</td>
					<td bgcolor=fff909><a href=?year=2010 /a>2010</td>
					<td bgcolor=fff909><a href=?year=2011 /a>2011</td>
					<td bgcolor=fff909><a href=?year=2012 /a>2012</td>
					<td bgcolor=fff909><a href=?year=2013 /a>2013</td>
					<td bgcolor=fff909><a href=?year=2014 /a>2014</td>
					<td bgcolor=fff909><a href=?year=2015 /a>2015</td>
				</tr>
		
				</table>";

			//$db = new MyDB()

			/*
			$returnValue = $db->query($sql);
			while ($row=$returnValue->fetchArray(SQLITE3_ASSOC)){
				echo 'ID = '.$row['ID'] . '<br>';
				echo 'DeviceID = ' .$row['deviceID'] . '<br>';
				echo 'TimePoint = ' .$row['timePoint'] . '<br>';
				echo 'Action = ' .$row['action'] . '<br>';

				echo '<br>';
			}

			*/
			//$db->close();

			return $html;
		}

	}

	
	
?>
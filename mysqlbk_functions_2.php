<?php 
	//Created by Ricky Wang
	function mysqlbackup(){
		ini_set("max_execution_time", "180");
		//Avoiding time out and lose data
		/* 
If you do not want to back up comment out get_table_structure($db, $table, $crlf).";$crlf$crlf"; 
If you do not want to back up comment out get_table_content($db, $table, $crlf); 
*/
		$dbname="ehgp_data";
		$date = date('Y-m-d');
		$timer1 = date("YmdHis");
		$path = "my_sql/";
		$content ="";
		$filename = $path.$dbname.$timer1.".sql";
		$drop = 1;
		//comment this out if you don't want drop table when upload.
		//IF the folder is exists
		
		if(!file_exists($path)){
			//Create the folder if it do not exists, 0777 mean the max permissions
			
			if(mkdir($path,0777)){
			} else {
				return false;
				echo "Can not create folder!";
			}

		}

		//IF the file is exists
		
		if(!file_exists($filename)){
			//Create the file if it do not exists
			fopen($filename,"a+");
			
			if(is_writable($filename)){
				
				if(!$handle =  fopen($filename,"a")){
					return false;
					echo"Can not open the file";
					exit();
				}

			} else {
				return false;
				echo"File:{$filename}

			 Can is not writable";
		}

	} else {
		
		if(!$handle = fopen($filename,"a")){
			return false;
			echo"Can't open file";
			exit();
		}

		fclose($handle);
	}

	
	function get_table_structure($db,$table,$crlf) {
		global $drop;
		$schema_create = "";
		$result = $db->prepare("SHOW CREATE TABLE $table");
		$result->execute();
		$row = $result->fetchall(PDO::FETCH_NUM);
		$schema_create .= $crlf."-- ".$row[0][0].$crlf;
		
		if(!empty($drop)){
			$schema_create .= "DROP TABLE IF EXISTS `$table`;$crlf";
		}

		$schema_create .= $row[0][1].$crlf;
		return $schema_create;
	}

	
	function get_table_content($db, $table, $crlf) {
		$schema_create = "";
		$temp = "";
		$result = $db->prepare("SELECT * FROM $table");
		$result->execute();
		$i = 0;
		while($row = $result->fetch(PDO::FETCH_NUM)) {
			$schema_insert = "INSERT INTO `$table` VALUES (";
			$num_fields = sizeof($row);
			for($j=0; $j<$num_fields;$j++) {
				
				if(!isset($row[$j])) $schema_insert .= " NULL,";
				elseif($row[$j] != "") $schema_insert .= " '".addslashes($row[$j])."',"; else $schema_insert .= " '',";
			}

			$schema_insert = str_replace(",$", "",$schema_insert);
			$schema_insert .= ");$crlf";
			$schema_insert = str_replace(",)", ")",$schema_insert);
			$temp = $temp.$schema_insert ;
			$i++;
		}

		return $temp;
	}

	$i = 0;
	$crlf="\r\n";
	$db = get_database_connection();
	$statement1 = $db->prepare("SET NAMES 'utf8'");
	$statement1->execute();
	$tables =$db->prepare("SHOW TABLES");
	$tables->execute();
	$num_tables = $tables->rowCount();
	$tables = $tables->fetchall();
	$content = "-- filename=".$filename;
	fwrite($handle,$content);
	while($i < $num_tables) {
		$table=$tables[$i][0];
		print $crlf;
		$content = get_table_structure($db, $table, $crlf).";$crlf$crlf";
		fwrite($handle,$content);
		$content = get_table_content($db, $table, $crlf);
		fwrite($handle,$content);
		$i++;
	}

	fclose($handle);
	$db = null;
	return true;
}

?>
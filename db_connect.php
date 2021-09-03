<?php

//$errorlog = 'error_log.txt';
	
$connection = mysqli_connect('localhost','','');
if (!$connection){
	//file_put_contents($errorlog, mysqli_error($connection) . PHP_EOL, FILE_APPEND);
	die("Database Connection Failed".mysqli_error($connection));
}

$select_db = mysqli_select_db($connection, 'bsds');
if (!$select_db){
	//file_put_contents($errorlog, mysqli_error($connection) . PHP_EOL, FILE_APPEND);
	die("Database Selection Failed".mysqli_error($select_db));
}

?>

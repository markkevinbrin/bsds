<?php
require_once('include.php');
use Globe\Connect\Sms;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errorlog = 'error_log_grouptxt.txt';

function initializeDb(){
    
    // Palitan niyo na lang muna manual
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";
    global $env;
    
    switch($env){
        case "development":
            $servername = "localhost";
            $username = "root";
            $password = "1Got1Udont!@";
            $dbname = "bsds";
            break;
        default:
            $servername = "localhost";
            $username = "root";
            $password = "1Got1Udont!@";
            $dbname = "bsds";
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        $arr = array(
            "success"=>false,
            "data"=>"Connection failed: ".$conn->connect_error,
        );
        returnJson($arr);
    }
    
    return $conn;
}


$message = $_POST['message'];

	//$message = "GROUP TEXT MESSAGE TEST PURPOSE NTH EDITION :((";
	$sql = "select subscriberNumber, accessToken from opt_in";
	$conn = initializeDb();
	$results = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_array($results)){
		
		$subscriberNumber = $row['subscriberNumber'];
		$accessToken = $row['accessToken'];
		
		//echo $subscriberNumber;
		//echo $accessToken;
		
			$sms = new Sms('8430', $accessToken);
			
			$sms->setReceiverAddress($subscriberNumber);
			$sms->setMessage($message);
			$sms->setClientCorrelator('12345');
			$sms->sendMessage();
			
		$msgToDB = "INSERT INTO messages(subscriberNumber,destinationAddress, message, senderAddress, isMO) VALUES ('$subscriberNumber','$subscriberNumber','$message','tel:21588430',0);";
				
			//$stmt = $conn->prepare($msgToDB);    
			//$stmt->bind_param("sss",$subscriberNumber,$subscriberNumber,$message);
			//$stmt->execute();
			
			mysqli_query($conn, $msgToDB);
			
		if (!mysqli_query($conn,$sql)){
			//echo "Error description:".mysqli_error($connection);
			file_put_contents($errorlog, mysqli_error($conn) . PHP_EOL, FILE_APPEND);
		}
	}


?>
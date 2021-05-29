<?php

require('db_connect.php');
require_once('include.php');
use Globe\Connect\Sms;
//$getfile='notify_get.txt';
//$postfile='notify_post.txt';
$errorlog = 'error_log.txt';

$date = new DateTime();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	//
	$access_token=$_GET['access_token'];
	$subscriber_number=$_GET['subscriber_number'];

	//file_put_contents($getfile, $date->getTimestamp() . PHP_EOL, FILE_APPEND);
	//file_put_contents($getfile, $access_token . PHP_EOL, FILE_APPEND);
	//file_put_contents($getfile, $subscriber_number . PHP_EOL, FILE_APPEND);
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// receive SMS
	$json = file_get_contents('php://input');
	$data = json_decode($json, true);
	//file_put_contents($postfile, $date->getTimestamp() . PHP_EOL, FILE_APPEND);
	//file_put_contents($postfile, "json:" . $json . PHP_EOL, FILE_APPEND);
	//file_put_contents($postfile, "data:" . $data . PHP_EOL, FILE_APPEND);

	$numberOfMessagesInThisBatch = 	$data['inboundSMSMessageList']['numberOfMessagesInThisBatch'];
	$resourceURL = 			$data['inboundSMSMessageList']['resourceURL'];

        $dateTime = 		$data['inboundSMSMessageList']['inboundSMSMessage'][0]['dateTime'];
        $destinationAddress = 	$data['inboundSMSMessageList']['inboundSMSMessage'][0]['destinationAddress'];
        $messageId = 		$data['inboundSMSMessageList']['inboundSMSMessage'][0]['messageId'];
        $message = 		$data['inboundSMSMessageList']['inboundSMSMessage'][0]['message'];
        $resourceURL = 		$data['inboundSMSMessageList']['inboundSMSMessage'][0]['resourceURL'];
        $senderAddress = 	$data['inboundSMSMessageList']['inboundSMSMessage'][0]['senderAddress'];
	$multipartRefId = 	$data['inboundSMSMessageList']['inboundSMSMessage'][0]['multipartRefId'];
	$multipartSeqNum = 	$data['inboundSMSMessageList']['inboundSMSMessage'][0]['multipartSeqNum'];
	$isMO=1;
	
	

	$subscriberNumber = substr($senderAddress,7);
	//$subscriberNumber = $senderAddress;
	$sql = "INSERT INTO messages (subscriberNumber, dateTime, destinationAddress, messageId, message, resourceURL, senderAddress, multipartRefId, isMO) VALUES 
	('$subscriberNumber', UTC_TIMESTAMP(), '$destinationAddress', '$messageId', '$message', '$resourceURL', '$senderAddress', '$multipartRefId', '$isMO')";
	
	$SQLmessage = "SELECT stored_message FROM keywords WHERE keyword LIKE '$message'";
	$SQLaccesstoken = "SELECT accessToken FROM opt_in WHERE subscriberNumber = '$subscriberNumber'";
	
	if (!mysqli_query($connection,$sql)){
		//echo "Error description:".mysqli_error($connection);
		file_put_contents($errorlog, mysqli_error($connection) . PHP_EOL, FILE_APPEND);
	}
	
	if ($RESULTaccesstoken=mysqli_query($connection,$SQLaccesstoken)){
		$ROWaccesstoken = mysqli_fetch_array($RESULTaccesstoken);
		$accesstoken = $ROWaccesstoken['accessToken'];
		
		if ($RESULTmessage=mysqli_query($connection,$SQLmessage)){	
			if(mysqli_num_rows($RESULTmessage) > 0){
				$ROWmessage = mysqli_fetch_array($RESULTmessage);
				$message = $ROWmessage['stored_message'];
	
				$sms = new Sms('8430', $accesstoken);
				$sms->setReceiverAddress($subscriberNumber);
				$sms->setMessage($message);
				$sms->setClientCorrelator('12345');
				$sms->sendMessage();
				
				$webapp = "INSERT INTO messages (subscriberNumber, destinationAddress, messageId, message, resourceURL, senderAddress, multipartRefId, isMO) VALUES 
				('$subscriberNumber', '$senderAddress', '$messageId', '$message', '$resourceURL', '$destinationAddress', '$multipartRefId', 0)";
				mysqli_query($connection,$webapp);
			}
		}
	}
	
	
		
	/*file_put_contents($postfile, $dateTime . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $destinationAddress . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $messageId . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $message . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $resourceURL . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $senderAddress . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $multipartRefId . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $multipartSeqNum . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $isMO . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $subscriberNumber . PHP_EOL, FILE_APPEND);

	file_put_contents($postfile, $numberOfMessagesInThisBatch . PHP_EOL, FILE_APPEND);
	file_put_contents($postfile, $resourceURL . PHP_EOL, FILE_APPEND);*/
}

?>

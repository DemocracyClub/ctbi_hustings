<?php

$logFile = __DIR__ . DIRECTORY_SEPARATOR . "eventsDone.log";

$postdata = array(
			'action'=> 'searchHustings',
			'constitId'=> 0,
			'constitName'=> '',
		);

$idsDone = array();

foreach(file($logFile) as $line) {
	if (trim($line)) {
		$idsDone[] = intval($line);
	}
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ctbielections.org.uk/wp-admin/admin-ajax.php");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 5.0.1; Nexus 9 Build/LRX22C) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.93 Safari/537.36');
$data = curl_exec($ch);
$response = curl_getinfo( $ch );
curl_close($ch);

if ($response['http_code'] != 200) {
	var_dump($response);
	die("ERROR");
}


$dataObj = json_decode($data);

foreach($dataObj as $hustingJSON) {
	if ($hustingJSON->eventType == 'E') {

		print "ID ".$hustingJSON->id."\n";

		if (in_array($hustingJSON->id, $idsDone)) {

			print "  already done\n";

		} else {

			print "eventTitle: ". $hustingJSON->eventTitle . "\n";
			print "eventDetails: ". $hustingJSON->eventDetails . "\n";
			print "additionalInfo: ". $hustingJSON->additionalInfo . "\n";
			print "practicalities: ". $hustingJSON->practicalities . "\n";
			print "contactName: ". $hustingJSON->contactName . "\n";
			print "organisation: ". $hustingJSON->organisation . "\n";
			print "contactEmail: ". $hustingJSON->contactEmail . "\n";
			print "contactPhone: ". $hustingJSON->contactPhone . "\n";
			print "organisedBy: ". $hustingJSON->organisedBy . "\n";
			print "eventLocation: ". $hustingJSON->eventLocation . "\n";
			print "constitName: ". $hustingJSON->constitName . "\n";
			print "eventPostcode: ". $hustingJSON->eventPostcode . "\n";
			print "eventDate: ". $hustingJSON->eventDate . "\n";
			print "eventTime: ". $hustingJSON->eventTime . "\n";
			print "url: ". $hustingJSON->url . "\n";
			print "\n";

			print "Have you dealbt with this? Y/N \n";

			

			$result = false;
			do {
				$result = false;
				$line = fgetc(STDIN);
				if (strtolower(substr(trim($line), 0, 1)) == "y") {
					file_put_contents($logFile, "\n".$hustingJSON->id."\n", FILE_APPEND);
					$result = true;
				}
				if (strtolower(substr(trim($line), 0, 1)) == "n") {
					$result = true;
				}
			} while (!$result);

		}

	}
}




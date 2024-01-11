<?php 

require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "1Ar9lVDV5eRBEO7SQLaTkrMj7EtAnZJimRCA9d-6nWHM";

$range = "Sheet1!A2"; // Sheet name

$value1="some value";
$value2="saaadkhan";

$values = [
	[$value1, $value2],
];
//echo "<pre>";print_r($values);echo "</pre>";exit;
$body = new Google_Service_Sheets_ValueRange([
	'values' => $values
]);
$params = [
	'valueInputOption' => 'RAW'
];

$result = $service->spreadsheets_values->append(
	$spreadsheetId,
	$range,
	$body,
	$params
);

if($result->updates->updatedRows == 1){
	echo "Success";
} else {
	echo "Fail";
}

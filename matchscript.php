<?php
require __DIR__ . '/vendor/autoload.php'; // Include the Google API PHP client library

// Set up the Google Sheets API client
$client = new Google_Client();
$client->setApplicationName('Google Sheets PHP API');
$client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
$client->setAuthConfig(__DIR__ . '/credentials.json');
$client->setAccessType('offline');
$service = new Google_Service_Sheets($client);

// The ID of the spreadsheet to update
$spreadsheetId = "1Ar9lVDV5eRBEO7SQLaTkrMj7EtAnZJimRCA9d-6nWHM";

// The range of the sheet to update
$range = 'Sheet1!B1:E';

// The value to match in the table
$searchValue = 'saad';

// The new row data to replace the matched row
$newRowData = ['new-value-1', 'new-value-2', 'new-value-3', 'new-value-4', 'new-value-5'];

// Get the current values from the sheet
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

// Find the row with the matching value
$rowIndex = -1;
foreach ($values as $index => $row) {
    if ($row[0] == $searchValue) {
        $rowIndex = $index;
        break;
    }
}

// If a matching row was found, replace it with the new data
if ($rowIndex != -1) {
    $updateRange = 'Sheet1!A' . ($rowIndex + 1) . ':E' . ($rowIndex + 1);
    $updateBody = new Google_Service_Sheets_ValueRange([
        'range' => $updateRange,
        'majorDimension' => 'ROWS',
        'values' => [$newRowData],
    ]);
    $service->spreadsheets_values->update($spreadsheetId, $updateRange, $updateBody, ['valueInputOption' => 'RAW']);
    echo 'Row updated successfully';
} else {
    echo 'Matching row not found';
}
?>

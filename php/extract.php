<html>
    <head>
        <title>Aareguru 2.0</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <div class="city-container">
<?php

// Get all cities from the API

// URL from which to fetch the data
$url = 'https://aareguru.existenz.ch/v2018/cities';

// Use file_get_contents to fetch the data from the URL
$jsonData = file_get_contents($url);

// Decode the JSON data into a PHP array
$data = json_decode($jsonData, true);

// Check if data is properly fetched and decoded
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Error decoding JSON data: " . json_last_error_msg();
    exit;
}

// Initialize an array to store city names
$cityArray = [];

// Iterate through the data items
foreach ($data as $item) {
    if (isset($item['city'])) {
        // Add the city name to the cityArray
        $cityArray[] = $item['city'];
    }
}

// Initialize an array to store the responses for each city
$apiResponses = [];

// Loop through each city in the cityArray
foreach ($cityArray as $city) {
    // URL encode the city name to handle spaces and special characters
    $encodedCity = urlencode($city);

    // Construct the URL for the current city
    $urlCurrent = "https://aareguru.existenz.ch/v2018/current?city=" . $encodedCity;

    // Use file_get_contents to fetch the data from the URL
    $jsonData = file_get_contents($urlCurrent);

    // Decode the JSON data into a PHP array
    $data = json_decode($jsonData, true);

    // Check if data is properly fetched and decoded
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error decoding JSON data for $city: " . json_last_error_msg();
        continue; // Skip this iteration if there's an error
    }

    // Add the decoded data to the apiResponses array with the city as the key
    $apiResponses[$city] = $data;
}



// Optionally return or use the array as needed
return $apiResponses;

?>
</html>


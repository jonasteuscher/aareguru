<html>
    <head>
        <title>Aareguru 2.0</title>
        <link rel="stylesheet" href="../../css/style.css">
    </head>
    <body>
    <div class="city-container">
<?php

// Get the city from the URL parameter
if (empty($_GET['city'])) {
    $city = "Bern";
} else {
    $city = $_GET['city'];
}

// Create the API URL with the city parameter
$url = "https://aareguru.existenz.ch/v2018/current?city=" . urlencode($city);

// Make a GET request to the API
$response = file_get_contents($url);

// Check if the request was successful
if ($response !== false) {
    // Process the response data
    $data = json_decode($response, true);

    // Check if data decoding was successful
    if ($data) {
        // Assuming you want to display the temperature and other relevant details
        echo "<h1>Current conditions in " . htmlspecialchars($city) . "</h1>";
        echo "<p>Location: " . htmlspecialchars($data['aare']['location_long']) . "</p>";
        echo "<p>Coordinates: Lat " . htmlspecialchars($data['aare']['coordinates']['lat']) . ", Lon " . htmlspecialchars($data['aare']['coordinates']['lon']) . "</p>";
        echo "<p>Temperature: " . htmlspecialchars($data['aare']['temperature']) . "°C</p>";
        echo "<p>Flow: " . htmlspecialchars($data['aare']['flow']) . " m³/s</p>";
        echo "<p>Forecast 2 Hours: " . htmlspecialchars($data['aare']['forecast2h']) . "°C</p>";
    } else {
        echo "Failed to decode JSON data.";
    }
} else {
    // Handle the error if the request fails
    echo "Failed to retrieve data from the API.";
}

?>
</html>


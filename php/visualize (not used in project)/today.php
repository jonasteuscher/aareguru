<html>
    <head>
        <title>Aareguru 2.0</title>
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
$url = "https://aareguru.existenz.ch/v2018/today?city=" . urlencode($city);

// Make a GET request to the API
$response = file_get_contents($url);

// Check if the request was successful
if ($response !== false) {
    // Process the response data
    $data = json_decode($response, true);

    // Check if data decoding was successful
    if ($data) {
        // Convert timestamp to a readable format
        $date = date("Y-m-d H:i:s", $data['time']);

        // Displaying the information
        echo "<h1>Today's forecast for " . htmlspecialchars($data['name']) . "</h1>";
        echo "<p>Location: " . htmlspecialchars($data['longname']) . "</p>";
        echo "<p>Temperature of Aare: " . htmlspecialchars($data['aare']) . "°C</p>";
        echo "<p>Precise Temperature of Aare: " . htmlspecialchars($data['aare_prec']) . "°C</p>";
        echo "<p>Status Message: " . htmlspecialchars($data['text']) . "</p>";
        echo "<p>Short Status: " . htmlspecialchars($data['text_short']) . "</p>";
        echo "<p>Time: " . htmlspecialchars($date) . "</p>";
    } else {
        echo "Failed to decode JSON data.";
    }
} else {
    // Handle the error if the request fails
    echo "Failed to retrieve data from the API.";
}

?>
</div>
</body>
</html>
<?php

function fetchWeatherData() {
    $url = "https://aareguru.existenz.ch/v2018/cities";
    // Initializes a cURL session
    $ch = curl_init($url);

    // Sets options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executes the cURL session and gets the content
    $response = curl_exec($ch);

    // Closes the cURL session
    curl_close($ch);

    // Decodes the JSON response into an associative array
    $data = json_decode($response, true);

    // Check if data is an array and not empty
    if (is_array($data) && !empty($data)) {
        // Iterates over each city and prints details
        foreach ($data as $city) {
            echo '<div class="city-container">';
            echo '<h2>' . htmlspecialchars($city['name']) . ' (' . htmlspecialchars($city['longname']) . ')</h2>';
            echo '<p>Coordinates: Latitude ' . htmlspecialchars($city['coordinates']['lat']) . ', Longitude ' . htmlspecialchars($city['coordinates']['lon']) . '</p>';
            echo '<p>Aare Temperature: ' . htmlspecialchars($city['aare']) . '°C</p>';
            echo '<p>Forecast Available: ' . ($city['forecast'] ? 'Yes' : 'No') . '</p>';
            echo '<a href="/php/visualize/current.php?city=' . htmlspecialchars($city['name']) . '">Current Conditions</a><br>';
            echo '<a href="/php/visualize/today.php?city=' . htmlspecialchars($city['name']) . '">Today\'s Forecast</a><br>';
            echo '</div><hr>';
        }
    } else {
        echo 'No data found or error fetching data.';
    }
}

// Call the function to display the weather data
fetchWeatherData();
?>

<?php

// Bindet das Skript extract.php für Rohdaten ein
$rawData = include('extract.php');

// Output the apiResponses array for verification


// Initialize a new array to hold the transformed data
$transformedData = [];

// Iterate through the original array
foreach ($rawData as $city => $info) {
    //transformations
    $timeStampAareConverted = date('Y-m-d H:i:s', $info['aare']['timestamp']);
    // Extract and transform the necessary data
    $transformedData[$city] = [
        'name' => $info['aare']['location'],
        'longname' => $info['aare']['location_long'], 
        'timestamp' => $timeStampAareConverted,
        'temperature_water' => $info['aare']['temperature'],
        'temperature_water_prec' => $info['aare']['temperature_prec'],
        'coordinates' => [
            'lat' => $info['aare']['coordinates']['lat'],
            'lon' => $info['aare']['coordinates']['lon']
        ],
        'flow' =>  $info['aare']['flow'],
        'rainfall' =>  $info['weather']['current']['rrreal'],
        'rainfall_prec' =>  $info['weather']['current']['rr'],
        'temperature_air' => $info['weather']['current']['tt'],
    ];
}


// This array is now ready for database insertion or other operations
return $transformedData;

?>
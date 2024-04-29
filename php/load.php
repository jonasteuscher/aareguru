<?php

// Include the transformation script that prepares your data array
$dataArray = include('transform.php');  // Assuming this returns an array directly

require_once 'config.php'; // Includes the database configuration

try {
    // Create a new PDO instance with configuration from config.php
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query with placeholders for inserting data
    $sql = "INSERT INTO LocationData (name, longname, timestamp, temperature_water, temperature_water_prec, lat, lon, flow, rainfall, rainfall_prec, temperature_air) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Insert each item in the array into the database
    foreach ($dataArray as $item) {
        $stmt->execute([
            $item['name'],
            $item['longname'],
            $item['timestamp'],
            $item['temperature_water'],
            $item['temperature_water_prec'],
            $item['coordinates']['lat'],  
            $item['coordinates']['lon'],
            $item['flow'] ?? null,  
            $item['rainfall'],
            $item['rainfall_prec'],
            $item['temperature_air']
        ]);
    }

    echo "Data successfully inserted.";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>

<?php

require_once 'config.php'; // Includes the database configuration

try {
    // Create a new PDO instance with configuration from config.php
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to select all data from the table
    $sql = "SELECT name, longname, timestamp, temperature_water, temperature_water_prec, lat, lon, flow, rainfall, rainfall_prec, temperature_air FROM LocationData";

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all rows as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results); // Gibt die Wetterdaten im JSON-Format aus
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]); // Gibt einen Fehler im JSON-Format aus, falls eine Ausnahme auftritt
}
?>
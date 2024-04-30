<?php

require_once 'config.php'; // Includes the database configuration

try {
    // Create a new PDO instance with configuration from config.php
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to select all data from the table
    $sql = "SELECT 
    l.name, 
    l.longname, 
    l.lat, 
    l.lon
  FROM LocationData l
  INNER JOIN (
      SELECT name, MAX(id) AS max_id
      FROM LocationData
      GROUP BY name
  ) groupedl ON l.name = groupedl.name AND l.id = groupedl.max_id
  ORDER BY l.name DESC;
  ";

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
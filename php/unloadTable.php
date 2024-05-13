<!-- TABLE VIEW (currently not in use) -->

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

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" />

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            cursor: pointer;
        }
        .arrow {
            display: inline-block;
            width: 0; 
            height: 0; 
            margin-left: 5px;
            vertical-align: middle;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
        }
        .asc .arrow {
            border-bottom: 4px solid black;
        }
        .desc .arrow {
            border-top: 4px solid black;
        }
    </style>
</head>
<body>
<button class="button" onclick="closeWindow()">Zurück zur Karte</button>
<br><br>
    <table id="dataTable">
        <thead>
            <tr>
                <th onclick="sortTable(0, this)">Name (kurz)<span class="arrow"></span></th>
                <th onclick="sortTable(1, this)">Name (lang)<span class="arrow"></span></th>
                <th onclick="sortTable(2, this)">Datum der Messung<span class="arrow"></span></th>
                <th onclick="sortTable(3, this)">Wassertemperatur (C°)gerundet<span class="arrow"></span></th>
                <th onclick="sortTable(4, this)">Wassertemperatur (C°) genau<span class="arrow"></span></th>
                <th onclick="sortTable(5, this)">Koordinaten (latitude)<span class="arrow"></span></th>
                <th onclick="sortTable(6, this)">Koordinaten (longitude)<span class="arrow"></span></th>
                <th onclick="sortTable(7, this)">Wassermenge(m3/s)<span class="arrow"></span></th>
                <th onclick="sortTable(8, this)">Regen (mm/m3) gerundet<span class="arrow"></span></th>
                <th onclick="sortTable(9, this)">Regen (mm/m3) genau<span class="arrow"></span></th>
                <th onclick="sortTable(10, this)">Lufttemperatur (C°)<span class="arrow"></span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['longname']) ?></td>
                <td><?= htmlspecialchars($row['timestamp']) ?></td>
                <td><?= htmlspecialchars($row['temperature_water']) ?></td>
                <td><?= htmlspecialchars($row['temperature_water_prec']) ?></td>
                <td><?= htmlspecialchars($row['lat']) ?></td>
                <td><?= htmlspecialchars($row['lon']) ?></td>
                <td><?= htmlspecialchars($row['flow']) ?></td>
                <td><?= htmlspecialchars($row['rainfall']) ?></td>
                <td><?= htmlspecialchars($row['rainfall_prec']) ?></td>
                <td><?= htmlspecialchars($row['temperature_air']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        function closeWindow() {
            history.back()
        }
        function sortTable(column, element) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("dataTable");
            switching = true;
            dir = "asc";
            // Remove previous arrow classes
            document.querySelectorAll("th").forEach(th => th.classList.remove("asc", "desc"));
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[column];
                    y = rows[i + 1].getElementsByTagName("TD")[column];
                    // Determine if the columns are numeric or string
                    let xVal = parseFloat(x.innerHTML) || x.innerHTML.toLowerCase();
                    let yVal = parseFloat(y.innerHTML) || y.innerHTML.toLowerCase();
                    if (dir == "asc" && xVal > yVal ||
                        dir == "desc" && xVal < yVal) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
            // Add arrow direction class to the clicked header
            element.classList.add(dir);
        }
        
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailansicht</title>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0/dist/chartjs-adapter-moment.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>

    <link
      href="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""
    />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""
    ></script>
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  
  <body>
  <button class="button" onclick="closeWindow()">Zurück zur Karte</button>
    <br>
    <h1 class="detail-header" id="detailHeader"></h1>
    <div class="container" id="waterChartContainer" style="display: none;">
    <h1 id="detailHeader"></h1><br><br>
    <canvas id="waterTemperatureChart"></canvas>
    <script src="../js/waterTempScript.js"></script>
  </div>
  <div class="container" id="airChartContainer" style="display: none;">
  <h1 id="detailHeader"></h1><br><br>
    <canvas id="airTemperatureChart"></canvas>
    <script src="../js/airTempScript.js"></script>
  </div>
  <div class="container" id="flowChartContainer" style="display: none;">
  <h1 id="detailHeader"></h1><br><br>
    <canvas id="flowChart"></canvas>
    <script src="../js/flowScript.js"></script>
  </div>
  </body>
  <script>
    // Function to parse URL parameters
    function getUrlParameter(name) {
      name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
      var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
      var results = regex.exec(location.search);
      return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    // Get the value of the detailView parameter from the URL
    var detailView = getUrlParameter('detailView');
    // Get the value of the city parameter from the URL
    var city = getUrlParameter('city');
    var chart = getUrlParameter('detailView');
    if (chart === 'flow') {
      chart = 'Wassermenge (m3/s)';
    } else if (chart === 'water') {
      chart = 'Wassertemperatur (C°)';
    } else if (chart === 'air') {
      chart = 'Lufttemperatur (C°)';
    }

    // Display the city in the detail header
    document.getElementById('detailHeader').innerText = chart + ' in ' + city;
    function closeWindow() {
      window.close();
    }
    // Show the corresponding chart based on the detailView parameter
    if (detailView === 'water') {
      document.getElementById('waterChartContainer').style.display = 'block';
    } else if (detailView === 'air') {
      document.getElementById('airChartContainer').style.display = 'block';
    } else if (detailView === 'flow') {
      document.getElementById('flowChartContainer').style.display = 'block';
    }
  </script>
</html>

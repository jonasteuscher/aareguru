<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AAREWÄRT - Detailahsicht</title>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0/dist/chartjs-adapter-moment.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   
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
    <link rel="icon" href="../data/img/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <main>
  <body>
  <header>
    <a href="/">
      <img src="../data/img/logo.png" class="logo" alt="Logo" />
    </a>
    <div class="hamburger" onclick="toggleMenu()">&#9776;</div>
  </header>
 
    
    <div class="flexGrid">
  <h1 class="detail-header" id="detailHeader"></h1>
</div>
<h2 id="city-coordinates"></h2>
<div class="flexGridDropDown">
  <!-- dropdown for every city -->
  <select id="cityDropdown" class="dropdown"></select>
  <!-- dropdown for detailView -->
  <select id="detailViewDropdown" class="dropdown">
    <option value="air">Lufttemperatur</option>
    <option value="flow">Wassermängi</option>
    <option value="water">Wassertemperatur</option>
  </select>
</div>
<br>
  <div class="container" id="waterChartContainer" style="display: none;">
    <div class="chartContainer">
      <canvas id="waterTemperatureChart"></canvas>
      <script src="../js/waterTempScript.js"></script>
    </div>
  </div>
  <div class="container" id="airChartContainer" style="display: none;">
    <div class="chartContainer">
      <canvas id="airTemperatureChart"></canvas>
      <script src="../js/airTempScript.js"></script>
    </div>
  </div>
  <div class="container" id="flowChartContainer" style="display: none;">
    <div class="chartContainer">
      <canvas id="flowChart"></canvas>
      <script src="../js/flowScript.js"></script>
    </div>
  </div>
  <div id="menu" class="menu">
        <a href="/"><b>Home</b></a>
        <a href="/map.html"><b>Charte</b></a>
        <a href="/php/detail.php?city=Bärn&detailView=water"><b>Detailahsicht</b></a>
        <a href="/about.html"><b>Über üs</b></a>
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

    const apiUrl = 'https://161649-6.web.fhgr.ch/php/unloadCities.php'
   
    // Get the value of the detailView parameter from the URL
    var detailView = getUrlParameter('detailView');
    // Get the value of the city parameter from the URL
    var city = getUrlParameter('city');
    var chart = getUrlParameter('detailView');
    if (chart === 'flow' && city) {
      chart = 'Wassermängi (m3/s)';
    } else if (chart === 'water' && city) {
      chart = 'Wassertemperatur (C°)';
    } else if (chart === 'air' && city) {
      chart = 'Lufttemperatur (C°)';
    }

    // Display the city in the detail header
    if (!city || !chart) {
      document.getElementById('detailHeader').innerText = "Bitte Stadt und Chart uswähle";
    } else {
    document.getElementById('detailHeader').innerText = chart + ' in ' + city;
    }
    function closeWindow() {
      window.close();
    }
    // Show the corresponding chart based on the detailView parameter
    if (detailView === 'water' && city) {
      document.getElementById('waterChartContainer').style.display = 'block';
    } else if (detailView === 'air' && city) {
      document.getElementById('airChartContainer').style.display = 'block';
    } else if (detailView === 'flow' && city) {
      document.getElementById('flowChartContainer').style.display = 'block';
    }

    fetch(apiUrl)
  .then(response => response.json())
  .then(cityData => {
    const cityDropdown = document.getElementById('cityDropdown');
    
    // Sort the cityData array by name in ascending order
    cityData.sort((a, b) => a.name.localeCompare(b.name));
    
    cityData.forEach(c => {
      const option = document.createElement('option');
      option.value = c.name;
      option.text = c.name;
      cityDropdown.appendChild(option);
    });

    cityDropdown.value = city;

    cityDropdown.addEventListener('change', function() {
      const selectedCity = this.value;
      const url = new URL(window.location);
      url.searchParams.set('city', selectedCity);
      window.location = url;
    });

    const rightCity = cityData.find(c => c.name === city); // Find the city in the array
    const coordinatesHeader = document.getElementById("city-coordinates");
    if (rightCity && detailView) {
        // Update H2 text with coordinates
        coordinatesHeader.textContent = "Koordinate vor Mässig: " + rightCity.lat + "°N, " + rightCity.lon + "°E";
    } else {
      coordinatesHeader.textContent = " ";
    }
  });

  function toggleMenu() {
          const menu = document.getElementById("menu");
          const hamburger = document.querySelector(".hamburger");
          if (menu.style.display === "flex") {
            menu.style.display = "none";
            hamburger.innerHTML = "&#9776;"; // Hamburger icon
            hamburger.style.color = "#ffe500"; // Original color
            hamburger.style.fontSize = "60px"; // Ensuring uniform size
            hamburger.style.top = ""; // Ensuring uniform size
            hamburger.style.right = ""; // Ensuring uniform size
            document.body.style.backgroundColor = "#24ACCF";
          } else {
            menu.style.display = "flex";
            hamburger.innerHTML = "&times;"; // X icon
            hamburger.style.color = "#24ACCF"; // X-icon should be blue
            hamburger.style.fontSize = "80px"; // Ensuring uniform size
            hamburger.style.top = "-10px"; // Ensuring uniform size
            hamburger.style.right = "38px"; // Ensuring uniform size
            document.body.style.backgroundColor = "#ffe500";
          }
        }

    const detailViewDropdown = document.getElementById('detailViewDropdown');
    detailViewDropdown.value = detailView;

    detailViewDropdown.addEventListener('change', function() {
      const selectedDetailView = this.value;
      const url = new URL(window.location);
      url.searchParams.set('detailView', selectedDetailView);
      window.location = url;
    });
  </script>
  </main>
  <br><br><br><br><br><br> 
  <footer class="footer">
      <p>All rights reserved © <a href="https://fhgr.ch/" target="_blank">FHGR</a></p>
      <p>Powered by <a href="https://aareguru.existenz.ch/openapi/" target="_blank">Aareguru</a></p>
    </footer>
</html>

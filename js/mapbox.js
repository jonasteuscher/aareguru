mapboxgl.accessToken = 'pk.eyJ1Ijoiam9uYXN0ZXVzY2hlciIsImEiOiJjbHZtN3JoeWsyN3B1MnFwZTJ5N2xrN3FsIn0.FmTALKtyw0Sb5p3ubzOZ6Q';


var map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
    center: [7.85, 47.08], // approximate center between Brienz, Bern, and Aarau
    zoom: 8.2 // Adjusted zoom level to encompass the broader area
});

map.on('zoomend', function() {
    if (map.getZoom() <= 6) {
        // Increase visibility of waterways when zoom level is 6 or below
        map.setPaintProperty('waterway', 'line-color', '#0000FF'); // Bright blue color
        map.setPaintProperty('waterway', 'line-width', 3); // Thicker line
    } else {
        // Revert to normal visibility when zoom level is above 6
        map.setPaintProperty('waterway', 'line-color', '#5e94f3'); // Default blue color
        map.setPaintProperty('waterway', 'line-width', 1); // Default line width
    }
});

map.on('load', function () {
    const apiUrl = 'https://161649-6.web.fhgr.ch/php/unloadCities.php'; // Adjust the URL as needed

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Process data right inside the promise once it's available
            const cities = data.map(location => ({
                name: location.name,
                coordinates: [location.lon, location.lat],
                popup: `${location.longname}<br> Koordinaten: ${location.lat}°N, ${location.lon}°E`,
                waterTempLink: `https://161649-6.web.fhgr.ch/php/detail.php?city=${encodeURIComponent(location.name)}&detailView=water`,
                airTempLink: `https://161649-6.web.fhgr.ch/php/detail.php?city=${encodeURIComponent(location.name)}&detailView=air`,
                flowLink: `https://161649-6.web.fhgr.ch/php/detail.php?city=${encodeURIComponent(location.name)}&detailView=flow`
            }));
            // Adding markers and popups for each city
            cities.forEach(function(city) {
                // Create a HTML element for each feature
                var el = document.createElement('div');
                el.className = 'marker';

                // Create a marker and set its coordinates based on the city
                new mapboxgl.Marker(el)
                .setLngLat(city.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 })
                    .setHTML(`
                        <h3>${city.name}</h3>
                        <p>${city.popup}</p>
                            <a href="${city.waterTempLink}" target="_blank">Details Wassertemperatur</a><br>
                            <a href="${city.airTempLink}" target="_blank">Details Lufttemparatur</a><br>
                            <a href="${city.flowLink}" target="_blank">Details Wassermenge</a><br>
                    `))
                .addTo(map);
                    })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
});

    // Ensure the waterway layer is already added by checking if it exists
    if (map.getSource('composite')) {
        // The 'waterway' layer already exists in many Mapbox default styles under the source 'composite'
        map.setPaintProperty('waterway', 'line-color', '#0000FF'); // Set waterways to blue
        map.setPaintProperty('waterway', 'line-width', 2); // Increase line width for visibility
    } else {
        // If not, you might need to add the waterway layer manually (this usually isn't necessary with default styles)
        map.addLayer({
            'id': 'waterways',
            'type': 'line',
            'source': 'mapbox://mapbox.mapbox-streets-v8',
            'source-layer': 'waterway',
            'paint': {
                'line-color': '#0000FF',
                'line-width': 2
            }
        });
    }
});


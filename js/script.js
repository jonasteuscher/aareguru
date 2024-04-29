document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = 'https://161649-6.web.fhgr.ch/php/unload.php'; // Passen Sie die URL bei Bedarf an

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // Prepare data for Chart.js
            const chartData = data.reduce((acc, curr) => {
                if (!acc[curr.name]) {
                    acc[curr.name] = {
                        label: curr.name,
                        data: [],
                        backgroundColor: `rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`,
                    };
                }
                acc[curr.name].data.push({
                    x: curr.timestamp,
                    y: curr.temperature_water
                });
                return acc;
            }, {});

            // Sort data by date for each location
            Object.values(chartData).forEach(location => {
                location.data.sort((a, b) => a.x - b.x);
            });

            // Create Chart.js chart
            const ctx = document.getElementById('temperatureChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: Object.values(chartData),
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'hour',
                                tooltipFormat: 'HH:mm', // Format for tooltip
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Time'
                            }
                        },
                        y: {
                            scaleLabel: {
                                display: true,
                                labelString: 'Temperature (°C)'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Fetch-Fehler:', error)); // Gibt Fehler im Konsolenlog aus, falls die Daten nicht abgerufen werden können

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color; // Erzeugt eine zufällige Farbe
    }
});
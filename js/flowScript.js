document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = 'https://161649-6.web.fhgr.ch/php/unloadAll.php'; // Passen Sie die URL bei Bedarf an

    fetch(apiUrl)
        .then(response => response.json())
        .then(rawData => {
            const params = new URLSearchParams(window.location.search);
            const cityName = params.get('city');  // Get the value of 'city' parameter
            const data = rawData.filter(item => item.name === cityName);
            const datasets = data.reduce((acc, entry) => {
                const dataset = acc.find(ds => ds.label === entry.name);
                if (dataset) {
                    dataset.data.push({x: new Date(entry.timestamp), y: entry.flow});
                } else {
                    acc.push({
                        label: entry.name,
                        data: [{x: new Date(entry.timestamp), y: entry.flow}],
                        borderColor: getRandomColor(),
                        fill: false
                    });
                }
                return acc;
            }, []);
    
            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
    
            const ctx = document.getElementById('flowChart').getContext('2d');
            const flowChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: datasets
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                parser: 'yyyy-MM-dd HH:mm:ss', 
                                unit: 'minute',
                                displayFormats: {
                                    minute: 'D. MMM, yyyy HH:mm' // Customize this format as you prefer
                                }
                            },
                            title: {
                                display: true,
                                text: 'Datum und Uhrzeit'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Wassermenge (m3/s)'
                            },
                            beginAtZero: true
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
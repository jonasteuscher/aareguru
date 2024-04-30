document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = 'https://161649-6.web.fhgr.ch/php/unload.php'; // Passen Sie die URL bei Bedarf an

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
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
                                unit: 'minute'
                            },
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Wassermenge (m^3/s)'
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
# aareguru

## Beschreibung des Projekts
**AAREWÄRT - Dini Übersicht für ne Schwumm**
 
Mit *AAREWÄRT* präsentieren wir eine Übersicht 
über die Aare in der Schweiz. Das Projekt bietet
Informationen wie den aktuellen Wasserstand, die
Wassertemperatur oder Lufttemperatur an den verschiedenen Standorten.

Das Ziel des Projekts ist es, den Nutzern eine
zuverlässige und benutzerfreundliche Plattform in Form einer Karte (mit Integration von MapBox)
zur Verfügung zu stellen, auf der Sie die Bedingungen an der Aare überwachen und vergleichen können.

## Learnings / Schwierigkeiten
### MapBox ist der Hammer
Die Integration von MapBox ermöglicht es uns, die verschiedenen Standorte entlang der Aare auf einer interaktiven Karte darzustellen. Dadurch können die Nutzer die Bedingungen an verschiedenen Orten leicht vergleichen und die besten Schwimmstellen finden. MapBox bietet auch eine Vielzahl von Anpassungsmöglichkeiten, um die Karte an unsere Bedürfnisse anzupassen, wie z.B. das Hinzufügen von Markern, Popups und benutzerdefinierten Stilen. Mit MapBox wird die Benutzererfahrung unserer Plattform deutlich verbessert.

### Integration ChartJS
Die Integration von Chart.js war viel einfacher als gedacht. Mit Chart.js können wir Daten aus der Datenbank abrufen und sie dynamisch in verschiedene Diagrammtypen wie Linien-, Balken- oder Kreisdiagramme umwandeln. Wir haben uns für die Liniendiagramme entschieden, da sie sich für den Vergleich von verschiedenen Standorten in den vergangenen Tagen am besten eignen.
Die Konfiguration der verschiedenen Dashboards macht wirklich Spaß und ermöglicht es uns, die Daten auf ansprechende und interaktive Weise zu präsentieren.

### PHP
Anfangs hatten wir niedrige Erwartungen an PHP, aber wir haben festgestellt, dass es uns dennoch ermöglicht, coole Umsetzungen zu machen. Es bietet uns gute Möglichkeiten, um mit der Aareguru-API zu interagieren und die Daten abzurufen und anzuzeigen. Wir konnten PHP verwenden, um dynamische Inhalte auf unserer Plattform zu generieren. Obwohl es anfangs eine Lernkurve gab, haben wir uns schnell mit den Funktionen und Möglichkeiten von PHP vertraut gemacht und konnten damit unsere Ziele erreichen.



## Ressourcen

### API
Für die Abfrage und Anzeige der Daten wird die offiezielle API von Aareguru verwendet:
https://aareguru.existenz.ch/openapi/

### Visualisierung
#### ChartJS
Die Visualsierung der Daten wird mit Chart.js gemacht: https://www.chartjs.org/
#### MapBox
Die Darstellung der verschiedenen Standorte auf der Karte ist mit https://www.mapbox.com/ umgesetzt.

### Datenspeicherung
Die ausgelesenen Daten werden in einer von der FHGR zur Verfügung gestellten MySQL-Datenbank abgespeichert.





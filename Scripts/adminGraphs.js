// Script pour créer les graphiques des covoiturages
// On recupere l'element canvas
const graph = document.getElementById('myChart');
// On recupere les donnees de l'API
fetch('index.php?controller=api&action=getGraphData')
    .then(response => response.json())
    .then(data => {
        // On appelle la fonction createChart avec les donnees recuperees
        createChart(data, 'bar');
    })
// Fonction pour creer le graphique
function createChart(charData, chartType) {
    const labels = Object.keys(charData); // Les dates des covoiturages
    const dataValues = Object.values(charData); // Les quantites de covoiturages
    // On cree le graphique avec Chart.js
    new Chart(graph, {
        type: chartType,
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre de covoiturages par jour',
                data: dataValues,
                backgroundColor: '#0163AC',
                borderWidth: 1
            }, {
                label: 'Nombre de credits gagnes par jour',
                data: dataValues.map(value => value * 2), // Pour calculer les credits gagnes par jour
                backgroundColor: '#EDE42C',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    })
}

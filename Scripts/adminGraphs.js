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
    const isMobile = window.innerWidth <= 768; // Pour savoir si on est sur mobile ou pas
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
            responsive: true,
            maintainAspectRatio: false, // Important pour le responsive
            scales: {
                x: {
                    // Pour faire tourner les labels sur l'axe des x en mode responsive
                    ticks: {
                        maxRotation: isMobile ? 90 : 45,
                        minRotation: isMobile ? 45 : 0,
                        font: { // Pour changer la taille de la police en monde responsive
                            size: isMobile ? 10 : 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    // Pour faire tourner les labels sur l'axe des y en mode responsive
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            },
            // Le texte qui explique les couleurs des barres
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            }
        }
    })
}


// new Chart(graph, {
//     type: chartType,
//     data: {
//       labels: labels,
//       datasets: [{
//         label: 'Nombre de covoiturages par jour',
//         data: dataValues,
//         backgroundColor: 'rgba(75, 192, 192, 0.5)',
//         borderColor: 'rgba(75, 192, 192, 1)',
//         borderWidth: 1
//       }]
//     },
//     options: {
//       responsive: true,
//       maintainAspectRatio: false, // Important pour le responsive
//       scales: {
//         x: {
//           ticks: {
//             maxRotation: isMobile ? 90 : 45,
//             minRotation: isMobile ? 45 : 0,
//             font: {
//               size: isMobile ? 10 : 12
//             }
//           }
//         },
//         y: {
//           beginAtZero: true,
//           ticks: {
//             font: {
//               size: isMobile ? 10 : 12
//             }
//           }
//         }
//       },
//       plugins: {
//         legend: {
//           labels: {
//             font: {
//               size: isMobile ? 10 : 12
//             }
//           }
//         }
//       }
//     }
//   });
let probabilityChart = null; // Variável para armazenar o gráfico de pizza
let lineChart = null; // Variável para armazenar o gráfico de linhas

function factorial(n) {
    return n <= 1 ? 1 : n * factorial(n - 1);
}

function combinations(n, k) {
    return factorial(n) / (factorial(k) * factorial(n - k));
}

function hypergeometric(k, N, K, n) {
    return (combinations(K, k) * combinations(N - K, n - k)) / combinations(N, n);
}

function hypergeometricProbability(deckSize, handSize, cardCount, minCopies, maxCopies) {
    let probability = 0;

    for (let k = minCopies; k <= maxCopies; k++) {
        probability += hypergeometric(k, deckSize, cardCount, handSize);
    }

    return probability * 100;
}

function calculateProbability() {
    const deckSize = parseInt(document.getElementById("deckSize").value);
    const handSize = parseInt(document.getElementById("handSize").value);
    const cardCount = parseInt(document.getElementById("cardCount").value);
    const minCopies = parseInt(document.getElementById("minCopies").value);
    const maxCopies = parseInt(document.getElementById("maxCopies").value);

    const probability = hypergeometricProbability(deckSize, handSize, cardCount, minCopies, maxCopies);
    const resultText = `A probabilidade de abrir com ${minCopies}-${maxCopies} cópias da carta é ${probability.toFixed(2)}%`;
    document.getElementById("result").innerText = resultText;

    if (probability.toFixed(2) >= 72) {
        document.getElementById("result").style.backgroundColor = "green";
    } else if (probability.toFixed(2) >= 50) {
        document.getElementById("result").style.backgroundColor = "orange";
    } else {
        document.getElementById("result").style.backgroundColor = "red";
        showLowProbabilityModal();
    }

    updateChart(probability);
    generateBarChart(deckSize, handSize, cardCount, minCopies, maxCopies);
}

function updateChart(probability) {
    const ctx = document.getElementById('probabilityChart').getContext('2d');

    if (probabilityChart) {
        probabilityChart.data.datasets[0].data = [probability, 100 - probability];
        probabilityChart.update();
    } else {
        probabilityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Abrir com a Carta', 'Não Abrir com a Carta'],
                datasets: [{
                    label: 'Probabilidade de vir com',
                    data: [probability, 100 - probability],
                    backgroundColor: ['#36a2eb', '#ff6384'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Probabilidade de Abrir com a Carta',
                        color: 'white'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        },
                        title: {
                            display: true,
                            text: 'Probabilidade (%)',
                            color: 'white'
                        },
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'white'
                        }
                    }
                }
            }
        });
    }
}

function generateBarChart(deckSize, handSize, cardCount, minCopies, maxCopies) {
    const ctx = document.getElementById('lineChart').getContext('2d');
    const probabilities = [];

    for (let k = minCopies; k <= maxCopies; k++) {
        const prob = hypergeometricProbability(deckSize, handSize, cardCount, k, k);
        probabilities.push(prob);
    }

    if (lineChart) {
        lineChart.data.labels = Array.from({ length: maxCopies - minCopies + 1 }, (_, i) => i + minCopies);
        lineChart.data.datasets[0].data = probabilities;
        lineChart.update();
    } else {
        lineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Array.from({ length: maxCopies - minCopies + 1 }, (_, i) => i + minCopies),
                datasets: [{
                    label: 'Probabilidade de abrir com cada cópia',
                    data: probabilities,
                    backgroundColor: '#36a2eb',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Probabilidade de Abrir com Cada Número de Cópias',
                        color: 'white'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white'
                        },
                        title: {
                            display: true,
                            text: 'Probabilidade (%)',
                            color: 'white'
                        },
                        min: 0,
                        max: 100,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'white'
                        },
                        title: {
                            display: true,
                            text: 'Número de Cópias na Mão',
                            color: 'white'
                        }
                    }
                }
            }
        });
    }
}

function showLowProbabilityModal() {
    const modalElement = new bootstrap.Modal(document.getElementById('lowProbabilityModal'));
    modalElement.show();
}
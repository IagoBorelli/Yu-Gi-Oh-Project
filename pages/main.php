<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- META_TAGS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP_CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- IONICONS_CDN -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- CHARTJS_CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- CSS_LINK -->
    <link rel="stylesheet" href="../styles/probabilidade.css">
    <link rel="stylesheet" href="../styles/root.css">
    <!-- TITLE -->
    <title>Project Y</title>
</head>
<body>
    <?php include '../includes/header.php' ?>
    <main>
        <div class="containerTitle">
            <h1>Calculadora de probabilidade Yu-Gi-Oh!</h1>
        </div>
        <div class="containerForm">
            <form class="row g-3" onsubmit="event.preventDefault(); calculateProbability();">
                <div class="col-md-6">
                    <label for="deckSize" class="form-label">Tamanho do Baralho:</label>
                    <input type="number" class="form-control" id="deckSize" required>
                </div>
                <div class="col-md-6">
                    <label for="handSize" class="form-label">Mão Inicial:</label>
                    <input type="number" class="form-control" id="handSize" required>
                </div>
                <div class="col-md-4">
                    <label for="cardCount" class="form-label">Quantidade da Carta no Baralho:</label>
                    <input type="number" class="form-control" id="cardCount" required>
                </div>
                <div class="col-md-4">
                    <label for="minCopies" class="form-label">Mínimo de Cópias na Mão Inicial:</label>
                    <input type="number" class="form-control" id="minCopies" required>
                </div>
                <div class="col-md-4">
                    <label for="maxCopies" class="form-label">Máximo de Cópias na Mão Inicial:</label>
                    <input type="number" class="form-control" id="maxCopies">
                </div>
                <div class="button">
                    <button type="submit" class="btn btn-primary">Calcular Probabilidade</button>
                </div>
            </form>
        </div>
        <div class="containerReport">
            <div class="containerFirstReport">
                <div class="result">
                    <p id="result"></p>
                </div>
                <div class="containerGraphic">
                    <canvas id="probabilityChart"></canvas>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <div class="containerSecondReport">

            </div>
        </div>

        <div class="modal fade" id="lowProbabilityModal" tabindex="-1" aria-labelledby="lowProbabilityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lowProbabilityModalLabel">Probabilidade Baixa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>A probabilidade de abrir com as cópias desejadas é inferior a 50%.</p>
                        <p>Para se ter uma maior chance de abertura, indica-se um número de cartas acima de 7</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="../scripts/probabilidade.js"></script>
</body>
</html>
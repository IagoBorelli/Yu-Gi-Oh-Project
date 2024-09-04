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
    <link rel="stylesheet" href="../styles/cardSearch.css">
    <link rel="stylesheet" href="../styles/root.css">
    <!-- TITLE -->
    <title>Project Y</title>
    
</head>
<body>
    <?php include '../includes/header.php' ?>
    <main>
        <div class="container">
            <div class="containerTitle">
                <h1>Yu-Gi-Oh! Card Search</h1>
            </div>
            <form id="cardForm">
                <input type="text" id="cardName" name="cardName" placeholder="Digite o nome da carta" required>
                <button type="submit">Buscar</button>
            </form>
            <div id="cardList" class="card-list"></div>
        </div>
        <!-- Modal -->
        <div id="cardModal" class="modal">
            <div class="modal-content">
                <img id="modalImage" src="" alt="">
                <div class="info">
                    <h2 id="modalName"></h2>
                    <p><strong>Tipo:</strong> <span id="modalType"></span></p>
                    <p><strong>Atributo:</strong> <span id="modalAttribute"></span></p>
                    <p><strong>Descrição:</strong> <span id="modalDesc"></span></p>
                    <button class="close-btn" id="closeModal">Fechar</button>
                </div>
            </div>
        </div>
    </main>
    <script src="../scripts/cardSearch.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR">

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
    <link rel="stylesheet" href="../styles/deckBuilder.css">
    <link rel="stylesheet" href="../styles/root.css">
    <!-- TITLE -->
    <title>Project Y</title>
</head>

<body>
    <?php include '../includes/header.php' ?>
    <main>
        <h1>Construtor de Deck Yu-Gi-Oh!</h1>
        <form id="card-search-form">
            <label for="card-name">Nome da Carta:</label>
            <input type="text" id="card-name" required>
            <button type="submit">Buscar</button>
        </form>

        <div id="search-results" class="card-grid"></div>

        <div class="deck-area" id="main-deck">
            <h3>Main Deck (0/60)</h3>
            <div class="card-grid" id="main-deck-cards"></div>
        </div>

        <div class="deck-area" id="extra-deck">
            <h3>Extra Deck (0/15)</h3>
            <div class="card-grid" id="extra-deck-cards"></div>
        </div>

        <div class="deck-area" id="side-deck">
            <h3>Side Deck (0/15)</h3>
            <div class="card-grid" id="side-deck-cards"></div>
        </div>

        <!-- Modal -->
        <div id="modal">
            <span class="close-modal">&times;</span>
            <div id="modal-content"></div>
            <div class="deck-select">
                <label for="deck-type">Selecionar Deck:</label>
                <select id="deck-type">
                    <option value="main">Main Deck</option>
                    <option value="extra">Extra Deck</option>
                    <option value="side">Side Deck</option>
                </select>
                <label for="card-quantity">Quantidade:</label>
                <input type="number" id="card-quantity" min="1" max="3" value="1">
                <button id="add-card-button">Adicionar ao Deck</button>
            </div>
        </div>
        <div id="overlay"></div>
    </main>
    <footer class="text-center mt-5">
        <p>&copy; 2023 Projeto Y. Todos os direitos reservados.</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cardSearchForm = document.getElementById('card-search-form');
            const cardNameInput = document.getElementById('card-name');
            const searchResults = document.getElementById('search-results');
            const modal = document.getElementById('modal');
            const overlay = document.getElementById('overlay');
            const closeModalBtn = document.querySelector('.close-modal');
            const modalContent = document.getElementById('modal-content');
            const addCardButton = document.getElementById('add-card-button');
            const deckTypeSelect = document.getElementById('deck-type');
            const cardQuantityInput = document.getElementById('card-quantity');
            const mainDeck = document.getElementById('main-deck-cards');
            const extraDeck = document.getElementById('extra-deck-cards');
            const sideDeck = document.getElementById('side-deck-cards');
            const maxCardCounts = {
                main: 60,
                extra: 15,
                side: 15
            };

            let selectedCard = null;
            let deckCounts = {
                main: 0,
                extra: 0,
                side: 0
            };

            cardSearchForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const cardName = cardNameInput.value.trim();
                if (cardName) {
                    const cardData = await fetchCardData(cardName);
                    displaySearchResults(cardData);
                }
            });

            closeModalBtn.addEventListener('click', closeModal);

            overlay.addEventListener('click', closeModal);

            addCardButton.addEventListener('click', () => {
                const deckType = deckTypeSelect.value;
                const cardQuantity = parseInt(cardQuantityInput.value);
                addCardToDeck(selectedCard, deckType, cardQuantity);
                closeModal();
            });

            function openModal(card) {
                selectedCard = card;
                modalContent.innerHTML = `
                    <img src="${card.card_images[0].image_url}" alt="${card.name}">
                    <h2>${card.name}</h2>
                    <p>${card.desc}</p>
                `;
                modal.style.display = 'block';
                overlay.style.display = 'block';
            }

            function closeModal() {
                modal.style.display = 'none';
                overlay.style.display = 'none';
                selectedCard = null;
            }

            async function fetchCardData(cardName) {
                const response = await fetch(`https://db.ygoprodeck.com/api/v7/cardinfo.php?fname=${cardName}`);
                const data = await response.json();
                return data.data;
            }

            function displaySearchResults(cards) {
                searchResults.innerHTML = '';
                cards.forEach(card => {
                    const cardElement = document.createElement('div');
                    cardElement.classList.add('card');
                    cardElement.style.backgroundImage = `url(${card.card_images[0].image_url})`;
                    cardElement.addEventListener('click', () => openModal(card));
                    searchResults.appendChild(cardElement);
                });
            }

            function addCardToDeck(card, deckType, quantity) {
                const deck = getDeckElement(deckType);
                if (deckCounts[deckType] + quantity <= maxCardCounts[deckType]) {
                    for (let i = 0; i < quantity; i++) {
                        const cardElement = document.createElement('div');
                        cardElement.classList.add('card');
                        cardElement.style.backgroundImage = `url(${card.card_images[0].image_url})`;
                        deck.appendChild(cardElement);
                        deckCounts[deckType]++;
                    }
                    updateDeckCount(deckType);
                } else {
                    alert('Quantidade máxima de cartas atingida para este deck.');
                }
            }

            function getDeckElement(deckType) {
                switch (deckType) {
                    case 'main':
                        return mainDeck;
                    case 'extra':
                        return extraDeck;
                    case 'side':
                        return sideDeck;
                    default:
                        return mainDeck;
                }
            }

            function updateDeckCount(deckType) {
                const deckElement = document.getElementById(`${deckType}-deck`);
                const deckCount = deckElement.querySelector('h3');
                deckCount.textContent = `${deckType.charAt(0).toUpperCase() + deckType.slice(1)} Deck (${deckCounts[deckType]}/${maxCardCounts[deckType]})`;
            }
        });
    </script>
</body>

</html>
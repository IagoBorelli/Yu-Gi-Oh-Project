const apiUrl = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
        const banlistUrl = 'https://db.ygoprodeck.com/api/v7/cardinfo.php?banlist=tcg';
        let cardData = [];
        let banlist = {};
        let mainDeck = [];
        let extraDeck = [];
        let sideDeck = [];

        // Função para buscar dados da API e armazenar em cardData
        async function fetchCardData() {
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                cardData = data.data; // Armazena todas as cartas
                console.log("Cartas carregadas:", cardData.length);

                // Carregar banlist
                const banResponse = await fetch(banlistUrl);
                const banData = await banResponse.json();
                banData.data.forEach(card => {
                    banlist[card.name] = card.banlist_info ? card.banlist_info.ban_tcg : 3;
                });
                console.log("Banlist carregada");
            } catch (error) {
                console.error('Erro ao buscar dados da API:', error);
            }
        }

        // Busca cartas com nome ou arquétipo correspondente
        function searchCards(query) {
            return cardData.filter(card => 
                card.name.toLowerCase().includes(query.toLowerCase()) ||
                (card.archetype && card.archetype.toLowerCase().includes(query.toLowerCase()))
            );
        }

        // Atualiza o contador de cartas do deck
        function updateDeckCount(deckType) {
            const deck = document.getElementById(`${deckType}-deck`);
            const count = deck.querySelectorAll('.card').length;
            deck.querySelector('h3').textContent = `${deckType.charAt(0).toUpperCase() + deckType.slice(1)} Deck (${count}/${deckType === 'main' ? 60 : 15})`;
        }

        // Adiciona carta ao deck
        function addCardToDeck(card, deckType) {
            const deck = deckType === 'main' ? mainDeck : deckType === 'extra' ? extraDeck : sideDeck;
            const maxCount = banlist[card.name] || 3;
            const cardCount = deck.filter(c => c.name === card.name).length;

            if (deck.length < (deckType === 'main' ? 60 : 15) && cardCount < maxCount) {
                deck.push(card);
                renderDeck(deckType);
            } else {
                alert(`Você não pode adicionar mais cópias de "${card.name}" ao ${deckType} deck.`);
            }
        }

        // Remove carta do deck
        function removeCardFromDeck(card, deckType) {
            const deck = deckType === 'main' ? mainDeck : deckType === 'extra' ? extraDeck : sideDeck;
            const index = deck.findIndex(c => c.name === card.name);
            if (index !== -1) {
                deck.splice(index, 1);
                renderDeck(deckType);
            }
        }

        // Renderiza cartas no grid
        function renderCards(cards, containerId, addCard = false, deckType = '') {
            const container = document.getElementById(containerId);
            container.innerHTML = ''; // Limpa o container
            cards.forEach(card => {
                const cardElement = document.createElement('div');
                cardElement.className = 'card';
                cardElement.style.backgroundImage = `url(${card.card_images[0].image_url})`;
                cardElement.style.backgroundSize = 'cover';
                
                // Ícone de lupa
                const zoomIcon = document.createElement('div');
                zoomIcon.className = 'icon-zoom';
                zoomIcon.textContent = '🔍';
                zoomIcon.addEventListener('click', (e) => {
                    e.stopPropagation();
                    showModal(card);
                });
                cardElement.appendChild(zoomIcon);
                
                if (addCard) {
                    cardElement.addEventListener('click', () => addCardToDeck(card, deckType));
                } else {
                    cardElement.addEventListener('click', () => removeCardFromDeck(card, deckType));
                }
                
                // Mostrar quantidade máxima
                const maxCount = banlist[card.name] || 3;
                const maxCountLabel = document.createElement('div');
                maxCountLabel.style.position = 'absolute';
                maxCountLabel.style.bottom = '5px';
                maxCountLabel.style.left = '5px';
                maxCountLabel.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                maxCountLabel.style.color = 'white';
                maxCountLabel.style.padding = '2px';
                maxCountLabel.style.fontSize = '10px';
                maxCountLabel.textContent = `Máx: ${maxCount}`;
                cardElement.appendChild(maxCountLabel);

                container.appendChild(cardElement);
            });
        }

        // Renderiza o deck
        function renderDeck(deckType) {
            const deck = deckType === 'main' ? mainDeck : deckType === 'extra' ? extraDeck : sideDeck;
            renderCards(deck, `${deckType}-deck-cards`, false, deckType);
            updateDeckCount(deckType);
        }

        // Mostrar modal com detalhes da carta
        function showModal(card) {
            const modalContent = document.getElementById('modal-content');
            modalContent.innerHTML = `
                <img src="${card.card_images[0].image_url}" alt="${card.name}">
                <div>
                    <h2>${card.name}</h2>
                    <p><strong>Atributo:</strong> ${card.attribute || 'N/A'}</p>
                    <p><strong>Tipo:</strong> ${card.type}</p>
                    <p><strong>ATK:</strong> ${card.atk || 'N/A'} <strong>DEF:</strong> ${card.def || 'N/A'}</p>
                    <p><strong>Efeito:</strong> ${card.desc}</p>
                </div>
            `;
            document.getElementById('modal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        // Fechar modal
        document.getElementById('overlay').addEventListener('click', () => {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        // Inicializa a busca de cartas
        document.getElementById('card-search-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const cardName = document.getElementById('card-name').value;
            const foundCards = searchCards(cardName);
            renderCards(foundCards, 'search-results', true, 'main');
        });

        // Carrega dados da API ao iniciar
        fetchCardData();
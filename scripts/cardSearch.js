let allCards = [];

// Carrega todos os dados das cartas quando a página é carregada
fetch('https://db.ygoprodeck.com/api/v7/cardinfo.php')
    .then(response => response.json())
    .then(data => {
        allCards = data.data;
        console.log("Dados de todas as cartas carregados.");
    })
    .catch(error => {
        console.error("Erro ao buscar dados das cartas:", error);
    });

document.getElementById('cardForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const cardName = document.getElementById('cardName').value.toLowerCase();
    const matchingCards = allCards.filter(c => c.name.toLowerCase().includes(cardName) || c.desc.toLowerCase().includes(cardName));

    const cardListDiv = document.getElementById('cardList');
    cardListDiv.innerHTML = '';

    if (matchingCards.length > 0) {
        matchingCards.forEach(card => {
            const cardDiv = document.createElement('div');
            cardDiv.classList.add('card');
            cardDiv.innerHTML = `<img src="${card.card_images[0].image_url}" alt="${card.name}" data-id="${card.id}">`;
            cardListDiv.appendChild(cardDiv);

            // Adiciona evento de clique para abrir o modal com detalhes da carta
            cardDiv.querySelector('img').addEventListener('click', () => openModal(card));
        });
    } else {
        cardListDiv.innerHTML = '<p>Nenhuma carta encontrada.</p>';
    }
});

// Função para abrir o modal com as informações da carta
function openModal(card) {
    document.getElementById('modalImage').src = card.card_images[0].image_url;
    document.getElementById('modalName').textContent = card.name;
    document.getElementById('modalType').textContent = card.type;
    document.getElementById('modalAttribute').textContent = card.attribute || 'N/A';
    document.getElementById('modalDesc').textContent = card.desc;

    document.getElementById('cardModal').style.display = 'flex';
}

// Fecha o modal quando o botão de fechar é clicado
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('cardModal').style.display = 'none';
});

// Fecha o modal ao clicar fora do conteúdo
window.addEventListener('click', function(event) {
    const modal = document.getElementById('cardModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});
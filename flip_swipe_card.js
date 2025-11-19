const cardStack = document.getElementById("card-stack");
let gameData = [];

// ===== Charger les cartes =====
fetch('load_cards.php')
  .then(res => res.json())
  .then(data => {
      if (!data || !data.length) return;
      gameData = data;
      // Créer les deux premières cartes pour superposition
      createCard(gameData[Math.floor(Math.random() * gameData.length)]);
      createCard(gameData[Math.floor(Math.random() * gameData.length)]);
  });

// ===== Créer une carte =====
function createCard(game) {
    const card = document.createElement("div");
    card.classList.add("flip-card");
    card.dataset.id = game.id_jeu || game.nom_jeu;

    card.innerHTML = `
        <div class="flip-card-inner">
            <div class="card card-front">
                <div class="card-top">
                    <h2>${game.nom_jeu}</h2>
                    <img src="${game.image}" alt="${game.nom_jeu}">
                </div>
                <div class="card-middle">
                    <p>${game.description}</p>
                </div>
                <button class="star-button">★</button>
                <div class="card-bottom">
                    <span>#RPG</span>
                </div>
            </div>
            <div class="card card-back">
                <p>${game.description}</p>
            </div>
        </div>
    `;

    cardStack.appendChild(card); // dernière carte = au-dessus
    enableSwipe(card);
    enableFlip(card.querySelector(".flip-card-inner"));
    stackAdjust();
}

// ===== Superposition carte du dessus + carte suivante =====
function stackAdjust() {
    const cards = Array.from(cardStack.querySelectorAll(".flip-card"));
    cards.forEach((card, i) => {
        const topIndex = cards.length - 1;
        const secondIndex = cards.length - 2;

        if (i === topIndex) { 
            // carte du dessus
            card.style.display = "block";
            card.style.zIndex = 10;
            card.style.top = "0";
            card.style.left = "0";
            card.style.transform = "translate(0,0)";
        } else if (i === secondIndex) {
            // carte suivante, invisible mais superposée
            card.style.display = "block";
            card.style.zIndex = 5;
            card.style.top = "0";
            card.style.left = "0";
            card.style.transform = "translate(0,0) scale(0.98)"; // petite réduction pour effet pile
        } else {
            // toutes les autres cartes
            card.style.display = "none";
        }
    });
}

// ===== Swipe =====
function enableSwipe(card) {
    let isDragging = false;
    let startX = 0;

    card.addEventListener("mousedown", start);
    card.addEventListener("touchstart", start);
    card.addEventListener("mousemove", drag);
    card.addEventListener("touchmove", drag);
    card.addEventListener("mouseup", end);
    card.addEventListener("touchend", end);

    function start(e) {
        isDragging = true;
        startX = e.touches ? e.touches[0].clientX : e.clientX;
        card.style.transition = "none";
    }

    function drag(e) {
        if (!isDragging) return;
        const x = (e.touches ? e.touches[0].clientX : e.clientX) - startX;
        // translation et rotation carte du dessus
        card.style.transform = `translate(${x}px,0) rotate(${x*0.1}deg)`;
    }

    function end(e) {
        if (!isDragging) return;
        isDragging = false;
        const endX = e.changedTouches ? e.changedTouches[0].clientX : e.clientX;
        const dx = endX - startX;

        card.style.transition = "transform 0.3s ease-out";

        if (dx > 100) {
            card.style.transform = `translate(1500px,0) rotate(20deg)`;
            sendSwipe('like', card.dataset.id);
            removeTopCard();
        } else if (dx < -100) {
            card.style.transform = `translate(-1500px,0) rotate(-20deg)`;
            sendSwipe('dislike', card.dataset.id);
            removeTopCard();
        } else {
            card.style.transform = "translate(0,0) rotate(0)";
        }
    }
}

// ===== Flip =====
function enableFlip(inner) {
    inner.addEventListener("click", e => {
        if (e.target.classList.contains("star-button")) return;
        inner.classList.toggle("flipped");
    });
}

// ===== Retirer carte du dessus et créer suivante =====
function removeTopCard() {
    const cards = Array.from(cardStack.querySelectorAll(".flip-card"));
    if (!cards.length) return;

    const topCard = cards[cards.length - 1];
    topCard.remove();

    // Ajouter une nouvelle carte derrière pour continuer l’infini
    if (!gameData.length) return;
    const randomGame = gameData[Math.floor(Math.random() * gameData.length)];
    createCard(randomGame);

    // Réajuster pile
    stackAdjust();
}

// ===== Envoyer swipe =====
function sendSwipe(action, id) {
    fetch(`${action}.php?id=${id}`)
        .then(res => res.json())
        .then(data => console.log(data))
        .catch(err => console.error(err));
}

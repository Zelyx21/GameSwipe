const cardStack = document.getElementById("card-stack");
let gameData = [];

// Charger les cartes depuis load_cards.php
fetch('load_cards.php')
  .then(res => res.json())
  .then(data => {
      if (!data || !data.length) return;
      gameData = data;
      // Crée 2 cartes initiales
      createCard(randomGame());
      createCard(randomGame());
  })
  .catch(err => console.error("Erreur chargement cartes :", err));

// Carte aléatoire
function randomGame() {
    return gameData[Math.floor(Math.random() * gameData.length)];
}

// Créer une carte
function createCard(game) {
    const card = document.createElement("div");
    card.classList.add("flip-card");
    card.dataset.id = game.id_jeu;

    card.innerHTML = `
        <div class="flip-card-inner">
            <div class="card card-front">
                <div class="card-top">
                    <h2>${game.nom_jeu}</h2>
                    <img src="${game.image}" alt="${game.nom_jeu}">
                </div>
                <div class="card-middle">
                    <p>${game.release_date}</p>
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

    // Bouton étoile
    const starBtn = card.querySelector(".star-button");
    starBtn.addEventListener("click", e => {
        e.stopPropagation(); // ne déclenche pas le flip
        sendSwipe(card.dataset.id, "favori");

        // Marquer la carte comme en suppression
        card.dataset.removing = "true";

        // Animation de sortie
        card.style.transition = "transform 0.4s ease-out, opacity 0.4s ease-out";
        requestAnimationFrame(() => {
            card.style.transform = "translate(1500px,-50px) rotate(20deg)";
            card.style.opacity = "0";
        });

        setTimeout(() => {
            card.remove();
            createCard(randomGame());
            stackAdjust();
        }, 400);
    });

    cardStack.appendChild(card);
    enableSwipe(card);
    enableFlip(card.querySelector(".flip-card-inner"));
    stackAdjust();
}

// Ajustement pile
function stackAdjust() {
    const cards = Array.from(cardStack.querySelectorAll(".flip-card"));
    const topIndex = cards.length - 1;
    const secondIndex = cards.length - 2;

    cards.forEach((card, i) => {
        if (card.dataset.removing === "true") return; // ignore la carte en suppression

        if (i === topIndex) {
            card.style.display = "block";
            card.style.zIndex = 10;
            card.style.transform = "translate(0,0)";
        } else if (i === secondIndex) {
            card.style.display = "block";
            card.style.zIndex = 5;
            card.style.transform = "translate(0,0) scale(0.98)";
        } else {
            card.style.display = "none";
        }
    });
}

// Swipe
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
            sendSwipe(card.dataset.id, 'like');
            removeCard(card);
        } else if (dx < -100) {
            card.style.transform = `translate(-1500px,0) rotate(-20deg)`;
            sendSwipe(card.dataset.id, 'dislike');
            removeCard(card);
        } else {
            card.style.transform = "translate(0,0) rotate(0)";
        }
    }
}

// Flip
function enableFlip(inner) {
    inner.addEventListener("click", e => {
        if (e.target.classList.contains("star-button")) return; // ignore star click
        inner.classList.toggle("flipped");
    });
}

// Supprimer une carte spécifique avec animation
function removeCard(card) {
    card.dataset.removing = "true";
    card.style.transition = "transform 0.3s ease-out, opacity 0.3s ease-out";
    requestAnimationFrame(() => {
        card.style.transform = `translate(${card.style.transform.includes('-') ? '-1500px' : '1500px'},0) rotate(${card.style.transform.includes('-') ? -20 : 20}deg)`;
        card.style.opacity = "0";
    });

    setTimeout(() => {
        card.remove();
        createCard(randomGame());
        stackAdjust();
    }, 300);
}

// Envoyer swipe
function sendSwipe(gameId, action) {
    console.log("Swipe envoyé :", gameId, action); 
    const formData = new FormData();
    formData.append("game_id", gameId);
    formData.append("action", action);

    fetch("swipe.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.json())
    .then(data => console.log("Réponse serveur :", data))
    .catch(err => console.error("Erreur swipe :", err));
}

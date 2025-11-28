document.addEventListener("DOMContentLoaded", () => {
    const popup = document.getElementById("popup-card");
    const popupInner = document.getElementById("popup-inner");
    const overlay = document.querySelector(".popup-overlay");
    const popupClose = document.getElementById("popup-close");

    // Ouvrir popup au clic sur une carte de la bibliothèque
    document.querySelectorAll(".library-card").forEach(card => {
        card.addEventListener("click", () => {
            const img = card.querySelector("img").src;
            const title = card.querySelector("h3").textContent;
            const description = card.dataset.description;
            const idJeu = card.dataset.id;

            // Vider le contenu existant
            popupInner.innerHTML = "";

            // Création structure popup flip
            const flipCard = document.createElement("div");
            flipCard.classList.add("flip-card");

            const flipCardInner = document.createElement("div");
            flipCardInner.classList.add("flip-card-inner");
            flipCardInner.dataset.id = idJeu;

            flipCardInner.innerHTML = `
                <div class="card-front">
                    <img src="${img}" alt="${title}">
                    <h2>${title}</h2>
                    <button class="star-button" title="Favoris">★</button>
                </div>
                <div class="card-back">
                    <p>${description}</p>
                </div>
            `;

            flipCard.appendChild(flipCardInner);
            popupInner.appendChild(flipCard);
            popup.classList.remove("popup-hidden");

            const starButton = flipCardInner.querySelector(".star-button");

            // -----------------------
            // Variables pour flip + swipe
            // -----------------------
            let startX = 0;
            let isDragging = false;
            let translateX = 0;
            let rotateY = 0; // rotation pour le flip

            // -----------------------
            // FLIP sur clic (ignore si clic sur étoile)
            // -----------------------
            flipCardInner.addEventListener("click", e => {
                if (e.target === starButton) return;
                rotateY = (rotateY === 0) ? 180 : 0;
                updateTransform();
            });

            // -----------------------
            // SWIPE
            // -----------------------
            flipCardInner.addEventListener("mousedown", startSwipe);
            flipCardInner.addEventListener("touchstart", startSwipe);
            flipCardInner.addEventListener("mousemove", dragSwipe);
            flipCardInner.addEventListener("touchmove", dragSwipe);
            flipCardInner.addEventListener("mouseup", endSwipe);
            flipCardInner.addEventListener("touchend", endSwipe);

            function startSwipe(e) {
                if (e.target === starButton) return;
                isDragging = true;
                startX = e.touches ? e.touches[0].clientX : e.clientX;
                flipCardInner.style.transition = "none";
            }

            function dragSwipe(e) {
                if (!isDragging) return;
                const currentX = e.touches ? e.touches[0].clientX : e.clientX;
                translateX = currentX - startX;
                updateTransform();
            }

            function endSwipe(e) {
                if (!isDragging) return;
                isDragging = false;
                flipCardInner.style.transition = "transform 0.3s ease-out";

                if (translateX > 100) { // swipe droit = like
                    translateX = 1500;
                    updateTransform();
                    envoyerSwipe("like");
                } else if (translateX < -100) { // swipe gauche = dislike
                    translateX = -1500;
                    updateTransform();
                    envoyerSwipe("dislike");
                } else {
                    translateX = 0;
                    updateTransform();
                }
            }

            function updateTransform() {
                flipCardInner.style.transform = `translateX(${translateX}px) rotateY(${rotateY}deg)`;
            }

            // -----------------------
            // CLIC sur étoile = favoris
            // -----------------------
            starButton.addEventListener("click", e => {
                e.stopPropagation();
                envoyerSwipe("favori");
            });

            // -----------------------
            // Fonction envoyer swipe au serveur
            // -----------------------
            function envoyerSwipe(action) {
                const gameId = flipCardInner.dataset.id;
                if (!gameId) return alert("ID du jeu manquant !");

                const formData = new FormData();
                formData.append("game_id", gameId);
                formData.append("action", action);

                fetch("swipe.php", { method: "POST", body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            popup.classList.add("popup-hidden");
                        } else {
                            alert("Erreur lors du swipe !");
                            console.error(data);
                        }
                    })
                    .catch(err => console.error("Erreur fetch :", err));
            }
        });
    });

    // -----------------------
    // FERMETURE du popup
    // -----------------------
    overlay.addEventListener("click", () => popup.classList.add("popup-hidden"));
    popupClose.addEventListener("click", () => popup.classList.add("popup-hidden"));
});

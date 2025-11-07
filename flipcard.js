const flipCard = document.querySelector('.flip-card-inner');

flipCard.addEventListener('click', (e) => {
    // Flip seulement si le clic n'est pas sur le bouton étoile
    if (!e.target.classList.contains('star-button')) {
        flipCard.classList.toggle('flipped');
    }
});
function starClicked() {
    // on pourra ici mettre n'importe quele action à effectuer sur le click de l'étoile 
    // Exemple : window.location.href = "https://exemple.com";
}
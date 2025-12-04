$(document).ready(function(){
    
    const burgerBtn = document.getElementById('burgerBtn');
    const burgerMenu = document.getElementById('burgerMenu');

    burgerBtn.addEventListener('click', () => {
    burgerMenu.classList.toggle('active');
    });
});
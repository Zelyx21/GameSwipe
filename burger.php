<style>
    .a {
        font: Kannitu,sans-serif;
    }
    .burger_bar {
        position: relative; /* parent du menu */
    }

    .burger_menu {
        display: none;
        flex-direction: column;
        background-color: #3C2C59;
        position: fixed;
        top: 25%;
        left: 0;
        width: 200px;
        padding: 1em;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        margin-top: 2em;
        margin-left: 2em;
    }

    .burger_menu a {
        color: #8874DF;
        text-decoration: none;
        padding: 0.5em 0;
        font-family: 'Kanit', sans-serif;
        font-size: 1.2em;
        text-align: center;
    }

    .burger_menu a:hover {
        color: #fff;
    }

    .burger_menu.active {
        display: flex;
    }
</style>

<div class="burger_bar">
    <button class="burger" id="burgerBtn">
        <img src="logo/burger_menu.svg" alt="burger menu">
    </button>
</div>

<div class="burger_menu" id="burgerMenu">
    <?php
    if (isset($_SESSION['client']) && !empty($_SESSION['client'])){
        echo '<a href="page_compte.php">PARAMETRE DU COMPTE</a>';
    };
    ?>
    <a href="stat.php">STATISTIQUES</a>
    <a href="contact.php">NOTRE EQUIPE</a>
</div>

<script>
    const burgerBtn = document.getElementById('burgerBtn');
    const burgerMenu = document.getElementById('burgerMenu');

    burgerBtn.addEventListener('click', () => {
    burgerMenu.classList.toggle('active');
    });
</script>
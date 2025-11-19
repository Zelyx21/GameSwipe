<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/favori.svg" type="image/svg">
    <title>GameSwipe</title>
</head>
<body>
    <header>
        <div class="top_bar">
            <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe" class="gameswipe"></a>
            <a href="inscription.php"><img src="logo/boutons/Nom=Inscrire, Etat=Normal.svg" alt="Inscrire" class="inscrire"></a>
            <a href="connecter.php"><img src="logo/boutons/Nom=Connecter, Etat=Normal.svg" alt="Connecter" class="connecter"></a>
            <a href="deconnexion.php"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>
            <a href="favori.php"><img src="logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori" class="favori"></a>
            <a href="like.php"><img src="logo/boutons/Nom=Like, Etat=Normal.svg" alt="Like" class="like"></a>
            <a href="dislike.php"><img src="logo/boutons/Nom=Dislike, Etat=Normal.svg" alt="Dislike" class="dislike"></a>
        </div>
    </header>

    <?php include 'burger.php'; ?>

    <div class="card-container">
        <div class="card-wrapper" id="card-stack">
            <!-- Cartes injectées via JS -->
        </div>
    </div>

    <script src="flip_swipe_card.js"></script>
</body>
</html>
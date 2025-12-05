<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/deconnecter.js"></script>
    <script src="js/filtre.js"></script>
    <title>GameSwipe</title>
</head>

<body>
    <header>
        <div id="overlay_filtres"></div> <!-- assombrit la page quand filtres activé -->
        <div id="sidebar_filtres">
            <h2 class="titre-sidebar">Filtres</h2>

                        <div class="bloc_filtre">
                <div class="filtre-header">Prix<span class="arrow">▲</span></div>
                <div class="filtre-options">
                    <label><input type="checkbox">Gratuit</label>
                    <label><input type="checkbox">1-10 euros</label>
                    <label><input type="checkbox">11-20 euros</label>
                    <label><input type="checkbox">21-40 euros</label>
                    <label><input type="checkbox">41-70 euros</label>
                    <label><input type="checkbox">>70 euros</label>
                </div>
            </div>

            <div class="bloc_filtre">
                <div class="filtre-header">Catégorie<span class="arrow">▲</span></div>
                <div class="filtre-options">
                    <label><input type="Solo"> Tag</label>
                    <label><input type="Coop"> Tag</label>
                    <label><input type="Multijoueur/PvP"> Tag</label>
                    <label><input type="MMO"> Tag</label>
                    <label><input type="VR"> Tag</label>
                </div>
            </div>

            <div class="bloc_filtre">
                <div class="filtre-header">Genre<span class="arrow">▲</span></div>
                <div class="filtre-options">
                    <label><input type="checkbox">Comptabilité</label>
                    <label><input type="checkbox">Action</label>
                    <label><input type="checkbox">Aventure</label>
                    <label><input type="checkbox">Animation & Modélisation</label>
                    <label><input type="checkbox">Production Audio</label>
                    <label><input type="checkbox">Casual</label>
                    <label><input type="checkbox">Design & Illustration</label>
                    <label><input type="checkbox">Accès anticipé</label>
                    <label><input type="checkbox">Éducation</label>
                    <label><input type="checkbox">Développement de jeux</label>
                    <label><input type="checkbox">Gore</label>
                    <label><input type="checkbox">Indépendant</label>
                    <label><input type="checkbox">Nudité</label>
                    <label><input type="checkbox">Retouche photo</label>
                    <label><input type="checkbox">RPG</label>
                    <label><input type="checkbox">Course</label>
                    <label><input type="checkbox">Contenu sexuel</label>
                    <label><input type="checkbox">Simulation</label>
                    <label><input type="checkbox">Formation logicielle</label>
                    <label><input type="checkbox">Sports</label>
                    <label><input type="checkbox">Stratégie</label>
                    <label><input type="checkbox">Utilitaires</label>
                    <label><input type="checkbox">Production vidéo</label>
                    <label><input type="checkbox">Violence</label>
                    <label><input type="checkbox">Publication Web</label>
                </div>
            </div>

            <div class="bloc_filtre">
                <div class="filtre-header">Système d'exploitation<span class="arrow">▲</span></div>
                <div class="filtre-options">
                    <label><input type="checkbox">Windows</label>
                    <label><input type="checkbox">Mac</label>
                    <label><input type="checkbox">Linux</label>
                </div>
            </div>
        </div>
        <div class="top_bar">
            <div class="left_group">
                <div class="gameswipe">
                    <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe"
                            class="gameswipe"></a>
                </div>
                <div class="boutons_compte">
                    <?php
                    if (!isset($_SESSION['client']) || empty($_SESSION['client'])) {
                        echo '<a href="compte/inscription.php"><img src="logo/boutons/Nom=Inscrire, Etat=Normal.svg" alt="Inscrire" class="inscrire"></a>
                    <a href="compte/connexion.php"><img src="logo/boutons/Nom=Connecter, Etat=Normal.svg" alt="Connecter" class="connecter"></a>';
                    } else {
                        echo '<a id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="right_group">
                <div class="boutons_categories">
                    <a href="classement/favori.php"><img src="logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori"
                            class="favori"></a>
                    <a href="classement/like.php"><img src="logo/boutons/Nom=Like, Etat=Normal.svg" alt="Like" class="like"></a>
                    <a href="classement/dislike.php"><img src="logo/boutons/Nom=Dislike, Etat=Normal.svg" alt="Dislike"
                            class="dislike"></a>
                </div>
                <div class="bouton_filtres">
                    <a><img src="logo/boutons/Nom=Filtres, Etat=Normal.svg" alt="Filtres" class="filtres"></a>
                </div>
            </div>
        </div>
    </header>

    <?php include 'burger.php'; ?>

    <div class="card-container">
        <div class="card-wrapper" id="card-stack">
        </div>
    </div>
</body>
<!-- Cartes injectées via JS -->
<script src="js/flip_swipe_card.js"></script>

</html>
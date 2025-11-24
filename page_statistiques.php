<?php
    session_start();

    if(!isset($_SESSION["client"])){
        header("Location: connexion.php");
        exit;
    }

    if(!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['token'];

    $nom = $_SESSION["client"]["nom"];
    $mail = $_SESSION["client"]["mail"];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <title>Profil</title>

</head>

<body>
    <header>
        <div class="top_bar">
            <div class="left_group">
                <div class="gameswipe">
                    <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe"
                            class="gameswipe"></a>
                </div>
                <div class="boutons_compte">
                    <?php
                    if (!isset($_SESSION['client']) || empty($_SESSION['client'])) {
                        echo '<a href="inscription.php"><img src="logo/boutons/Nom=Inscrire, Etat=Normal.svg" alt="Inscrire" class="inscrire"></a>
                    <a href="connexion.php"><img src="logo/boutons/Nom=Connecter, Etat=Normal.svg" alt="Connecter" class="connecter"></a>';
                    } else {
                        echo '<a id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="right_group">
                <div class="boutons_categories">
                    <a href="favori.php"><img src="logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori"
                            class="favori"></a>
                    <a href="test_like.php"><img src="logo/boutons/Nom=Like, Etat=Normal.svg" alt="Like" class="like"></a>
                    <a href="dislike.php"><img src="logo/boutons/Nom=Dislike, Etat=Normal.svg" alt="Dislike"
                            class="dislike"></a>
                </div>
                <div class="bouton_filtres">
                    <a><img src="logo/boutons/Nom=Filtres, Etat=Normal.svg" alt="Filtres" class="filtres"></a>
                </div>
            </div>
        </div>
    </header>

    <?php include 'burger.php'; ?>

    <h1 class="titre_haut">Vos Statistiques</h1>

    <div class="container">
        
    <!-- Colonne de gauche -->
        <div class="gauche">
            <div class="stats">
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Swipé :</p><p class="stat-value">47</p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Liké :<p class="stat-value">23</p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Disliké :</p><p class="stat-value">15</p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Favoris :</p><p class="stat-value">9</p></div>
            </div>
            <div class="last-conn">
                <div><p><strong>Dernière Connexion</strong></p></div>
                <div></p>• 21/10/2024 à 22h10, FRANCE</p></div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="droite">
            <div><p>Temps passé récemment</p></div>
            <div class="droite-clock"><img src="logo/horloge.svg" alt="horloge"></div>
        </div>
    </div>

</body>

</html>
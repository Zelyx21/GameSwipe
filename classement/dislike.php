<?php
session_start(); 
require '../fonctions.php';
$pdo = getBDD();

if (!isset($_SESSION['client'])) {
    header("Location: ../compte/connexion.php");
    exit;
}
$client_id = $_SESSION['client']['id'];

// Récupérer les jeux dislikés
$stmt = $pdo->prepare("
    SELECT * 
    FROM dislike dl
    JOIN jeux_videos j ON j.id_jeu = dl.id_jeu
    WHERE dl.id_client = ? 
");
$stmt->execute([$client_id]);
$likedGames = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeux likés - GameSwipe</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div class="top_bar">
        <div class="left_group">
            <div class="gameswipe">
                <a href="../accueil.php"><img src="../logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe" class="gameswipe"></a>
            </div>
            <div class="boutons_compte">
                <?php
                if (!isset($_SESSION['client']) || empty($_SESSION['client'])) {
                    echo '<a href="../compte/inscription.php"><img src="../logo/boutons/Nom=Inscrire, Etat=Normal.svg" alt="Inscrire" class="inscrire"></a>
                          <a href="../compte/connexion.php"><img src="../logo/boutons/Nom=Connecter, Etat=Normal.svg" alt="Connecter" class="connecter"></a>';
                } else {
                    echo '<a id="deconnecter"><img src="../logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>';
                }
                ?>
            </div>
        </div>
        <div class="right_group">
            <div class="boutons_categories">
                <a href="favori.php"><img src="../logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori" class="favori"></a>
                <a href="like.php"><img src="../logo/boutons/Nom=like, Etat=Normal.svg" alt="like" class="like"></a>
            </div>
        </div>
    </div>
</header>

<main class="library-container">
    <?php if (!empty($likedGames)): ?>
        <?php foreach ($likedGames as $jeu): ?>
        <div class="library-card" 
            data-id="<?= $jeu['id_jeu'] ?>" 
            data-description="<?= $jeu['description'] ?>">                
            <img src="<?= $jeu['image'] ?>" alt="<?= $jeu['nom_jeu']?>">
                <h3><?= $jeu['nom_jeu'] ?></h3>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color:white; text-align:center;">Vous n'avez encore aucun jeu liké.</p>
    <?php endif; ?>
</main>

<div id="popup-card" class="popup-hidden">
    <div class="popup-overlay"></div>
    <div class="popup-content">
        <div class="popup-flip-card">
            <div class="flip-card-inner" id="popup-inner">
                <div class="card-front" id="popup-front">
                    <img id="popup-image" src="" alt="">
                    <h2 id="popup-title"></h2>
                </div>
                <div class="card-back" id="popup-back">
                    <p id="popup-description"></p>
                </div>
            </div>
        </div>
        <button id="popup-close">✖</button>
    </div>
</div>

<script src="../js/popup-library.js"></script>
</body>
</html>
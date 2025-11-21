<?php
session_start();
$userId = $_SESSION['user_id'] ?? 0;

// Exemple : récupérer les jeux likés depuis la base de données
$dislikedGames = [
    ['id_jeu'=>1,'nom_jeu'=>'Zelda','description'=>'Un jeu d’aventure','image'=>'images/zelda.jpg'],
    ['id_jeu'=>2,'nom_jeu'=>'Mario','description'=>'Plateforme classique','image'=>'images/mario.jpg'],
    ['id_jeu'=>3,'nom_jeu'=>'Skyrim','description'=>'RPG épique','image'=>'images/skyrim.jpg'],
    ['id_jeu'=>4,'nom_jeu'=>'FIFA','description'=>'Jeu de foot','image'=>'images/fifa.jpg'],
    ['id_jeu'=>5,'nom_jeu'=>'Call of Duty','description'=>'FPS moderne','image'=>'images/cod.jpg'],
    // ... autant que nécessaire
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Like - GameSwipe</title>
    <link rel="stylesheet" href="css/like_dislike_fav.css">
</head>
<body>
    <header>
        <div class="top_bar">
            <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe"></a>
            <a href="deconnexion.php"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Déconnecter"></a>
            <a href="favori.php"><img src="logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori" class="favori"></a>
            <a href="like.php"><img src="logo/boutons/Nom=Like, Etat=Normal.svg" alt="Like" class="like"></a>

		</div>
    </header>

    <main class="library-container">
        <?php foreach($dislikedGames as $game): ?>
        <div class="library-card">
            <img src="<?= htmlspecialchars($game['image']) ?>" alt="<?= htmlspecialchars($game['nom_jeu']) ?>">
            <h3><?= htmlspecialchars($game['nom_jeu']) ?></h3>
            <p><?= htmlspecialchars($game['description']) ?></p>
        </div>
        <?php endforeach; ?>
    </main>
</body>
</html>

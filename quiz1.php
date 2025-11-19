<?php
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $token = $_SESSION['token'];
} else {
    $token = $_SESSION['token'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedGenres = $_POST['genres'] ?? [];

    foreach ($selectedGenres as $genre) {
        $stmt = $pdo->prepare("INSERT INTO quiz_answers (user_id, question, answer) VALUES (?, 'genre', ?)");
        $stmt->execute([$user_id, $genre]);
    }

    header("Location: quiz2.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/favori.svg" type="image/svg">
    <title>GameSwipe</title>

    <style>
        a{
            color: inherit;
            text-decoration: none;
        }
    </style>

</head>
<body>
    <header>
        <div class="top_bar">
            <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe" class="gameswipe"></a>
        </div>
    </header>
    <div class="quiz_container">
        <h2 class="quiz_question">À quelle(s) catégorie(s) de jeu ne voulez vous pas jouer ?</h2>
        <form method="POST">
        <div class="buttons_quiz1">  
                <button class="genre_btn" type="button" name="genres[]" value="Co-op">Co-op</button>
                <button class="genre_btn" type="button" name="genres[]" value="Solo">Solo</button>
                <button class="genre_btn" type="button" name="genres[]" value="Multiplayer">Multiplayer</button>
                <button class="genre_btn" type="button" name="genres[]" value="MMO">MMO</button>
                <button class="genre_btn" type="button" name="genres[]" value="VR">VR</button>
        </div>
        </form>
        <br/>
        <button class="btn-next"><a href="quiz2.html">Suivant</a></button>
    </div>

        <script>
             // javascript pour selectionner plusieurs boutons
            const genreButtons = document.querySelectorAll('.genre_btn');
            genreButtons.forEach(button => {
                button.addEventListener('click', () => {
                button.classList.toggle('selected');
                });
            });
        </script>

    <div class="bottom_bar"></div>
</body>
</html>
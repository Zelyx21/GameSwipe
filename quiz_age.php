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
        <h2 class="quiz_question">Quel est votre âge ?</h2>
        <form method="POST">
        <div class="buttons_quiz1">  
            <button type="button" class="genre_btn" data-value="Moins de 13 ans">Moins de 13 ans</button>
            <button type="button" class="genre_btn" data-value="13 à 17 ans">13 à 17 ans</button>
            <button type="button" class="genre_btn" data-value="18 à 24 ans">18 à 24 ans</button>
            <button type="button" class="genre_btn" data-value="25 à 34 ans">25 à 34 ans</button>
            <button type="button" class="genre_btn" data-value="35 à 44 ans">35 à 44 ans</button>
            <button type="button" class="genre_btn" data-value="45 ans et plus">45 ans et plus</button>
        </div>
        </form>
        <br/>
        <button class="btn-next"><a href="quiz1.php">Suivant</a></button>
    </div>
        <script>
             // javascript pour selectionner 1 seul bouton
                const genreButtons = document.querySelectorAll('.genre_btn');
                genreButtons.forEach(button => {
                    button.addEventListener('click', () => {
                    genreButtons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');
                        });
                });
        </script>
    <div class="bottom_bar"></div>
</body>
</html>
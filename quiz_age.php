<?php
session_start();

$host = "localhost";
$dbname = "gameswipe"; 
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion DB : " . $e->getMessage());
}
    $id_client = $_SESSION['id_client'] ?? null;

    if (!$id_client) {
        die("Erreur : Utilisateur non connecté.");
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedAge = $_POST['genres'] ?? null;

    if ($selectedAge) {
        $moins = 0;
        $plus13 = 0;
        $plus18 = 0;

        if ($selectedAge === "Moins de 13 ans") {
            $moins = 1;
        } elseif ($selectedAge === "13 à 17 ans") {
            $plus13 = 1;
        } elseif ($selectedAge === "18 ans et plus") {
            $plus18 = 1;
        }

        $stmt = $pdo->prepare("
            INSERT INTO quest0 (id_client, moins_de_13_ans, plus_de_13_ans, plus_de_18_ans)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                moins_de_13_ans = VALUES(moins_de_13_ans),
                plus_de_13_ans = VALUES(plus_de_13_ans),
                plus_de_18_ans = VALUES(plus_de_18_ans)
        ");
        $stmt->execute([$user_id, $moins, $plus13, $plus18]);
    }

    header("Location: quiz1.php");
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
            <input type="hidden" name="genres" id="selectedGenre">
            <div class="buttons_quiz1">  
                <button type="button" class="genre_btn" data-value="Moins de 13 ans">Moins de 13 ans</button>
                <button type="button" class="genre_btn" data-value="13 à 17 ans">13 à 17 ans</button>
                <button type="button" class="genre_btn" data-value="18 ans et plus">18 ans et plus</button>
            </div>
            <br/>
            <button type="submit" class="btn-next">Suivant</button>
        </form>
    </div>
        <script>
            const genreButtons = document.querySelectorAll('.genre_btn');
            const selectedInput = document.getElementById('selectedGenre');

            genreButtons.forEach(button => {
                button.addEventListener('click', () => {
                    genreButtons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');
                    selectedInput.value = button.dataset.value; // store selection
                });
            });
        </script>
    <div class="bottom_bar"></div>
</body>
</html>
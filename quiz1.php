<?php
session_start();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

$host = "localhost";
$dbname = "gameswipe"; 
$username = "root";      
$password = "";          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $selectedGenres = $_POST['genres'] ?? [];

    $allGenres = [
        'Co-op' => 'coop',
        'Solo' => 'solo',
        'Multiplayer' => 'multi',
        'MMO' => 'mmo',
        'VR' => 'vr'
    ];

    $values = [];
    foreach ($allGenres as $label => $column) {
        $values[$column] = in_array($label, $selectedGenres) ? 0 : 1;
    }

    $stmt = $pdo->prepare("
        INSERT INTO quest1 (id_client, solo, coop, multi, mmo, vr)
        VALUES (:id_client, :solo, :coop, :multi, :mmo, :vr)
        ON DUPLICATE KEY UPDATE
            solo = VALUES(solo),
            coop = VALUES(coop),
            multi = VALUES(multi),
            mmo = VALUES(mmo),
            vr = VALUES(vr)
    ");

    $id_client = $_SESSION['id_client'] ?? null;
    if (!$id_client) {
        die("Erruer : Utilisateur non connecté.");
    }

    $stmt->execute([
        ':id_client' => $id_client,
        ':solo' => $values['solo'],
        ':coop' => $values['coop'],
        ':multi' => $values['multi'],
        ':mmo' => $values['mmo'],
        ':vr' => $values['vr']
    ]);

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
                <button class="btn-next" type="submit">Suivant</button>
        </form>
        <br/>
    </div>

        <script>
             // javascript pour selectionner plusieurs boutons
            const genreButtons = document.querySelectorAll('.genre_btn');
            const form = document.querySelector('form');

            genreButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.classList.toggle('selected');

                    const inputClass = 'hiddenInput-' + button.value;

                    if (button.classList.contains('selected')) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'genres[]';
                        input.value = button.value;
                        input.classList.add(inputClass);
                        form.appendChild(input);

                    } else {
                        const existingInput = document.querySelector('.' + inputClass);
                        if (existingInput) existingInput.remove();
                    }
                });
            });
        </script>

    <div class="bottom_bar"></div>
</body>
</html>
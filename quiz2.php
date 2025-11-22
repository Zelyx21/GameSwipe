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
    die("Erreur connexion DB : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $selectedTimes = $_POST['times'] ?? [];

    $times = [
        'Moins de 2h' => '2h',
        '2h à 5h'     => '5h',
        '5h à 12h'    => '12h',
        '12h à 30h'   => '30h',
        'Plus de 30h' => 'plus'
    ];

    $values = [];
    foreach ($times as $label => $column) {
        $values[$column] = in_array($label, $selectedTimes) ? 1 : 0;
    }

    $id_client = $_SESSION['id_client'] ?? null;
    if (!$id_client) {
        die("Erreur : Utilisateur non connecté.");
    }

    $stmt = $pdo->prepare("
        INSERT INTO quest2 (id_client, `2h`, `5h`, `12h`, `30h`, `plus`)
        VALUES (:id_client, :2h, :5h, :12h, :30h, :plus)
        ON DUPLICATE KEY UPDATE
            `2h` = VALUES(`2h`),
            `5h` = VALUES(`5h`),
            `12h` = VALUES(`12h`),
            `30h` = VALUES(`30h`),
            `plus` = VALUES(`plus`)
    ");

    $stmt->execute([
        ':id_client' => $id_client,
        ':2h'        => $values['2h'],
        ':5h'        => $values['5h'],
        ':12h'       => $values['12h'],
        ':30h'       => $values['30h'],
        ':plus'      => $values['plus']
    ]);

    header("Location: accueil.php");
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
        <h2 class="quiz_question">Combien de temps cherchez-vous à passer sur un jeu ?</h2>
    <form method="POST">
        <div class="buttons_quiz1">
            <button type="button" class="genre_btn" value="Moins de 2h">Moins de 2h</button>
            <button type="button" class="genre_btn" value="2h à 5h">2h à 5h</button>
            <button type="button" class="genre_btn" value="5h à 12h">5h à 12h</button>
            <button type="button" class="genre_btn" value="12h à 30h">12h à 30h</button>
            <button type="button" class="genre_btn" value="Plus de 30h">Plus de 30h</button>
        </div>
        <br>
        <button type="submit" class="btn-next">Valider</button>
    </form>
    </div>
    <div class="bottom_bar"></div>

    <script>
        const buttons = document.querySelectorAll('.genre_btn');
        const form = document.querySelector('form');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('selected');
                const inputClass = 'hiddenInput-' + button.value.replace(/\s+/g, '');

                if (button.classList.contains('selected')) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'times[]';
                    input.value = button.value;
                    input.classList.add(inputClass);
                    form.appendChild(input);
                } else {
                    const existing = document.querySelector('.' + inputClass);
                    if (existing) existing.remove();
                }
            });
        });
    </script>
</body>
</html>
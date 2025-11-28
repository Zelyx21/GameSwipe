<?php
session_start();
require 'fonctions.php';
$bdd = getBDD(); // PDO depuis ta fonction getBDD()

// Récupérer l'ID du client depuis la session
$id_client = $_SESSION['client']['id'];

// Définir les catégories à afficher dans le radar
$categories = [
    "Co-op" => "Co-op",
    "MMO" => "MMO",
    "Mods" => "Mods",
    "Multi-player" => "Multi-player",
    "PvP" => "PvP",
    "Trading Cards" => "Trading Cards",
    "Single-player" => "Single-player",
    "Controller" => "Controller",
    "VR" => "VR"
];

// Récupérer le nombre de likes par catégorie pour ce client
$data = [];
foreach($categories as $label => $keyword){
    $sql = "
        SELECT COUNT(DISTINCT l.id_jeu) AS nb_likes
        FROM `like` l
        JOIN a_category ac ON l.id_jeu = ac.id_jeu
        JOIN category c ON ac.id_cat = c.id_cat
        WHERE l.id_client = :id_client
        AND c.nom_cat LIKE :keyword
    ";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ':id_client' => $id_client,
        ':keyword'   => "%$keyword%"
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data[] = [
        "categorie" => $label,
        "likes"     => (int)$row['nb_likes']
    ];
}
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<title>Préférences utilisateur — Radar</title>
<style>
body { font-family: Arial, sans-serif; padding: 40px; text-align: center; }
canvas { margin: auto; display: block; }
</style>
</head>
<body>

<h2>📊 Préférences de l'utilisateur</h2>
<canvas id="radar"></canvas>

<script>
// Données PHP injectées dans JS
const dataSQL = <?php echo json_encode($data); ?>;
const labels = dataSQL.map(d => d.categorie);
const values = dataSQL.map(d => d.likes);
const maxLikes = Math.max(...values);

const canvas = document.getElementById("radar");
const ctx = canvas.getContext("2d");

const cx = canvas.width / 2;
const cy = canvas.height / 2;
const radius = 250;
const total = labels.length;

// Dessiner la grille du radar
function drawGrid() {
    ctx.clearRect(0,0,canvas.width,canvas.height);

    ctx.strokeStyle = "#ddd";
    ctx.lineWidth = 1;

    for (let level = 1; level <= 5; level++) {
        const r = radius * (level / 5);
        ctx.beginPath();
        for (let i = 0; i < total; i++) {
            const angle = (2 * Math.PI / total) * i - Math.PI/2;
            const x = cx + Math.cos(angle) * r;
            const y = cy + Math.sin(angle) * r;
            i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
        }
        ctx.closePath();
        ctx.stroke();
    }

    // Axes et labels
    ctx.strokeStyle = "#aaa";
    ctx.fillStyle = "#000";
    ctx.font = "14px Arial";

    labels.forEach((label, i) => {
        const angle = (2 * Math.PI / total) * i - Math.PI/2;
        const x = cx + Math.cos(angle) * radius;
        const y = cy + Math.sin(angle) * radius;

        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(x, y);
        ctx.stroke();

        const lx = cx + Math.cos(angle) * (radius + 20);
        const ly = cy + Math.sin(angle) * (radius + 20);
        ctx.textAlign = Math.cos(angle) > 0.1 ? "left" : Math.cos(angle) < -0.1 ? "right" : "center";
        ctx.fillText(label, lx, ly);
    });
}

// Dessiner les données du radar
function drawData() {
    ctx.beginPath();
    ctx.fillStyle = "rgba(0,150,255,0.2)";
    ctx.strokeStyle = "#0096FF";
    ctx.lineWidth = 2;

    for (let i = 0; i < total; i++) {
        const v = values[i] / maxLikes;
        const angle = (2 * Math.PI / total) * i - Math.PI/2;
        const x = cx + Math.cos(angle) * radius * v;
        const y = cy + Math.sin(angle) * radius * v;
        i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y);
    }

    ctx.closePath();
    ctx.fill();
    ctx.stroke();
}

// Affichage final
drawGrid();
drawData();
</script>

</body>
</html>

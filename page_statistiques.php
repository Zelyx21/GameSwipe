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
    
    $id = $_SESSION["client"]["id"];
    $nom = $_SESSION["client"]["nom"];

    require 'fonctions.php';
    $bdd = getBDD();

    // Recherche des données standars
    $sql = "SELECT (SELECT COUNT(*) FROM `like` WHERE id_client = :id_client) AS nbr_like,
        (SELECT COUNT(*) FROM dislike WHERE id_client = :id_client) AS nbr_dislike,
        (SELECT COUNT(*) FROM favori WHERE id_client = :id_client) AS nbr_favori,
        (SELECT COUNT(*) FROM `like` WHERE id_client = :id_client) +
        (SELECT COUNT(*) FROM dislike WHERE id_client = :id_client) +
        (SELECT COUNT(*) FROM favori WHERE id_client = :id_client) AS total_swipe;";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':id_client' => $id]);
    $ligne = $stmt->fetch();

    $like = $ligne['nbr_like'];
    $dislike = $ligne['nbr_dislike'];
    $favori = $ligne['nbr_favori'];
    $total = $ligne['total_swipe'];

    $sql = "SELECT * FROM client WHERE id_client = :id_client;";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':id_client' => $id]);
    $ligne = $stmt->fetch();

    $creation_co = $ligne['premiere_co'];

    // Recherche des données pour le graphique
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
        ':id_client' => $id,
        ':keyword'   => "%$keyword%"
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $data[] = [
        "categorie" => $label,
        "likes"     => (int)$row['nb_likes']
    ];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <title>Profil</title>

    <style>
        .droite canvas {
      width: 100%;
      height: 100%;
      max-width: 100%;
      max-height: 100%;
  }
    </style>

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
                        echo '<a href="testgraphe.php" id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="right_group">
                <div class="boutons_categories">
                    <a href="favori.php"><img src="logo/boutons/Nom=Favori, Etat=Normal.svg" alt="Favori"
                            class="favori"></a>
                    <a href="like.php"><img src="logo/boutons/Nom=Like, Etat=Normal.svg" alt="Like" class="like"></a>
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
                    Cartes Swipé :</p><p class="stat-value"><?php echo $total; ?></p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Liké :<p class="stat-value"><?php echo $like; ?></p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Disliké :</p><p class="stat-value"><?php echo $dislike; ?></p></div>
                <div class="stat-row"><p class="stat-label">
                    <img src="logo/horloge.svg" alt="Favori">
                    Cartes Favoris :</p><p class="stat-value"><?php echo $favori; ?></p></div>
            </div>
            <div class="last-conn">
                <div><p><strong>Date de création du Compte :</strong></p></div>
                <div></p><?php echo $creation_co; ?></p></div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="droite">
            <div><p>Temps passé récemment</p></div>
                <div class="droite-clock"><img src="logo/horloge.svg" alt="horloge"></div>
                Un camembert peut etre sympa
                <canvas id="radar"></canvas>
            </div>
    </div>

    <script>
// Données PHP injectées dans JS
const dataSQL = <?php echo json_encode($data); ?>;
const labels = dataSQL.map(d => d.categorie);
const values = dataSQL.map(d => d.likes);
const maxLikes = Math.max(...values);

const canvas = document.getElementById("radar");
const ctx = canvas.getContext("2d");

// Récupérer la taille du div parent
const parent = canvas.parentElement;
canvas.width = parent.clientWidth;
canvas.height = parent.clientHeight;

const cx = canvas.width / 2;
const cy = canvas.height / 2;

// Rayon : laisser une marge pour les labels
const radius = Math.min(cx, cy) * 0.7; 

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
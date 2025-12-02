<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/deconnecter.js"></script>
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
                    <a href="deconnecter.php" id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>
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
            </div>
        </div>
    </header>

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

        if(!isset($_SESSION["client"]["id"])){
            echo '<h1>Erreur de connexion : Veuillez vous reconnecter</h1>';
            exit;
        }
        
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
            "Multi-player" => "Multi-player",
            "PvP" => "PvP",
            "Single-player" => "Single-player",
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
                <div class="radar-wrap">
                    <canvas id="radar"></canvas>
                </div>
            </div>
    </div>

    <script>
    // Données PHP injectées dans JS (déjà calculées côté PHP)
    const dataSQL = <?php echo json_encode($data); ?>;
    const labels = dataSQL.map(d => d.categorie);
    const values = dataSQL.map(d => d.likes);

    // sécurité : éviter -Infinity si toutes les valeurs sont à 0
    const maxLikes = values.length ? Math.max(...values) || 1 : 1;

    const canvas = document.getElementById("radar");
    const wrapper = canvas.parentElement;
    const ctx = canvas.getContext("2d");

    // Fonction qui gère le resize + redraw
    function resizeAndDraw(){
    const size = Math.min(wrapper.clientWidth, wrapper.clientHeight);
    const dpr = window.devicePixelRatio || 1;

    canvas.width = size * dpr;
    canvas.height = size * dpr;
    canvas.style.width = size + "px";
    canvas.style.height = size + "px";
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

    const cx = size / 2;
    const cy = size / 2;
    const radius = size * 0.35; // bien centré avec marge

    drawRadar(ctx, cx, cy, radius, labels, values, maxLikes, size);
    }

    // Offset dynamique des labels
    function sizeLabelOffset(radius){
    return Math.max(6, radius * 0.1);
    }

    // Fonction pour écrire du texte sur plusieurs lignes
    function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
    const words = text.split(" ");
    let line = "";
    let offsetY = 0;

    for (let i = 0; i < words.length; i++) {
        const testLine = line + words[i] + " ";
        const testWidth = ctx.measureText(testLine).width;

        if (testWidth > maxWidth && i > 0) {
        ctx.fillText(line, x, y + offsetY);
        line = words[i] + " ";
        offsetY += lineHeight;
        } else {
        line = testLine;
        }
    }
    ctx.fillText(line, x, y + offsetY);
    }

    // Fonction principale de dessin du radar
    function drawRadar(ctx, cx, cy, radius, labels, values, maxLikes, size){
    const total = labels.length;
    ctx.clearRect(0, 0, size, size);

    // === GRILLE ===
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

    // === AXES + LABELS ===
    ctx.strokeStyle = "#aaa";
    ctx.fillStyle = "#000";

    labels.forEach((label, i) => {
        const angle = (2 * Math.PI / total) * i - Math.PI / 2;
        const x = cx + Math.cos(angle) * radius;
        const y = cy + Math.sin(angle) * radius;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.lineTo(x, y);
        ctx.stroke();

        const lx = cx + Math.cos(angle) * (radius + sizeLabelOffset(radius));
        const ly = cy + Math.sin(angle) * (radius + sizeLabelOffset(radius));

        // === Gestion de la taille de police selon longueur ===
        let fontSize = Math.max(9, Math.round(size * 0.03));
        if (label.length >= 10) fontSize *= 0.9;

        ctx.font = fontSize + "px Arial";
        const maxWidth = size * 0.22;
        const lineHeight = fontSize + 2;
        
        ctx.textAlign = Math.cos(angle) > 0.15 ? "left" : Math.cos(angle) < -0.15 ? "right" : "center";

        wrapText(ctx, label, lx, ly - fontSize/2, maxWidth, lineHeight);
    });

    // === DONNÉES POLYGONE ===
    ctx.beginPath();
    ctx.fillStyle = "rgba(0,150,255,0.25)";
    ctx.strokeStyle = "#0096FF";
    ctx.lineWidth = Math.max(1.5, Math.round(size * 0.006));

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

    // Observer pour redessiner si le div change (responsive)
    const ro = new ResizeObserver(() => resizeAndDraw());
    ro.observe(wrapper);

    // Render au chargement et resize
    window.addEventListener('load', resizeAndDraw);
    window.addEventListener('resize', resizeAndDraw);
</script>



</body>

</html>
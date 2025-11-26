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

    $nom = $_SESSION["client"]["nom"];
    $mail = $_SESSION["client"]["mail"];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/modification_compte.js"></script>
    <script src="js/autre_bouton_profil.js"></script>
    <title>Profil</title>

</head>

<body class="body_profil">
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
                <div class="bouton_filtres">
                    <a><img src="logo/boutons/Nom=Filtres, Etat=Normal.svg" alt="Filtres" class="filtres"></a>
                </div>
            </div>
        </div>
    </header>

    <?php include 'burger.php'; ?>
    
    <!-- Affichage de la photo de profil est du nom de l'utilisateur -->
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="../Donia/image/brocciu.jpg" alt="Avatar Dodo">
            <div class="camera-icon">
                <img src="logo/photo.svg" alt="Camera" width="25">
            </div>
        </div>
        <div class="profile-welcome">
            <h3>Bienvenue <?php echo $nom; ?></h3>
        </div>
    </div>

    <!-- Affichage des informations de l'utilisateur et des modifications possibles -->
    <div class="profile-modif">

        <!-- Colonne de gauche -->
        <div class="column">
            <form id="formulaire">
                <label for="username">Nom d’utilisateur</label>

                <div class="bouton-input-modif">
                    <input type="text" id="username" name="nom" value="<?php echo $nom; ?>" readonly>
                    <button type="button" class="btn_secondaire">Modifier</button>
                </div>

                <label for="email">Adresse e-mail</label>

                <div class="bouton-input-modif">
                    <input type="email" id="email" name="mail" value="<?php echo $mail; ?>" readonly>
                    <button type="button" class="btn_secondaire">Modifier</button>
                </div>

                <label for="password">Mot de passe</label>

                <div class="bouton-input-modif">
                    <input type="password" id="password" name="mdp" value="********" readonly>
                    <button type="button" class="btn_secondaire">Modifier</button>
                </div>
                <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            </form>
        </div>

        <!-- Colonne de droite -->
        <div class="column">
            <div class="bouton-input-modif">
                <button type="button" id="reset-quiz" class="btn_secondaire">Réeffectuer le <br> questionnaire</button>
                <p>Réeffectue le questionnaire de préférence</p>
            </div>

            <div class="bouton-input-modif">
                <button  type="button" id="reset-historique" class="btn_secondaire" >Supprimer <br> l’historique de mon <br> compte</button>
                <p>Supprime l'historique des jeux que vous avez Love, Like et Dislike</p>
            </div>

            <div class="bouton-input-modif">
                <button class="btn-red" id="supprimer-compte">Supprimer mon <br> compte</button>
                <p class="warning">Cette action est irréversible</p>
            </div>
        </div>
    </div>

</body>
<script>
    document.getElementById("reset-quiz").addEventListener("click", function(){
        window.location.href = "reset_quiz.php";
    });
    document.getElementById("reset-historique").addEventListener("click", function(){
    if(confirm("Êtes-vous sûr de vouloir supprimer tout votre historique ? Cette action est irréversible !")){
        window.location.href = "supprimer_historique.php";
    }
});
</script>
</html>
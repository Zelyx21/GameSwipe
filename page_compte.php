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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/modification_compte.js"></script>
    <title>Profil</title>

    <style>

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column; /* empile header et .profile-modif */
            min-height: 100vh;      /* s'assure que le body prend tout l'écran */
        }

        /* Profil image et premier div */
        h3{
            color: #fff;
        }

        .profile-header {
            background-color: #1b1b3a;
            text-align: center;
            padding: 3em 1em 1em 1em;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 2em;
            color: #9d87e8;
            margin-bottom: 0;
        }

        .profile-avatar {
            margin-top: 0;
            position: relative;
            display: inline-block;
            margin-top: -6em;
        }

        .profile-avatar img {
            width: 200px;   /* largeur plus grande */
            height: 200px;  /* hauteur plus grande */
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
        }

        .profile-avatar .camera-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #fff;
            border-radius: 50%;
            padding: 5px;
        }

        .profile-avatar .camera-icon img {
            width: 30px;
            height: 30px;
            display: block;
        }

        .profile-welcome {
            margin-top: 0.5em;
            font-size: 1.2em;
        }

        

        /* Boutons */
        button{
            font-size: 1em;
        }

        .btn {
            padding: 0.7em 1em;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5em;
        }

        .btn-autre {
            padding: 0.7em 1em;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5em;
            min-width: 43%; /* taille fixe harmonisée */
            min-height: 10%; /* même hauteur */
            margin-right: 5%;
        }

        .bouton-modif {
            background-color: #6a44c3;
            color: #fff;
        }

        .bouton-red {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-autre:hover {
            opacity: 0.9;
        }



        /* div des modifs */
        .profile-modif{
            display: flex;
            flex-direction: row;
            flex: 1;                 /* prend tout l’espace restant sous le header */
            background-color: #CFBFEE;
            display: flex;           /* active flexbox pour aligner les colonnes */
            gap: 2%;                 /* espace entre les colonnes */
            width: 100%;             /* prend toute la largeur de l’écran */
            box-sizing: border-box;  /* inclut padding et bordures dans la largeur */
        }

        .profile-modif .column {
            flex: 1;                 /* chaque colonne prend la même largeur */
            min-width: 0;            /* pour éviter le débordement des contenus */
        }

        .column{
            display: flex;
            flex-direction: column;
            margin-top: 2%;
            margin-left: 5%;
            margin-right: 5%;
            gap: 2%;
        }

        .profile-modif .column:nth-child(2) {
            gap: 6%;
        }

        .profile-modif input {
            padding: 1em;
            font-size: 1em;
            border-radius: 10px;
            border: none;
            margin-right: 1em;
            width: 30em;
        }

        .bouton-input-modif{
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        label{
            color: #101010;
            font-size: 1.2em;
            font-weight: 500;
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
                    <a id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>
                    </div>
            </div>
        </div>
    </header>

    <?php include 'burger.php'; ?>

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

    <div class="profile-modif">
        <div class="column">
            <form id="formulaire">
                <label for="username">Nom d’utilisateur</label>

                <div class="bouton-input-modif">
                    <input type="text" id="username" name="nom" value="<?php echo $nom; ?>" readonly>
                    <button type="button" class="btn bouton-modif">Modifier</button>
                </div>

                <label for="email">Adresse e-mail</label>

                <div class="bouton-input-modif">
                    <input type="email" id="email" name="mail" value="<?php echo $mail; ?>" readonly>
                    <button type="button" class="btn bouton-modif">Modifier</button>
                </div>

                <label for="password">Mot de passe</label>

                <div class="bouton-input-modif">
                    <input type="password" id="password" name="mdp" value="********" readonly>
                    <button type="button" class="btn bouton-modif">Modifier</button>
                </div>
                <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            </form>
        </div>
        <div class="column">
            <div class="bouton-input-modif">
                <button type="button" class="btn-autre bouton-modif">Réeffectuer le <br> questionnaire</button>
                <p>Réeffectue le questionnaire de préférence</p>
            </div>

            <div class="bouton-input-modif">
                <button type="button" class="btn-autre bouton-modif">Supprimer <br> l’historique de mon <br> compte</button>
                <p>Supprime l'historique des jeux que vous avez Love, Like et Dislike</p>
            </div>

            <div class="bouton-input-modif">
                <button type="button" class="btn-autre bouton-red">Supprimer mon <br> compte</button>
                <p class="warning">Cette action est irréversible</p>
            </div>
        </div>
    </div>

</body>
</html>
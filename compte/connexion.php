<?php
    session_start();
    $_SESSION['token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/connexion.js"></script>
    <title>GameSwipe</title>

</head>

<body>
    <header>
        <div class="top_bar">
            <div class="left_group">
                <div class="gameswipe">
                    <a href="../accueil.php"><img src="../logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe"
                            class="gameswipe"></a>
                </div>
            </div>
        </div>
        <div>
            <div class="inscription_bloc">
                <h2>Connexion</h2>
                <form method="POST" id="form" class="formulaire">

                    <label>Adresse e-mail ou nom d'utilisateur</label>
                    <input type="text" id="mail_nom" name="mail_nom">

                    <label>Mot de passe</label>
                    <input type="password" id="mdp" name="mdp">

                    <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">

                    <a href="inscription.php" class="btn_secondaire">Créer un compte</a>
                    <button type="submit" id="btn_submit">Se connecter</button>

                </form>
                <p id="message_form"></p>
            </div>
        </div>
        <div class="bottom_bar"></div>
    </header>


</body>

</html>
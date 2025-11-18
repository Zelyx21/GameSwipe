<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/inscription.js"></script>
    <title>Inscription - GameSwipe</title>

</head>

<body>
    <header>
        <div class="top_bar">
            <div class="left_group">
                <div class="gameswipe">
                    <a href="accueil.php"><img src="logo/boutons/Nom=GameSwipe, Etat=Normal.svg" alt="GameSwipe"
                            class="gameswipe"></a>
                </div>
            </div>
        </div>
        <div>
            <div class="inscription_bloc">
                <h2>Créer un compte</h2>
                <form method="POST" id="form" class="formulaire">

                    <label>Nom d'utilisateur</label>
                    <input type="text" id="nom" name="nom" required>
                    <p id="message_nom"></p>

                    <label>Adresse e-mail</label>
                    <input type="text" id="mail" name="mail" required>
                    <p id="message_mail"></p>

                    <label>Mot de passe</label>
                    <input type="password" id="mdp1" name="mdp1" required>
                    <p id="message_mdp1"></p>

                    <label>Confirmer le mot de passe</label>
                    <input type="password" id="mdp2" name="mdp2" required>
                    <p id="message_mdp2"></p>

                    <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>">

                    <a href="connexion.php" class="btn_secondaire">Se connecter</a>
                    <button type="submit" id="btn_submit">S'inscrire</button>

                </form>
                <p id="message_form"></p>
            </div>
        </div>
        <div class="bottom_bar"></div>
    </header>


</body>

</html>
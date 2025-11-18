<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>GameSwipe</title>

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
                <h2>Connexion</h2>
                <form method="POST" id="form" class="formulaire">

                    <label>Adresse e-mail ou nom d'utilisateur</label>
                    <input type="text" id="mail_nom" name="email_utilisateur" required>

                    <label>Mot de passe</label>
                    <input type="password" id="mdp" name="mdp1_utilisateur" required>

                    <a href="inscription.php" class="btn_secondaire">Créer un compte</a>
                    <button type="submit" id="btn_submit">Se connecter</button>

                </form>
            </div>
        </div>
        <div class="bottom_bar"></div>
    </header>


</body>

</html>
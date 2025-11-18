<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
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
                    <input type="text" id="name" name="nom_utilisateur" required>

                    <label>Adresse e-mail</label>
                    <input type="email" id="mail" name="email_utilisateur" required>

                    <label>Mot de passe</label>
                    <input type="password" id="mdp1" name="mdp1_utilisateur" required>

                    <label>Confirmer le mot de passe</label>
                    <input type="password" id="mdp2" name="mdp2_utilisateur" required>

                    <a href="connecter.php"><button>Se connecter</button></a>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
        <div class="bottom_bar"></div>
    </header>


</body>

</html>
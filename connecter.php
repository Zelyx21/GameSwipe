<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/favori.svg" type="image/svg">
    <title>GameSwipe</title>

    <style>
        .bottom_bar{
            position: fixed;
            background-color: #493C60;
            bottom: 0;
            width: 100%;
            height: 14%;
        }

        .inscription_bloc{
            display: flex;
            flex-direction: column;
            background-color: #CFBFEE;
            border-radius: 5%;
            width: 33%;
            height: 26em;
            margin: 5% auto;
        }
    </style>

</head>
<body>
    <header>
        <div class="top_bar">
            <button class="gameswipe"><a href="accueil.php">GameSwipe</a></button>
        </div>
        <div>
            <div class="inscription_bloc">
                <h2>Créer un compte</h2>
                <p class="label">Adresse e-mail ou nom d'utilisateur</p>
                <input type="text" name="email_utilisateur">
                <p class="label">Mot de passe</p>
                <input type="text" name="mdp1_utilisateur">
                <div class="fin_inscription_bloc">
                    <button class="button_bar_inscription"><a href="inscription.html">Créer un compte</a></button>
                    <button class="button_bar_inscription"><a href="accueil.php">Se connecter</a></button>
                </div>
            </div>
        </div>
        <div class="bottom_bar"></div>
    </header>
    
    
</body>
</html>
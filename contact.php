<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/favori.svg" type="image/svg">
    <title>GameSwipe</title>

    <style>
        .burger_bar_contact {
            display: flex;
            background-color: #3C2C59;
            align-items: center;
            position: relative;
        }

        .text_contact{
            margin-left: 7.5em;
            margin-right: 7.5em;
            font-size: 1.8em;
            line-height: 1.6;
            color: #8874DF;
            margin-top: 1em;
            text-indent: 2em;
        }

        .text_contact.intro {
            display: block;
            text-align: center;
        }
    </style>

</head>
<body class="burger-bg">
    <header>
        <div class="top_bar">
            <button class="gameswipe"><a href="accueil.php">GameSwipe</a></button>
            
            <button class="button_bar"><a href="inscription.html">S'inscrire</a></button>
            <button class="button_bar"><a href="connecter.html">Se connecter</a></button>

        </div>
    </header>
    
    <?php include 'burger.php'; ?>
    
    <p class="text_contact intro">Bonjour,</p>
    <p class="text_contact">
        Nous sommes un groupe de quatre étudiantes en troisième année de licence MIASHS à l'université Paul Valéry, Montpellier.
    </p>

    <p class="text_contact">
        Nous avons imaginé et conçu ce site web durant tout un semestre dans le cadre de notre module "Gestion de Projet".
    </p>

    <p class="text_contact">
        Nous remercions nos enseignants pour leur aide et leur accompagnement tout au long de ce semestre pour l'élaboration de ce projet.
    </p>

    <p class="text_contact">
        Pour toute demande, vous pouvez nous contacter à l'adresse mail dédiée : blablabli@bla.com.
    </p>

</body>
</html>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>GameSwipe</title>

    <style>
        .burger_bar_contact {
            display: flex;
            background-color: #3C2C59;
            align-items: center;
            position: relative;
        }

        .text_contact {
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
                        echo '<a id="deconnecter"><img src="logo/boutons/Nom=Déconnecter, Etat=Normal.svg" alt="Deconnecter" class="deconnecter"></a>';
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

    <p class="text_contact intro">Bonjour,</p>
    <p class="text_contact">
        Nous sommes un groupe de quatre étudiantes en troisième année de licence MIASHS à l'université Paul Valéry,
        Montpellier.
    </p>

    <p class="text_contact">
        Nous avons imaginé et conçu ce site web durant tout un semestre dans le cadre de notre module "Gestion de
        Projet".
    </p>

    <p class="text_contact">
        Nous remercions nos enseignants pour leur aide et leur accompagnement tout au long de ce semestre pour
        l'élaboration de ce projet.
    </p>

    <p class="text_contact">
        Pour toute demande, vous pouvez nous contacter à l'adresse mail dédiée : blablabli@bla.com.
    </p>

</body>

</html>
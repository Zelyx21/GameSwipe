<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="logo/favori.svg" type="image/svg">
    <title>Profil</title>

    <style>
        p{
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
            margin-top: -5em;
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

        .profile-welcome {
            margin-top: 0.5em;
            font-size: 1.2em;
        }

        .profile-content {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 37%;
            background-color: #cfc0f2;
            padding: 2em;
            display: flex;
            flex-direction: column;
            gap: 1.5em;
            margin-bottom: 0;
        }

        .profile-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .profile-row label {
            flex-basis: 100%;
            font-weight: 600;
            margin-bottom: 0.5em;
            color: #4b3a7a;
        }

        .profile-row input {
            padding: 0.7em;
            border-radius: 10px;
            border: none;
            flex: 1 1 250px;
            margin-right: 1em;
        }

        .btn {
            padding: 0.7em 1em;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5em;
        }

        .btn-purple {
            background-color: #6a44c3;
            color: #fff;
        }

        .btn-red {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .row-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5em;
            flex: 1 1 250px;
        }

        .row-actions p {
            font-size: 0.9em;
            margin: 0;
            color: #4b3a7a;
        }

        .row-actions p.warning {
            color: #e74c3c;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>
        <div class="top_bar">
            <button class="gameswipe"><a href="accueil.php">GameSwipe</a></button>
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
            <p>Bienvenue Dodo</p>
        </div>
    </div>

    <div class="profile-content">
        <div class="profile-row">
            <div style="flex:1;">
                <label for="username">Nom d’utilisateur</label>
                <input type="text" id="username" value="Dodo">
            </div>
            <button class="btn btn-purple">Modifier</button>
            <div class="row-actions">
                <button class="btn btn-purple">Réeffectuer le questionnaire</button>
                <p>Réeffectue le questionnaire de préférence</p>
            </div>
        </div>

        <div class="profile-row">
            <div style="flex:1;">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" value="dodo.dodo@gmail.com">
            </div>
            <button class="btn btn-purple">Modifier</button>
            <div class="row-actions">
                <button class="btn btn-purple">Supprimer l’historique de mon compte</button>
                <p>Supprime l'historique des jeux que vous avez Love, Like et Dislike</p>
            </div>
        </div>

        <div class="profile-row">
            <div style="flex:1;">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" value="************">
            </div>
            <button class="btn btn-purple">Modifier</button>
            <div class="row-actions">
                <button class="btn btn-red">Supprimer mon compte</button>
                <p class="warning">Cette action est irréversible</p>
            </div>
        </div>
    </div>
    
</body>
</html>
<?php
    session_start();
    require "fonctions.php";
    $bdd = getBDD();

    // Vérification : connecté ?
    if(!isset($_SESSION["client"])) {
        echo "non connecté";
        exit;
    }

    // Vérification du token
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        unset($_SESSION['token']);
        echo 'Erreur de token';
        exit;
    }

    if (!isset($_POST["nom"]) && !isset($_POST["mail"]) && !isset($_POST["mdp"])){
        echo "données manquantes";
        exit;
    }

    $id = $_SESSION["client"]["id"];
    $username = $_POST["nom"];
    $email = $_POST["mail"];
    $mdp = password_hash($_POST["mdp"], PASSWORD_BCRYPT);

    $sql = "UPDATE client SET nom_client = :valeur, mail = :email, mdp = :mdp WHERE id_client = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([
        ":valeur" => $username,
        ":id" => $id,
        ":email" => $email,
        ":mdp" => $mdp
]);

$_SESSION["client"]["nom"] = $username;
$_SESSION["client"]["mail"] = $email;

echo "1";
?>
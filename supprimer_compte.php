<?php
    session_start();
    require "fonctions.php";
    $bdd = getBDD();

    if(!isset($_SESSION["client"])) {
        echo "non connecté";
        exit;
    }

    // Vérification du token CSRF
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        unset($_SESSION['token']);
        echo "Erreur token";
        exit;
    }

    $id = $_SESSION["client"]["id"];

    $sql = "DELETE FROM client WHERE id_client = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([":id" => $id]);

    session_destroy();

    echo "1";
?>
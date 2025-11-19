<?php 

    session_start();
    require "fonctions.php";
    $bdd = getBDD();

    // Vérification du token
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        unset($_SESSION['token']);
        echo 'Erreur de token';
        exit;
    }
    
    if (!isset($_POST['mail'])) {
        echo 'Probleme de transfère des données';
        exit;
    }

    $id = $_SESSION["client"]["id"];
    $email = $_POST['mail'];
    
    $sql = "SELECT * FROM client WHERE mail = :mail";
    $req = $bdd->prepare($sql);
    $req->execute([':mail' => $email]);
    
    $ligne = $req->fetch();
    $req->closeCursor();
    
    if(empty($ligne)){
        echo "1";
    
    }else{
        echo "Compte déjà existant";
    }

?>
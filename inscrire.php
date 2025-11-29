<?php
session_start();
require 'fonctions.php';
$bdd = getBDD();

/*Vérification token*/
if (!isset($_POST['token'], $_SESSION['token']) || $_SESSION['token'] != $_POST['token']) {
    echo "Erreur de token.";
    exit;
}

$nom = $_POST["nom"];
$mail = $_POST["mail"];
$mdp1 = $_POST["mdp1"];
$mdp2 = $_POST["mdp2"];

// Vérifier si le nom ou le mail existe déjà
$sql = "SELECT * FROM client WHERE nom_client = :nom OR mail = :mail";
$stmt = $bdd->prepare($sql);
$stmt->execute([
    ':nom' => $nom,
    ':mail' => $mail
]);

if ($stmt->rowCount() > 0) {
    echo "Nom ou mail déjà utilisé.";
    exit;
}


if ($mdp1 != $mdp2) {
    echo "Les mots de passe ne sont pas identiques.";
} else {
    $sql = "INSERT INTO client (nom_client, mail, mdp, premiere_co) VALUES (:nom,:mail,:mdp, NOW())";
    $mdp = password_hash($mdp1, PASSWORD_DEFAULT);
    $req = $bdd->prepare($sql);
    $req->execute([
        ':nom' => $nom,
        ':mail' => $mail,
        ':mdp' => $mdp
    ]);

    //récupère l'id
    $id_client = $bdd->lastInsertId();

    $_SESSION['client'] = array('id' => $id_client, 'nom' => $nom, 'mail' => $mail);
    unset($_SESSION['token']);
    echo '1';
}
?>
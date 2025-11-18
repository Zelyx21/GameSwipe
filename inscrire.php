<?php
session_start();
require 'fonctions.php';
$bdd = getBDD();

/*Vérification token*/
if (!isset($_POST['token'], $_SESSION['token']) || $_SESSION['token'] != $_POST['token']) {
    echo "Erreur de token.";
    exit;
}
unset($_SESSION["token"]);
unset($_POST["token"]);

$nom = $_POST["nom"];
$mail = $_POST["mail"];
$mdp1 = $_POST["mdp1"];
$mdp2 = $_POST["mdp2"];

if ($mdp1 != $mdp2) {
    echo "Les mots de passe ne sont pas identiques.";
}else{
    $sql = "INSERT INTO client (nom_client, mail, mdp) VALUES (:nom,:mail,:mdp)";
    $mdp = password_hash($mdp1, PASSWORD_DEFAULT);
    $req = $bdd->prepare($sql);
    $req->execute([
        ':nom' => $nom,
        ':mail' => $mail,
        ':mdp' => $mdp
    ]);
    $_SESSION['client'] = ['nom' => $nom, 'mail' => $mail];
    echo '1';
}
?>
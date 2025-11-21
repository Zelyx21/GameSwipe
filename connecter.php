<?php
session_start();
require 'fonctions.php';
$bdd = getBDD();

$mail_nom = $_POST["mail_nom"] ?? '';
$mdp = $_POST["mdp"] ?? '';
$token = $_POST["token"] ?? '';

/*Vérification token*/
if (!isset($token, $_SESSION['token']) || $_SESSION['token'] != $token) {
    echo "Erreur de token.";
    exit;
}

$sql = "SELECT * FROM client WHERE mail = :mail or nom_client = :nom_client";
$req = $bdd->prepare($sql);
$req->execute([
    ':mail' => $mail_nom,
    ':nom_client' => $mail_nom
]);

$client = $req->fetch();
	$verifie = False;
	if ($client && isset($client['mdp']) && password_verify($mdp,$client['mdp'])){
		$verifie = True;
	}
	if ($mail_nom == '' || $mdp == '' || !$verifie){
		echo "0";
	}else{
		$_SESSION['client']=array(
		'id'      => $client['id_client'],
		'nom'     => $client['nom_client'],
		'mail'    => $client['mail'],
		);
		unset($_SESSION['token']);
		echo "1";
	}

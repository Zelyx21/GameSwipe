<?php
session_start();

if(!isset($_SESSION['client'])) {
    header("Location: connexion.php");
    exit;
}

require 'fonctions.php';
$bdd = getBDD();

$id_client = $_SESSION['client']['id'];


$bdd->prepare("DELETE FROM quest0 WHERE id_client = ?")->execute([$id_client]);
$bdd->prepare("DELETE FROM quest1 WHERE id_client = ?")->execute([$id_client]);
$bdd->prepare("DELETE FROM quest2 WHERE id_client = ?")->execute([$id_client]);

header("Location: quiz_age.php");
exit;

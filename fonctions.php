<?php
function getBDD() {
    // Connexion PDO
    $bdd = new PDO('mysql:host=localhost;dbname=gameswipe;charset=utf8', 'root', '');
    return $bdd;
}
?>
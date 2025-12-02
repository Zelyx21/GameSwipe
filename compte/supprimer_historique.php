<?php
session_start();
require '../fonctions.php';
$pdo = getBDD();

if(!isset($_SESSION["client"])) {
    header("Location: connexion.php");
    exit;
}

$client_id = $_SESSION['client']['id'] ?? null;
if ($client_id) {
    $tables = ['like', 'dislike', 'favori'];
    foreach ($tables as $table) {
        $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id_client = ?");
        $stmt->execute([$client_id]);
    }
}

// Optionnel : message flash via session ou simplement alert JS côté client
header("Location: ../accueil.php");
exit;
?>

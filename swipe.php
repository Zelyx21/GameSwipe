<?php
session_start();
require 'database.php';
header('Content-Type: application/json');

$client_id = $_SESSION['client']['id'] ?? null;
if (!$client_id) {
    echo json_encode(["success" => false, "error" => "not_logged"]);
    exit;
}

$game_id = $_POST['game_id'] ?? null;
$action  = $_POST['action'] ?? null; // "like", "dislike", "favori"

if (!$game_id || !$action) {
    echo json_encode(["success" => false, "error" => "missing_data"]);
    exit;
}

// Vérifier que le jeu existe
$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM jeux_videos WHERE id_jeu = ?");
$stmtCheck->execute([$game_id]);
if (!$stmtCheck->fetchColumn()) {
    echo json_encode(["success" => false, "error" => "invalid_game_id"]);
    exit;
}

// Correspondance exacte noms tables
$tableMap = [
    'like'    => '`like`',
    'dislike' => '`dislike`',
    'favori'  => '`favori`'  
];

if (!isset($tableMap[$action])) {
    echo json_encode(["success" => false, "error" => "invalid_action"]);
    exit;
}

try {
    // Supprimer la carte des autres tables
    foreach ($tableMap as $key => $table) {
        if ($key === $action) continue;
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id_client = :client_id AND id_jeu = :id_jeu");
        $stmt->execute([
            ':client_id' => $client_id,
            ':id_jeu' => $game_id,
        ]);
    }

    // Vérifier si elle existe déjà dans la table cible
    $tableTarget = $tableMap[$action];
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM $tableTarget WHERE id_client = :client_id AND id_jeu = :id_jeu");
    $stmtCheck->execute([
        ':client_id' => $client_id,
        ':id_jeu' => $game_id,
    ]);

    if ($stmtCheck->fetchColumn() == 0) {
        $stmtInsert = $pdo->prepare("INSERT INTO $tableTarget (id_client, id_jeu) VALUES (:client_id, :id_jeu)");
        $stmtInsert->execute([
            ':client_id' => $client_id,
            ':id_jeu' => $game_id,
        ]);

        // Vérification d'erreur SQL
        if ($stmtInsert->errorCode() != "00000") {
            echo json_encode(["success" => false, "error" => $stmtInsert->errorInfo()]);
            exit;
        }
    }

    echo json_encode(["success" => true]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>

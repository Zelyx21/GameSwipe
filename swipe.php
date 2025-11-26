<?php
header('Content-Type: application/json');
session_start();
require 'database.php';

$client_id = $_SESSION['client']['id'] ?? null;
if (!$client_id) {
    echo json_encode(["error" => "not_logged"]);
    exit;
}

$game_id = $_POST['game_id'] ?? null;
$action  = $_POST['action'] ?? null; // like, dislike, favorite

if (!$game_id || !$action) {
    echo json_encode(["error" => "missing_data"]);
    exit;
}

// Vérifier que le jeu existe
$stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM jeux_videos WHERE id_jeu = ?");
$stmtCheck->execute([$game_id]);
if (!$stmtCheck->fetchColumn()) {
    echo json_encode(["error" => "invalid_game_id"]);
    exit;
}

// Supprimer toute autre action pour ce jeu et cet utilisateur
$stmtDelete = $pdo->prepare("
    DELETE FROM user_swipes 
    WHERE client_id = :client_id AND id_jeu = :id_jeu
");
$stmtDelete->execute([
    ':client_id' => $client_id,
    ':id_jeu' => $game_id
]);

// Insérer la nouvelle action
if($action == "like"){
    $stmt = $pdo->prepare("INSERT INTO `like` (id_client, id_jeu)
        VALUES (:client_id, :id_jeu)");
    $stmt->execute([
        ':client_id' => $client_id,
        ':id_jeu'    => $game_id,
    ]);
    echo json_encode(["success" => true]);
} else if($action == "dislike"){
    $stmt = $pdo->prepare("INSERT INTO dislike (id_client, id_jeu)
            VALUES (:client_id, :id_jeu)");
    $stmt->execute([
        ':client_id' => $client_id,
        ':id_jeu'    => $game_id,
    ]);
    echo json_encode(["success" => true]);
} else if($action == "favorite"){
    $stmt = $pdo->prepare("INSERT INTO favori (id_clientS, id_jeu)
        VALUES (:client_id, :id_jeu)");
    $stmt->execute([
        ':client_id' => $client_id,
        ':id_jeu'    => $game_id,
    ]);
    echo json_encode(["success" => true]);
} else{
    echo json_encode(["error" => $e->getMessage()]);
}


#try {
#    $stmt = $pdo->prepare("
#        INSERT INTO user_swipes (client_id, id_jeu, action)
#        VALUES (:client_id, :id_jeu, :action)
#    ");
#    $stmt->execute([
#        ':client_id' => $client_id,
#        ':id_jeu'    => $game_id,
#        ':action'    => $action
#    ]);
#
#    echo json_encode(["success" => true]);
#} catch (PDOException $e) {
#    echo json_encode(["error" => $e->getMessage()]);
#}

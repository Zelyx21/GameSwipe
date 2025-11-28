<?php
header('Content-Type: application/json');
session_start();
require 'database.php';

try {
    $stmt = $pdo->query("SELECT id_jeu, nom_jeu, image, description, release_date FROM jeux_videos");
    $jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($jeux);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

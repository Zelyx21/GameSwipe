<?php
header('Content-Type: application/json');
$host='localhost'; $dbname='gameswipe'; $user='root'; $pass='';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){ die(json_encode(['error'=>$e->getMessage()])); }

$stmt = $pdo->query("SELECT nom_jeu,image,description FROM jeux_videos");
$jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($jeux);
?>
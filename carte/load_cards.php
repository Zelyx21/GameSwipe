<?php
#header('Content-Type: application/json');
session_start();
require '../fonctions.php';
$bdd = getBDD();

$id_client = $_SESSION['client']['id'] ?? null;

try {
    // Get user quiz answers
    $q0 = $bdd->prepare("SELECT * FROM quest0 WHERE id_client = ?");
    $q0->execute([$id_client]);
    $age = $q0->fetch();

    $q1 = $bdd->prepare("SELECT * FROM quest1 WHERE id_client = ?");
    $q1->execute([$id_client]);
    $cats = $q1->fetch();

    $q2 = $bdd->prepare("SELECT * FROM quest2 WHERE id_client = ?");
    $q2->execute([$id_client]);
    $times = $q2->fetch();

    $conditions = [];
    $params = [];

    // age
    if ($age) {
        if ($age['moins_de_13_ans'] == 1) {
            $conditions[] = "j.required_age <= 12";
        }

        if ($age['plus_de_13_ans'] == 1) {
            $conditions[] = "j.required_age < 18";
        }

        if ($age['plus_de_18_ans'] == 1) {
        }
    }

    // category
    if ($cats) {
        $catFilters = [];

        if ($cats['solo'] == 1) $catFilters[] = 27;
        if ($cats['coop'] == 1) $catFilters = array_merge($catFilters, [2,10,16,20,24,25]);
        if ($cats['multi'] == 1) $catFilters = array_merge($catFilters, [15,11,17,19,26,4]);
        if ($cats['mmo'] == 1) $catFilters[] = 12;
        if ($cats['vr'] == 1) $catFilters = array_merge($catFilters, [35,37,38,39,36]);
        
        $catFilters = array_filter($catFilters, fn($v) => $v !== null && $v !== '');

        if (!empty($catFilters)) {
            $placeholders = implode(",", array_fill(0, count($catFilters), "?"));
            $conditions[] = "ac.id_cat IN ($placeholders)";
            $params = array_merge($params, $catFilters);
        }
    }

    // playtime
    if ($times) {
        $timeConditions = [];
        if ($times['2h'] == 1) $timeConditions[] = "j.avg_playtime_forever <= 120";
        if ($times['5h'] == 1) $timeConditions[] = "j.avg_playtime_forever <= 300";
        if ($times['12h'] == 1) $timeConditions[] = "j.avg_playtime_forever <= 720";
        if ($times['30h'] == 1) $timeConditions[] = "j.avg_playtime_forever <= 1800";
        if ($times['plus'] == 1) $timeConditions[] = "j.avg_playtime_forever >= 1800";

        if (!empty($timeConditions)) {
            $conditions[] = "(" . implode(" OR ", $timeConditions) . ")";
        }
    }

    // final requete sql
    $sql = "
        SELECT j.*, c.nom_cat, t.nom_tag
        FROM jeux_videos j
        LEFT JOIN a_category ac ON j.id_jeu = ac.id_jeu
        LEFT JOIN category c ON ac.id_cat = c.id_cat
        LEFT JOIN a_tag at ON j.id_jeu = at.id_jeu
        LEFT JOIN tag t ON at.id_tag = t.id_tag
    ";

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .= " GROUP BY j.id_jeu";

    $stmt = $bdd->prepare($sql);
    $stmt->execute($params);

    $jeux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($jeux);

} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
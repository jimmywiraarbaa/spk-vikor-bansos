<?php
require_once __DIR__ . '/../includes/db.php';

$pdo->exec("DELETE FROM penilaian");

$alternatif = $pdo->query("SELECT id, nama FROM alternatif ORDER BY nama ASC")->fetchAll();
$kriteria = $pdo->query("SELECT id FROM kriteria ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);

$subByKriteria = [];
$stmt = $pdo->query("SELECT id, kriteria_id, bobot FROM sub_kriteria ORDER BY kriteria_id, bobot");
foreach ($stmt->fetchAll() as $sk) {
    $subByKriteria[$sk['kriteria_id']][$sk['bobot']] = $sk;
}

function weightedBobot($weights) {
    $pool = [];
    foreach ($weights as $bobot => $weight) {
        $pool = array_merge($pool, array_fill(0, $weight, $bobot));
    }
    return $pool[array_rand($pool)];
}

$weightsByKriteria = [
    1 => [1 => 5, 2 => 10, 3 => 25, 4 => 30, 5 => 30],
    2 => [1 => 5, 2 => 10, 3 => 25, 4 => 30, 5 => 30],
    3 => [1 => 5, 2 => 10, 3 => 25, 4 => 30, 5 => 30],
    4 => [1 => 10, 2 => 25, 3 => 30, 4 => 20, 5 => 15],
    5 => [1 => 5, 2 => 10, 3 => 25, 4 => 30, 5 => 30],
];

$stmtInsert = $pdo->prepare("INSERT INTO penilaian (alternatif_id, sub_kriteria_id, nilai) VALUES (?, ?, ?)");

$jumlah = 0;
foreach ($alternatif as $alt) {
    foreach ($kriteria as $kriteriaId) {
        $bobot = weightedBobot($weightsByKriteria[$kriteriaId]);
        $sk = $subByKriteria[$kriteriaId][$bobot];
        $stmtInsert->execute([$alt['id'], $sk['id'], $sk['bobot']]);
        $jumlah++;
    }
    echo "Penilaian '{$alt['nama']}' berhasil ditambahkan.\n";
}

echo "\nSelesai. Total {$jumlah} penilaian ditambahkan untuk " . count($alternatif) . " alternatif.\n";

<?php
require_once __DIR__ . '/db.php';

/**
 * Mengambil data laporan (kriteria, alternatif, agregasi penilaian, ranking)
 * sesuai filter kelurahan.
 *
 * @param array $query Data query string, misalnya ['kelurahan' => 'Pasarbaru'].
 * @return array{
 *     kriteria: array,
 *     alternatifFiltered: array,
 *     aggregated: array,
 *     ranking: array
 * }
 */
function getLaporanData(array $query = []): array
{
    global $pdo;

    $selectedKelurahan = $query['kelurahan'] ?? '';

    $kriteria = $pdo->query("SELECT * FROM kriteria ORDER BY kode ASC")->fetchAll();

    $whereClause = '';
    $params = [];
    if ($selectedKelurahan !== '') {
        $whereClause = " WHERE kelurahan = ?";
        $params[] = $selectedKelurahan;
    }

    $alternatifStmt = $pdo->prepare("SELECT * FROM alternatif" . $whereClause . " ORDER BY nama ASC");
    $alternatifStmt->execute($params);
    $alternatifFiltered = $alternatifStmt->fetchAll();

    $alternatifIds = array_column($alternatifFiltered, 'id');

    $aggregated = [];
    $ranking = [];
    if (!empty($alternatifIds)) {
        $altIdPlaceholders = implode(',', array_fill(0, count($alternatifIds), '?'));

        $subKriteria = $pdo->query("SELECT * FROM sub_kriteria ORDER BY kriteria_id, bobot ASC")->fetchAll();

        $penStmt = $pdo->prepare("SELECT * FROM penilaian WHERE alternatif_id IN (" . $altIdPlaceholders . ")");
        $penStmt->execute($alternatifIds);
        $penilaianRows = $penStmt->fetchAll();

        $skToKriteria = [];
        foreach ($subKriteria as $sk) {
            $skToKriteria[$sk['id']] = $sk['kriteria_id'];
        }

        $penData = [];
        foreach ($penilaianRows as $row) {
            $kId = $skToKriteria[$row['sub_kriteria_id']] ?? null;
            if ($kId !== null) {
                $penData[$row['alternatif_id']][$kId] = (float) $row['nilai'];
            }
        }

        foreach ($alternatifFiltered as $alt) {
            $aggregated[$alt['id']] = [];
            foreach ($kriteria as $k) {
                $aggregated[$alt['id']][$k['id']] = $penData[$alt['id']][$k['id']] ?? 0;
            }
        }

        $rankStmt = $pdo->prepare("
            SELECT h.*, a.nama, a.nik, a.alamat, a.rt_rw, a.kelurahan
            FROM hasil_perhitungan h
            JOIN alternatif a ON a.id = h.alternatif_id
            WHERE h.alternatif_id IN (" . $altIdPlaceholders . ")
            ORDER BY h.ranking ASC
        ");
        $rankStmt->execute($alternatifIds);
        $ranking = $rankStmt->fetchAll();
    }

    return [
        'kriteria' => $kriteria,
        'alternatifFiltered' => $alternatifFiltered,
        'aggregated' => $aggregated,
        'ranking' => $ranking,
    ];
}

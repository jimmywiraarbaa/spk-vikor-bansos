<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['simpan'])) {
    try {
        $pdo->beginTransaction();

        $pdo->exec("DELETE FROM penilaian");

        $penilaianData = $_POST['penilaian'] ?? [];

        $stmtLookup = $pdo->prepare("SELECT bobot FROM sub_kriteria WHERE id = ?");
        $stmtInsert = $pdo->prepare("INSERT INTO penilaian (alternatif_id, sub_kriteria_id, nilai) VALUES (?, ?, ?)");

        foreach ($penilaianData as $alternatifId => $kriterias) {
            foreach ($kriterias as $kriteriaId => $subKriteriaId) {
                if (!empty($subKriteriaId)) {
                    $stmtLookup->execute([$subKriteriaId]);
                    $row = $stmtLookup->fetch();
                    $nilai = $row ? $row['bobot'] : 0;
                    $stmtInsert->execute([$alternatifId, $subKriteriaId, $nilai]);
                }
            }
        }

        $pdo->commit();
        $_SESSION['success'] = "Penilaian berhasil disimpan.";
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Gagal menyimpan penilaian: " . $e->getMessage();
    }
    redirect('pages/penilaian/index.php');
}

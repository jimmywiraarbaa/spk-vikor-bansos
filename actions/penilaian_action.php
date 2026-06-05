<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['simpan'])) {
    try {
        $pdo->beginTransaction();

        $pdo->exec("DELETE FROM penilaian");

        $nilaiData = $_POST['nilai'];
        $stmt = $pdo->prepare("INSERT INTO penilaian (alternatif_id, sub_kriteria_id, nilai) VALUES (?, ?, ?)");

        foreach ($nilaiData as $alternatifId => $subKriterias) {
            foreach ($subKriterias as $subKriteriaId => $nilai) {
                if ($nilai !== '' && $nilai !== null) {
                    $stmt->execute([$alternatifId, $subKriteriaId, $nilai]);
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

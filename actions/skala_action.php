<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['tambah'])) {
    $sub_kriteria_id = $_POST['sub_kriteria_id'];
    $nilai = $_POST['nilai'];
    $keterangan = trim($_POST['keterangan']);

    try {
        $stmt = $pdo->prepare("INSERT INTO skala_penilaian (sub_kriteria_id, nilai, keterangan) VALUES (?, ?, ?)");
        $stmt->execute([$sub_kriteria_id, $nilai, $keterangan]);

        $_SESSION['success'] = "Skala penilaian berhasil ditambahkan.";
        redirect('pages/skala_penilaian/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menambahkan data: " . $e->getMessage();
        redirect('pages/skala_penilaian/tambah.php');
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nilai = $_POST['nilai'];
    $keterangan = $_POST['keterangan'];

    try {
        $stmt = $pdo->prepare("UPDATE skala_penilaian SET nilai = ?, keterangan = ? WHERE id = ?");
        $stmt->execute([$nilai, $keterangan, $id]);

        $_SESSION['success'] = "Skala penilaian berhasil diperbarui.";
        redirect('pages/skala_penilaian/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui data: " . $e->getMessage();
        redirect('pages/skala_penilaian/edit.php?id=' . $id);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM skala_penilaian WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Skala penilaian berhasil dihapus.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
    }
    redirect('pages/skala_penilaian/index.php');
}

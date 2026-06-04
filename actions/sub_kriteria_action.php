<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (isset($_POST['tambah'])) {
    $kriteriaId = $_POST['kriteria_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];

    try {
        $stmt = $pdo->prepare("INSERT INTO sub_kriteria (kriteria_id, kode, nama, bobot) VALUES (?, ?, ?, ?)");
        $stmt->execute([$kriteriaId, $kode, $nama, $bobot]);

        $_SESSION['success'] = "Sub-kriteria berhasil ditambahkan.";
        redirect('pages/sub_kriteria/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menambah data: " . $e->getMessage();
        redirect('pages/sub_kriteria/tambah.php');
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $kriteriaId = $_POST['kriteria_id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];

    try {
        $stmt = $pdo->prepare("UPDATE sub_kriteria SET kriteria_id = ?, kode = ?, nama = ?, bobot = ? WHERE id = ?");
        $stmt->execute([$kriteriaId, $kode, $nama, $bobot, $id]);

        $_SESSION['success'] = "Sub-kriteria berhasil diperbarui.";
        redirect('pages/sub_kriteria/index.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui data: " . $e->getMessage();
        redirect('pages/sub_kriteria/edit.php?id=' . $id);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM sub_kriteria WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Sub-kriteria berhasil dihapus.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
    }
    redirect('pages/sub_kriteria/index.php');
}

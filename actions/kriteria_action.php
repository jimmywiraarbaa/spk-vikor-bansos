<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Tambah Kriteria
if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $sifat = $_POST['sifat'];
    $bobot = $_POST['bobot'];
    $penjelasan = $_POST['penjelasan'];

    try {
        $stmt = $pdo->prepare("INSERT INTO kriteria (kode, nama, sifat, bobot, penjelasan) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$kode, $nama, $sifat, $bobot, $penjelasan]);
        
        $_SESSION['success'] = "Data kriteria berhasil ditambahkan.";
        header("Location: ../pages/kriteria/index.php");
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menambah data: " . $e->getMessage();
        header("Location: ../pages/kriteria/tambah.php");
    }
    exit;
}

// Edit Kriteria
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $sifat = $_POST['sifat'];
    $bobot = $_POST['bobot'];
    $penjelasan = $_POST['penjelasan'];

    try {
        $stmt = $pdo->prepare("UPDATE kriteria SET kode = ?, nama = ?, sifat = ?, bobot = ?, penjelasan = ? WHERE id = ?");
        $stmt->execute([$kode, $nama, $sifat, $bobot, $penjelasan, $id]);
        
        $_SESSION['success'] = "Data kriteria berhasil diperbarui.";
        header("Location: ../pages/kriteria/index.php");
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui data: " . $e->getMessage();
        header("Location: ../pages/kriteria/edit.php?id=" . $id);
    }
    exit;
}

// Hapus Kriteria
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM kriteria WHERE id = ?");
        $stmt->execute([$id]);
        
        $_SESSION['success'] = "Data kriteria berhasil dihapus.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
    }
    header("Location: ../pages/kriteria/index.php");
    exit;
}

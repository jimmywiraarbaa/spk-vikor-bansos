<?php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$indexPage = 'pages/alternatif/index.php';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $rtRw = $_POST['rt_rw'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $noHp = $_POST['no_hp'] ?? null;

    try {
        $stmt = $pdo->prepare("INSERT INTO alternatif (nama, nik, alamat, rt_rw, kelurahan, kecamatan, no_hp) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $nik, $alamat, $rtRw, $kelurahan, $kecamatan, $noHp]);

        $_SESSION['success'] = "Alternatif berhasil ditambahkan.";
        redirect($indexPage);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menambah data: " . $e->getMessage();
        redirect('pages/alternatif/tambah.php');
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $rtRw = $_POST['rt_rw'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $noHp = $_POST['no_hp'] ?? null;

    try {
        $stmt = $pdo->prepare("UPDATE alternatif SET nama = ?, nik = ?, alamat = ?, rt_rw = ?, kelurahan = ?, kecamatan = ?, no_hp = ? WHERE id = ?");
        $stmt->execute([$nama, $nik, $alamat, $rtRw, $kelurahan, $kecamatan, $noHp, $id]);

        $_SESSION['success'] = "Alternatif berhasil diperbarui.";
        redirect($indexPage);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal memperbarui data: " . $e->getMessage();
        redirect('pages/alternatif/edit.php?id=' . $id);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM alternatif WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['success'] = "Alternatif berhasil dihapus.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal menghapus data: " . $e->getMessage();
    }
    redirect($indexPage);
}


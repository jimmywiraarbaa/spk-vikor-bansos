<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$subKriteria = $pdo->query("
    SELECT sk.*, k.kode as kriteria_kode, k.nama as kriteria_nama
    FROM sub_kriteria sk
    JOIN kriteria k ON sk.kriteria_id = k.id
    ORDER BY k.kode ASC, sk.kode ASC
")->fetchAll();
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Tambah Skala">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            <?php echo strtoupper(substr($_SESSION['nama_lengkap'], 0, 1)); ?>
                        </div>
                        <span class="fw-medium small"><?php echo $_SESSION['nama_lengkap']; ?></span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Tambah Skala Penilaian</h4>
                            <p class="text-muted small mb-0">Tambahkan skala penilaian untuk sub-kriteria tertentu.</p>
                        </div>
                        <a href="index.php" class="btn btn-light btn-sm border px-3 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card border-0 shadow-sm p-4">
                        <form action="../../actions/skala_action.php" method="POST">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="sub_kriteria_id" class="form-label small fw-bold text-secondary">SUB-KRITERIA</label>
                                    <select name="sub_kriteria_id" id="sub_kriteria_id" class="form-select bg-light border-0" required>
                                        <option value="">Pilih Sub-Kriteria</option>
                                        <?php foreach ($subKriteria as $sk): ?>
                                        <option value="<?php echo $sk['id']; ?>">
                                            <?php echo $sk['kriteria_kode']; ?> - <?php echo $sk['kode']; ?> <?php echo $sk['nama']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="nilai" class="form-label small fw-bold text-secondary">NILAI (SKOR)</label>
                                    <input type="number" name="nilai" id="nilai" class="form-control bg-light border-0" min="1" max="5" placeholder="1-5" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="keterangan" class="form-label small fw-bold text-secondary">KETERANGAN</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control bg-light border-0" placeholder="Contoh: <= Rp 500.000" required>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="tambah" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        <i class="bi bi-save me-1"></i> Simpan Skala
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$stmt = $pdo->query("SELECT * FROM kriteria ORDER BY kode ASC");
$kriteriaList = $stmt->fetchAll();
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Tambah Sub Kriteria">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white rounded-circle d-flex align-items center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            <?php echo strtoupper(substr($_SESSION['nama_lengkap'], 0, 1)); ?>
                        </div>
                        <span class="fw-medium small"><?php echo $_SESSION['nama_lengkap']; ?></span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Tambah Sub-Kriteria</h4>
                            <p class="text-muted small">Tambahkan sub-kriteria (rentang/kategori) untuk kriteria yang dipilih.</p>
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
                        <form action="../../actions/sub_kriteria_action.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="kriteria_id" class="form-label small fw-bold text-secondary">KRITERIA</label>
                                    <select name="kriteria_id" id="kriteria_id" class="form-select bg-light border-0" required>
                                        <option value="">Pilih Kriteria...</option>
                                        <?php foreach ($kriteriaList as $k): ?>
                                            <option value="<?php echo $k['id']; ?>">
                                                <?php echo $k['kode']; ?> - <?php echo $k['nama']; ?> (<?php echo $k['sifat']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label for="nama" class="form-label small fw-bold text-secondary">NAMA SUB-KRITERIA</label>
                                    <input type="text" name="nama" id="nama" class="form-control bg-light border-0" placeholder="Contoh: Rp 1.000.001 - Rp 2.000.000" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="bobot" class="form-label small fw-bold text-secondary">BOBOT (Nilai 1-5)</label>
                                    <div class="input-group">
                                        <input type="number" min="1" max="5" name="bobot" id="bobot" class="form-control bg-light border-0" placeholder="1-5" required>
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-star small"></i></span>
                                    </div>
                                    <div class="form-text small">Nilai 1 = terendah, 5 = tertinggi</div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="tambah" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Simpan Sub-Kriteria
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

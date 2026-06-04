<?php
require_once '../../includes/auth_helper.php';
checkLogin();
include_once '../../templates/header.php';
?>

<div id="wrapper">
    <!-- Sidebar -->
    <?php include_once '../../templates/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg top-navbar">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Tambah Kriteria</h4>
                            <p class="text-muted small">Input kriteria baru untuk perhitungan VIKOR.</p>
                        </div>
                        <a href="index.php" class="btn btn-light btn-sm border px-3 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card border-0 shadow-sm p-4">
                        <form action="../../actions/kriteria_action.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="kode" class="form-label small fw-bold text-secondary">KODE KRITERIA</label>
                                    <input type="text" name="kode" id="kode" class="form-control bg-light border-0" placeholder="Contoh: C1" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="nama" class="form-label small fw-bold text-secondary">NAMA KRITERIA</label>
                                    <input type="text" name="nama" id="nama" class="form-control bg-light border-0" placeholder="Contoh: Penghasilan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="sifat" class="form-label small fw-bold text-secondary">SIFAT KRITERIA</label>
                                    <select name="sifat" id="sifat" class="form-select bg-light border-0" required>
                                        <option value="cost">Cost (Semakin kecil semakin baik)</option>
                                        <option value="benefit">Benefit (Semakin besar semakin baik)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="bobot" class="form-label small fw-bold text-secondary">BOBOT (Wi)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="bobot" class="form-control bg-light border-0" placeholder="Contoh: 0.30" required>
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-percent small"></i></span>
                                    </div>
                                    <div class="form-text small">Gunakan desimal (misal 0.30 untuk 30%).</div>
                                </div>
                                <div class="col-12">
                                    <label for="penjelasan" class="form-label small fw-bold text-secondary">PENJELASAN</label>
                                    <textarea name="penjelasan" id="penjelasan" class="form-control bg-light border-0" rows="3" placeholder="Jelaskan alasan kriteria ini digunakan..."></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="tambah" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Simpan Kriteria
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

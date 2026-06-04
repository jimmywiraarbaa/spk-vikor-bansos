<?php
require_once '../../includes/auth_helper.php';
checkLogin();
include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Tambah Alternatif">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Tambah Alternatif</h4>
                            <p class="text-muted small">Tambahkan data calon penerima bantuan sosial.</p>
                        </div>
                        <a href="index.php" class="btn btn-light btn-sm border px-3 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card border-0 shadow-sm p-4">
                        <form action="../../actions/alternatif_action.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="nama" class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                                    <input type="text" name="nama" id="nama" class="form-control bg-light border-0" placeholder="Nama lengkap calon penerima" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="nik" class="form-label small fw-bold text-secondary">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control bg-light border-0" placeholder="16 digit NIK" maxlength="16" pattern="\d{16}" required>
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label small fw-bold text-secondary">ALAMAT</label>
                                    <textarea name="alamat" id="alamat" class="form-control bg-light border-0" rows="2" placeholder="Alamat lengkap" required></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label for="rt_rw" class="form-label small fw-bold text-secondary">RT/RW</label>
                                    <input type="text" name="rt_rw" id="rt_rw" class="form-control bg-light border-0" placeholder="001/002" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="kelurahan" class="form-label small fw-bold text-secondary">KELURAHAN/DESA</label>
                                    <input type="text" name="kelurahan" id="kelurahan" class="form-control bg-light border-0" placeholder="Nama kelurahan" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="kecamatan" class="form-label small fw-bold text-secondary">KECAMATAN</label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control bg-light border-0" placeholder="Nama kecamatan" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="no_hp" class="form-label small fw-bold text-secondary">NO. HP</label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control bg-light border-0" placeholder="08xxxxxxxxxx">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="tambah" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Simpan Alternatif
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

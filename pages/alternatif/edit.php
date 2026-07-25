<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM alternatif WHERE id = ?");
$stmt->execute([$id]);
$alternatif = $stmt->fetch();

if (!$alternatif) {
    header("Location: index.php");
    exit;
}

include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Edit Alternatif">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="fw-medium small"><?php echo $_SESSION['nama_lengkap']; ?></span>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Edit Alternatif</h4>
                            <p class="text-muted small">Perbarui data calon penerima bantuan sosial.</p>
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
                        <form action="../../actions/alternatif_action.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $alternatif['id']; ?>">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="nama" class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                                    <input type="text" name="nama" id="nama" class="form-control bg-light border-0" value="<?php echo $alternatif['nama']; ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label small fw-bold text-secondary">ALAMAT</label>
                                    <textarea name="alamat" id="alamat" class="form-control bg-light border-0" rows="2" required><?php echo $alternatif['alamat']; ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="kelurahan" class="form-label small fw-bold text-secondary">KELURAHAN/DESA</label>
                                    <input type="text" name="kelurahan" id="kelurahan" class="form-control bg-light border-0" value="<?php echo $alternatif['kelurahan']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="kecamatan" class="form-label small fw-bold text-secondary">KECAMATAN</label>
                                    <input type="text" name="kecamatan" id="kecamatan" class="form-control bg-light border-0" value="<?php echo $alternatif['kecamatan']; ?>" required>
                                </div>
                                <input type="hidden" name="nik" value="<?php echo $alternatif['nik'] ?: '0000000000000000'; ?>">
                                <input type="hidden" name="rt_rw" value="<?php echo $alternatif['rt_rw'] ?: '000/000'; ?>">
                                <input type="hidden" name="no_hp" value="<?php echo $alternatif['no_hp'] ?: '-'; ?>">
                                <div class="col-12 mt-4">
                                    <button type="submit" name="edit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Perbarui Alternatif
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

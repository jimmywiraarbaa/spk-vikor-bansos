<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT sp.*, sk.kode as sub_kriteria_kode, sk.nama as sub_kriteria_nama, sk.kriteria_id,
           k.kode as kriteria_kode, k.nama as kriteria_nama
    FROM skala_penilaian sp
    JOIN sub_kriteria sk ON sp.sub_kriteria_id = sk.id
    JOIN kriteria k ON sk.kriteria_id = k.id
    WHERE sp.id = ?
");
$stmt->execute([$id]);
$skala = $stmt->fetch();

if (!$skala) {
    header("Location: index.php");
    exit;
}

include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Edit Skala">
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
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-0">Edit Skala Penilaian</h4>
                            <p class="text-muted small mb-0">
                                <span class="badge bg-danger bg-opacity-10 text-danger border-0 px-2 py-1 me-1"><?php echo $skala['kriteria_kode']; ?></span>
                                <?php echo $skala['sub_kriteria_kode']; ?> - <?php echo $skala['sub_kriteria_nama']; ?>
                            </p>
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
                            <input type="hidden" name="id" value="<?php echo $skala['id']; ?>">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nilai" class="form-label small fw-bold text-secondary">NILAI</label>
                                    <input type="number" name="nilai" id="nilai" class="form-control bg-light border-0" value="<?php echo $skala['nilai']; ?>" min="1" max="10" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="keterangan" class="form-label small fw-bold text-secondary">KETERANGAN</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control bg-light border-0" value="<?php echo $skala['keterangan']; ?>" required>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="edit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Perbarui Skala
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

<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM kriteria WHERE id = ?");
$stmt->execute([$id]);
$kriteria = $stmt->fetch();

if (!$kriteria) {
    header("Location: index.php");
    exit;
}

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
                            <h4 class="fw-bold mb-0">Edit Kriteria</h4>
                            <p class="text-muted small">Perbarui informasi kriteria SPK.</p>
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
                        <form action="../../actions/kriteria_action.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $kriteria['id']; ?>">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="kode" class="form-label small fw-bold text-secondary">KODE KRITERIA</label>
                                    <input type="text" name="kode" id="kode" class="form-control bg-light border-0" value="<?php echo $kriteria['kode']; ?>" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="nama" class="form-label small fw-bold text-secondary">NAMA KRITERIA</label>
                                    <input type="text" name="nama" id="nama" class="form-control bg-light border-0" value="<?php echo $kriteria['nama']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="sifat" class="form-label small fw-bold text-secondary">SIFAT KRITERIA</label>
                                    <select name="sifat" id="sifat" class="form-select bg-light border-0" required>
                                        <option value="cost" <?php echo $kriteria['sifat'] == 'cost' ? 'selected' : ''; ?>>Cost (Semakin kecil semakin baik)</option>
                                        <option value="benefit" <?php echo $kriteria['sifat'] == 'benefit' ? 'selected' : ''; ?>>Benefit (Semakin besar semakin baik)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="bobot" class="form-label small fw-bold text-secondary">BOBOT (Wi)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="bobot" class="form-control bg-light border-0" value="<?php echo $kriteria['bobot']; ?>" required>
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-percent small"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="penjelasan" class="form-label small fw-bold text-secondary">PENJELASAN</label>
                                    <textarea name="penjelasan" id="penjelasan" class="form-control bg-light border-0" rows="3"><?php echo $kriteria['penjelasan']; ?></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" name="edit" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                                        Perbarui Kriteria
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

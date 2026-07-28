<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$stmt = $pdo->query("
    SELECT sk.*, k.kode as kriteria_kode, k.nama as kriteria_nama, k.sifat as kriteria_sifat, k.bobot as kriteria_bobot
    FROM sub_kriteria sk
    JOIN kriteria k ON sk.kriteria_id = k.id
    ORDER BY k.kode ASC, sk.bobot ASC
");
$subKriteria = $stmt->fetchAll();

$grouped = [];
foreach ($subKriteria as $row) {
    $grouped[$row['kriteria_id']][] = $row;
}
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Sub Kriteria">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Data Sub-Kriteria</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sub-Kriteria</li>
                        </ol>
                    </nav>
                </div>
                <a href="tambah.php" class="btn btn-danger btn-sm px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Sub-Kriteria
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (empty($grouped)): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-list-task fs-1 text-muted d-block mb-2"></i>
                    <p class="text-muted mb-0">Belum ada data sub-kriteria.</p>
                </div>
            </div>
            <?php else: ?>
            <?php foreach ($grouped as $kriteriaId => $items): ?>
                <?php $k = $items[0]; ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-light border-0 py-3 px-4 d-flex align-items-center flex-wrap gap-2">
                        <span class="badge bg-danger text-white px-3 py-2 fs-6"><?php echo $k['kriteria_kode']; ?></span>
                        <span class="fw-bold fs-6"><?php echo $k['kriteria_nama']; ?></span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 px-2 py-1 text-uppercase"><?php echo $k['kriteria_sifat']; ?></span>
                        <span class="text-muted small ms-auto">Wi = <?php echo number_format($k['kriteria_bobot'], 2); ?> (<?php echo ($k['kriteria_bobot'] * 100); ?>%)</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 50px;">NO</th>
                                        <th class="py-3">NAMA SUB-KRITERIA</th>
                                        <th class="py-3 text-center" style="width: 100px;">BOBOT</th>
                                        <th class="pe-4 py-3 text-end" style="width: 150px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($items as $row): ?>
                                    <tr>
                                        <td class="ps-4 text-muted"><?php echo $no++; ?></td>
                                        <td class="fw-medium"><?php echo htmlspecialchars($row['nama']); ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-danger rounded-pill px-3 py-2"><?php echo $row['bobot']; ?></span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 me-1 border shadow-sm">
                                                <i class="bi bi-pencil text-primary"></i>
                                            </a>
                                            <a href="../../actions/sub_kriteria_action.php?delete=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 border shadow-sm" onclick="return confirm('Yakin ingin menghapus sub-kriteria ini?')">
                                                <i class="bi bi-trash text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

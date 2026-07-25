<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$alternatif = $pdo->query("SELECT * FROM alternatif ORDER BY nama ASC")->fetchAll();

$subKriteria = $pdo->query("
    SELECT sk.*, k.kode as kriteria_kode, k.nama as kriteria_nama, k.sifat
    FROM sub_kriteria sk
    JOIN kriteria k ON sk.kriteria_id = k.id
    ORDER BY k.kode ASC, sk.kode ASC
")->fetchAll();

$subKriteriaIds = array_column($subKriteria, 'id');

$penilaianData = [];
if (!empty($alternatif) && !empty($subKriteriaIds)) {
    $stmt = $pdo->query("SELECT * FROM penilaian");
    $rows = $stmt->fetchAll();
    foreach ($rows as $row) {
        $penilaianData[$row['alternatif_id']][$row['sub_kriteria_id']] = $row['nilai'];
    }
}

$skalaData = [];
$skalaRows = $pdo->query("SELECT * FROM skala_penilaian ORDER BY sub_kriteria_id, nilai ASC")->fetchAll();
foreach ($skalaRows as $row) {
    $skalaData[$row['sub_kriteria_id']][] = $row;
}
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Penilaian">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        </div>
                        <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Input Penilaian</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penilaian</li>
                        </ol>
                    </nav>
                </div>
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

            <?php if (empty($alternatif)): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-people fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted mb-2">Belum ada data alternatif.</p>
                        <a href="<?php echo baseUrl('pages/alternatif/tambah.php'); ?>" class="btn btn-danger btn-sm rounded-pill px-4">Tambah Alternatif</a>
                    </div>
                </div>
            <?php elseif (empty($subKriteria)): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-list-task fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted mb-2">Belum ada data sub-kriteria.</p>
                        <a href="<?php echo baseUrl('pages/sub_kriteria/tambah.php'); ?>" class="btn btn-danger btn-sm rounded-pill px-4">Tambah Sub-Kriteria</a>
                    </div>
                </div>
            <?php else: ?>
            <form action="../../actions/penilaian_action.php" method="POST">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 40px;">NO</th>
                                        <th class="py-3" style="min-width: 150px;">NAMA ALTERNATIF</th>
                                        <?php foreach ($subKriteria as $sk): ?>
                                        <th class="py-3 text-center" style="min-width: 140px;">
                                            <small class="fw-bold text-danger d-block"><?php echo $sk['kode']; ?></small>
                                            <small class="d-block" title="<?php echo $sk['nama']; ?>"><?php echo $sk['nama']; ?></small>
                                            <small class="text-muted d-block">(<?php echo $sk['kriteria_kode']; ?>)</small>
                                        </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($alternatif as $alt): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted"><?php echo $no++; ?></td>
                                        <td class="fw-medium"><?php echo $alt['nama']; ?></td>
                                        <?php foreach ($subKriteria as $sk): ?>
                                        <td class="text-center">
                                            <input type="hidden" name="alternatif_ids[]" value="<?php echo $alt['id']; ?>">
                                            <input type="hidden" name="sub_kriteria_ids[]" value="<?php echo $sk['id']; ?>">
                                            <?php if (isset($skalaData[$sk['id']])): ?>
                                            <select name="nilai[<?php echo $alt['id']; ?>][<?php echo $sk['id']; ?>]" class="form-select form-select-sm bg-light border-0">
                                                <option value="">Pilih</option>
                                                <?php foreach ($skalaData[$sk['id']] as $s): ?>
                                                <option value="<?php echo $s['nilai']; ?>" <?php echo (isset($penilaianData[$alt['id']][$sk['id']]) && $penilaianData[$alt['id']][$sk['id']] == $s['nilai']) ? 'selected' : ''; ?>>
                                                    <?php echo $s['nilai']; ?> - <?php echo $s['keterangan']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php else: ?>
                                            <input type="number" name="nilai[<?php echo $alt['id']; ?>][<?php echo $sk['id']; ?>]" class="form-control form-control-sm bg-light border-0 text-center" min="1" max="5" value="<?php echo isset($penilaianData[$alt['id']][$sk['id']]) ? $penilaianData[$alt['id']][$sk['id']] : ''; ?>" placeholder="1-5">
                                            <?php endif; ?>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-3 text-end">
                        <button type="submit" name="simpan" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Penilaian
                        </button>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

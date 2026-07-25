<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$selectedKelurahan = $_GET['kelurahan'] ?? '';

$kelurahanList = $pdo->query("SELECT DISTINCT kelurahan FROM alternatif WHERE kelurahan IS NOT NULL AND kelurahan != '' ORDER BY kelurahan ASC")->fetchAll(PDO::FETCH_COLUMN);

$kriteria = $pdo->query("SELECT * FROM kriteria ORDER BY kode ASC")->fetchAll();

$whereClause = '';
$params = [];
if ($selectedKelurahan !== '') {
    $whereClause = " WHERE a.kelurahan = ?";
    $params[] = $selectedKelurahan;
}

$alternatifStmt = $pdo->prepare("SELECT * FROM alternatif" . $whereClause . " ORDER BY nama ASC");
$alternatifStmt->execute($params);
$alternatifFiltered = $alternatifStmt->fetchAll();

$alternatifIds = array_column($alternatifFiltered, 'id');
$altIdPlaceholders = implode(',', array_fill(0, count($alternatifIds), '?'));

$subKriteria = $pdo->query("SELECT * FROM sub_kriteria ORDER BY kriteria_id, kode ASC")->fetchAll();

$aggregated = [];
$penilaianRows = [];
if (!empty($alternatifIds)) {
    $penStmt = $pdo->prepare("SELECT * FROM penilaian WHERE alternatif_id IN (" . $altIdPlaceholders . ")");
    $penStmt->execute($alternatifIds);
    $penilaianRows = $penStmt->fetchAll();

    $penData = [];
    foreach ($penilaianRows as $row) {
        $penData[$row['alternatif_id']][$row['sub_kriteria_id']] = (float) $row['nilai'];
    }

    $subByKriteria = [];
    foreach ($subKriteria as $sk) {
        $subByKriteria[$sk['kriteria_id']][] = $sk;
    }

    foreach ($alternatifFiltered as $alt) {
        $aggregated[$alt['id']] = [];
        foreach ($kriteria as $k) {
            $weightedSum = 0;
            if (isset($subByKriteria[$k['id']])) {
                foreach ($subByKriteria[$k['id']] as $sk) {
                    $bobot = (float) $sk['bobot'];
                    $nilai = $penData[$alt['id']][$sk['id']] ?? 0;
                    $weightedSum += $bobot * $nilai;
                }
            }
            $aggregated[$alt['id']][$k['id']] = $weightedSum;
        }
    }
}

$ranking = [];
if (!empty($alternatifIds)) {
    $rankStmt = $pdo->prepare("
        SELECT h.*, a.nama, a.nik, a.alamat, a.rt_rw, a.kelurahan
        FROM hasil_perhitungan h
        JOIN alternatif a ON a.id = h.alternatif_id
        WHERE h.alternatif_id IN (" . $altIdPlaceholders . ")
        ORDER BY h.ranking ASC
    ");
    $rankStmt->execute($alternatifIds);
    $ranking = $rankStmt->fetchAll();
}

$totalAlternatif = count($alternatifFiltered);
$totalPenilaian = count($penilaianRows);
$totalHasil = count($ranking);
$hasData = !empty($alternatifFiltered);
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Laporan">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Laporan</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <form method="GET" action="" class="d-flex gap-2">
                        <select name="kelurahan" class="form-select form-select-sm" style="min-width: 200px;" onchange="this.form.submit()">
                            <option value="">Semua Kelurahan</option>
                            <?php foreach ($kelurahanList as $kel): ?>
                            <option value="<?php echo htmlspecialchars($kel); ?>" <?php echo $selectedKelurahan === $kel ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($kel); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <a href="cetak.php<?php echo $selectedKelurahan !== '' ? '?kelurahan=' . urlencode($selectedKelurahan) : ''; ?>" target="_blank" class="btn btn-danger btn-sm rounded-pill px-4 shadow-sm">
                        <i class="bi bi-printer me-1"></i> Cetak Laporan
                    </a>
                </div>
            </div>

            <?php if (!$hasData): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-earmark-text fs-1 d-block mb-3 text-muted"></i>
                    <h5 class="text-muted mb-2">Belum Ada Data</h5>
                    <p class="text-muted small">Tambahkan data alternatif dan penilaian terlebih dahulu.</p>
                </div>
            </div>
            <?php else: ?>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-people-fill text-danger fs-5"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Total Alternatif</p>
                                <h5 class="fw-bold mb-0"><?php echo $totalAlternatif; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-clipboard2-data text-primary fs-5"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Total Penilaian</p>
                                <h5 class="fw-bold mb-0"><?php echo $totalPenilaian; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-check2-circle text-success fs-5"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Total Hasil VIKOR</p>
                                <h5 class="fw-bold mb-0"><?php echo $totalHasil; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($totalHasil === 0): ?>
            <div class="alert alert-warning border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Perhatian!</strong> Belum ada hasil perhitungan VIKOR. Lakukan perhitungan terlebih dahulu.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-table me-2 text-danger"></i>Rekap Penilaian</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-3 py-2">No</th>
                                    <th class="py-2">Alternatif</th>
                                    <?php foreach ($kriteria as $k): ?>
                                    <th class="text-center py-2"><?php echo $k['kode']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($aggregated)): ?>
                                <tr>
                                    <td colspan="<?php echo 2 + count($kriteria); ?>" class="text-center py-4 text-muted">Tidak ada data penilaian</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($alternatifFiltered as $alt): ?>
                                <tr>
                                    <td class="ps-3 text-muted small"><?php echo $no++; ?></td>
                                    <td class="fw-medium"><?php echo $alt['nama']; ?></td>
                                    <?php foreach ($kriteria as $k): ?>
                                    <td class="text-center font-monospace"><?php echo number_format($aggregated[$alt['id']][$k['id']] ?? 0, 4); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-trophy me-2 text-danger"></i>Hasil VIKOR</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($ranking)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-calculator fs-1 d-block mb-2"></i>
                        <p>Belum ada hasil perhitungan VIKOR.</p>
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-3 py-3" style="width: 70px;">Ranking</th>
                                    <th class="py-3">Nama</th>
                                    <th class="py-3">Alamat</th>
                                    <th class="py-3">Kelurahan</th>
                                    <th class="py-3 text-end">Nilai S</th>
                                    <th class="py-3 text-end">Nilai R</th>
                                    <th class="py-3 text-end">Nilai Q</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ranking as $row): ?>
                                <tr class="<?php echo $row['ranking'] == 1 ? 'table-warning fw-bold' : ''; ?>">
                                    <td class="ps-3">
                                        <?php if ($row['ranking'] == 1): ?>
                                        <span class="badge bg-danger rounded-pill px-2">1</span>
                                        <?php else: ?>
                                        <span class="text-muted"><?php echo $row['ranking']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['nama']; ?>
                                        <?php if ($row['ranking'] == 1): ?>
                                        <i class="bi bi-trophy-fill text-warning ms-1" title="Peringkat Terbaik"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?php echo $row['alamat']; ?></td>
                                    <td class="text-muted small"><?php echo $row['kelurahan']; ?></td>
                                    <td class="text-end font-monospace"><?php echo number_format($row['nilai_s'], 4); ?></td>
                                    <td class="text-end font-monospace"><?php echo number_format($row['nilai_r'], 4); ?></td>
                                    <td class="pe-4 text-end font-monospace"><?php echo number_format($row['nilai_q'], 4); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

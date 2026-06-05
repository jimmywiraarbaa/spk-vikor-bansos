<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$totalAlternatif = $pdo->query("SELECT COUNT(*) FROM alternatif")->fetchColumn();
$totalDihitung = $pdo->query("SELECT COUNT(*) FROM hasil_perhitungan")->fetchColumn();

$stmt = $pdo->query("
    SELECT h.*, a.nama, a.nik, a.alamat, a.rt_rw
    FROM hasil_perhitungan h
    JOIN alternatif a ON a.id = h.alternatif_id
    ORDER BY h.ranking ASC
");
$ranking = $stmt->fetchAll();
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Ranking">
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
                    <h4 class="fw-bold mb-0">Ranking Hasil VIKOR</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ranking</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-4 shadow-sm" disabled>
                        <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                    </button>
                </div>
            </div>

            <?php if (empty($ranking)): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-clipboard2-data fs-1 d-block mb-3 text-muted"></i>
                    <h5 class="text-muted mb-2">Belum Ada Hasil Perhitungan</h5>
                    <p class="text-muted small mb-3">
                        Total alternatif: <strong><?php echo $totalAlternatif; ?></strong> &mdash;
                        Yang sudah dihitung: <strong><?php echo $totalDihitung; ?></strong>
                    </p>
                    <a href="<?php echo baseUrl('pages/perhitungan/index.php'); ?>" class="btn btn-danger btn-sm rounded-pill px-4">
                        <i class="bi bi-calculator me-1"></i> Mulai Perhitungan
                    </a>
                </div>
            </div>
            <?php else: ?>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                                <i class="bi bi-check2-circle text-success fs-5"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">Sudah Dihitung</p>
                                <h5 class="fw-bold mb-0"><?php echo $totalDihitung; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($totalAlternatif != $totalDihitung): ?>
            <div class="alert alert-warning border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Perhatian!</strong> Tidak semua alternatif telah dihitung. Hanya <strong><?php echo $totalDihitung; ?></strong> dari <strong><?php echo $totalAlternatif; ?></strong> alternatif yang memiliki hasil.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 60px;">RANKING</th>
                                    <th class="py-3">NAMA</th>
                                    <th class="py-3">NIK</th>
                                    <th class="py-3">ALAMAT</th>
                                    <th class="py-3">RT/RW</th>
                                    <th class="py-3 text-end">NILAI S</th>
                                    <th class="py-3 text-end">NILAI R</th>
                                    <th class="py-3 text-end">NILAI Q</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ranking as $row): ?>
                                <tr class="<?php echo $row['ranking'] == 1 ? 'table-warning fw-bold' : ''; ?>">
                                    <td class="ps-4">
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
                                    <td><code><?php echo $row['nik']; ?></code></td>
                                    <td class="text-muted small"><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['rt_rw']; ?></td>
                                    <td class="text-end font-monospace"><?php echo number_format($row['nilai_s'], 4); ?></td>
                                    <td class="text-end font-monospace"><?php echo number_format($row['nilai_r'], 4); ?></td>
                                    <td class="pe-4 text-end font-monospace"><?php echo number_format($row['nilai_q'], 4); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

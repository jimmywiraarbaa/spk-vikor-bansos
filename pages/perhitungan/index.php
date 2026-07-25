<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$alternatif = $pdo->query("SELECT * FROM alternatif ORDER BY nama ASC")->fetchAll();
$kriteria = $pdo->query("SELECT * FROM kriteria ORDER BY kode ASC")->fetchAll();
$subKriteria = $pdo->query("SELECT * FROM sub_kriteria ORDER BY kriteria_id, kode ASC")->fetchAll();

$penilaianRows = $pdo->query("SELECT * FROM penilaian")->fetchAll();
$penilaianData = [];
foreach ($penilaianRows as $row) {
    $penilaianData[$row['alternatif_id']][$row['sub_kriteria_id']] = (float) $row['nilai'];
}

$hasPenilaian = !empty($penilaianRows);
$hasEmptyCells = false;

if ($hasPenilaian) {
    foreach ($alternatif as $alt) {
        foreach ($subKriteria as $sk) {
            if (!isset($penilaianData[$alt['id']][$sk['id']])) {
                $hasEmptyCells = true;
                break 2;
            }
        }
    }
}

$vikorResult = null;
$aggregated = [];

if ($hasPenilaian && !$hasEmptyCells && !empty($alternatif)) {
    $subByKriteria = [];
    foreach ($subKriteria as $sk) {
        $subByKriteria[$sk['kriteria_id']][] = $sk;
    }

    foreach ($alternatif as $alt) {
        $aggregated[$alt['id']] = [];
        foreach ($kriteria as $k) {
            $weightedSum = 0;
            if (isset($subByKriteria[$k['id']])) {
                foreach ($subByKriteria[$k['id']] as $sk) {
                    $bobot = (float) $sk['bobot'];
                    $nilai = $penilaianData[$alt['id']][$sk['id']] ?? 0;
                    $weightedSum += $bobot * $nilai;
                }
            }
            $aggregated[$alt['id']][$k['id']] = $weightedSum;
        }
    }

    $fStar = [];
    $fWorst = [];
    foreach ($kriteria as $k) {
        $values = [];
        foreach ($alternatif as $alt) {
            $values[] = $aggregated[$alt['id']][$k['id']];
        }
        if ($k['sifat'] === 'benefit') {
            $fStar[$k['id']] = max($values);
            $fWorst[$k['id']] = min($values);
        } else {
            $fStar[$k['id']] = min($values);
            $fWorst[$k['id']] = max($values);
        }
    }

    $v = 0.5;
    $weightSum = array_sum(array_column($kriteria, 'bobot'));
    $S = [];
    $R = [];

    foreach ($alternatif as $alt) {
        $sSum = 0;
        $rMax = 0;
        foreach ($kriteria as $k) {
            $w = (float) $k['bobot'] / $weightSum;
            $fij = $aggregated[$alt['id']][$k['id']];
            $fStarVal = $fStar[$k['id']];
            $fWorstVal = $fWorst[$k['id']];

            if ($fStarVal == $fWorstVal) {
                $normalized = 0;
            } else {
                $normalized = ($fStarVal - $fij) / ($fStarVal - $fWorstVal);
            }

            $weighted = $w * $normalized;
            $sSum += $weighted;
            if ($weighted > $rMax) {
                $rMax = $weighted;
            }
        }
        $S[$alt['id']] = $sSum;
        $R[$alt['id']] = $rMax;
    }

    $Smin = min($S);
    $Smax = max($S);
    $Rmin = min($R);
    $Rmax = max($R);

    $Q = [];
    foreach ($alternatif as $alt) {
        if ($Smax == $Smin && $Rmax == $Rmin) {
            $Q[$alt['id']] = 0;
        } else {
            $Q[$alt['id']] = $v * (($S[$alt['id']] - $Smin) / ($Smax - $Smin))
                           + (1 - $v) * (($R[$alt['id']] - $Rmin) / ($Rmax - $Rmin));
        }
    }

    $ranking = [];
    foreach ($alternatif as $alt) {
        $ranking[] = [
            'id' => $alt['id'],
            'nama' => $alt['nama'],
            'nik' => $alt['nik'],
            'S' => $S[$alt['id']],
            'R' => $R[$alt['id']],
            'Q' => $Q[$alt['id']],
        ];
    }
    usort($ranking, function ($a, $b) {
        return $a['Q'] <=> $b['Q'];
    });

    $vikorResult = [
        'ranking' => $ranking,
        'aggregated' => $aggregated,
        'fStar' => $fStar,
        'fWorst' => $fWorst,
        'S' => $S,
        'R' => $R,
        'Q' => $Q,
    ];

    if (isset($_POST['simpan_hasil'])) {
        try {
            $pdo->beginTransaction();
            $pdo->exec("DELETE FROM hasil_perhitungan");
            $stmt = $pdo->prepare("INSERT INTO hasil_perhitungan (alternatif_id, nilai_s, nilai_r, nilai_q, ranking) VALUES (?, ?, ?, ?, ?)");
            foreach ($ranking as $rank => $item) {
                $stmt->execute([$item['id'], $item['S'], $item['R'], $item['Q'], $rank + 1]);
            }
            $pdo->commit();
            $_SESSION['success'] = "Hasil perhitungan berhasil disimpan.";
            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Gagal menyimpan hasil: " . $e->getMessage();
        }
    }
}
?>
<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Perhitungan">
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
                    <h4 class="fw-bold mb-0">Perhitungan VIKOR</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Perhitungan</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
                    <i class="bi bi-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show mb-4">
                    <i class="bi bi-exclamation-circle me-2"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!$hasPenilaian): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-clipboard-data fs-1 text-muted d-block mb-2"></i>
                        <p class="text-muted mb-2">Belum ada data penilaian.</p>
                        <a href="<?php echo baseUrl('pages/penilaian/index.php'); ?>" class="btn btn-danger btn-sm rounded-pill px-4">Input Penilaian</a>
                    </div>
                </div>
            <?php elseif ($hasEmptyCells): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-exclamation-triangle fs-1 text-warning d-block mb-2"></i>
                        <p class="text-muted mb-2">Masih ada penilaian yang belum diisi. Lengkapi semua penilaian terlebih dahulu.</p>
                        <a href="<?php echo baseUrl('pages/penilaian/index.php'); ?>" class="btn btn-danger btn-sm rounded-pill px-4">Lengkapi Penilaian</a>
                    </div>
                </div>
            <?php elseif ($vikorResult): ?>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-table me-2 text-danger"></i>Matriks Agregasi (Bobot Terbobot Sub-Kriteria)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-3 py-2">Alternatif</th>
                                    <?php foreach ($kriteria as $k): ?>
                                    <th class="text-center py-2"><?php echo $k['kode']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alternatif as $alt): ?>
                                <tr>
                                    <td class="ps-3 fw-medium"><?php echo $alt['nama']; ?></td>
                                    <?php foreach ($kriteria as $k): ?>
                                    <td class="text-center"><?php echo number_format($vikorResult['aggregated'][$alt['id']][$k['id']], 4); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="table-success">
                                    <td class="ps-3 fw-bold">f* (Best)</td>
                                    <?php foreach ($kriteria as $k): ?>
                                    <td class="text-center fw-bold"><?php echo number_format($vikorResult['fStar'][$k['id']], 4); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr class="table-danger">
                                    <td class="ps-3 fw-bold">f- (Worst)</td>
                                    <?php foreach ($kriteria as $k): ?>
                                    <td class="text-center fw-bold"><?php echo number_format($vikorResult['fWorst'][$k['id']], 4); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-calculator me-2 text-danger"></i>Nilai S, R, Q & Ranking</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-3 py-2">Ranking</th>
                                    <th class="py-2">Alternatif</th>
                                    <th class="text-center py-2">S</th>
                                    <th class="text-center py-2">R</th>
                                    <th class="text-center py-2">Q</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vikorResult['ranking'] as $rank => $item): ?>
                                <tr class="<?php echo $rank === 0 ? 'table-warning fw-bold' : ''; ?>">
                                    <td class="ps-3">
                                        <?php if ($rank === 0): ?>
                                        <span class="badge bg-danger rounded-pill px-2">1</span>
                                        <?php else: ?>
                                        <span class="text-muted"><?php echo $rank + 1; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium"><?php echo $item['nama']; ?></td>
                                    <td class="text-center"><?php echo number_format($item['S'], 4); ?></td>
                                    <td class="text-center"><?php echo number_format($item['R'], 4); ?></td>
                                    <td class="text-center fw-bold"><?php echo number_format($item['Q'], 4); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-3 text-end">
                    <form method="POST">
                        <button type="submit" name="simpan_hasil" class="btn btn-danger px-5 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Hasil
                        </button>
                    </form>
                </div>
            </div>

            <?php endif; ?>
        </div>
    </div>
</div>
<?php include_once '../../templates/footer.php'; ?>

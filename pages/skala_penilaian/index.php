<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$stmt = $pdo->query("
    SELECT sp.*, sk.kode as sub_kriteria_kode, sk.nama as sub_kriteria_nama, k.kode as kriteria_kode
    FROM skala_penilaian sp
    JOIN sub_kriteria sk ON sp.sub_kriteria_id = sk.id
    JOIN kriteria k ON sk.kriteria_id = k.id
    ORDER BY k.kode ASC, sk.kode ASC, sp.nilai ASC
");
$skala = $stmt->fetchAll();

$grouped = [];
foreach ($skala as $row) {
    $key = $row['sub_kriteria_id'];
    if (!isset($grouped[$key])) {
        $grouped[$key] = [
            'kriteria_kode' => $row['kriteria_kode'],
            'sub_kriteria_kode' => $row['sub_kriteria_kode'],
            'sub_kriteria_nama' => $row['sub_kriteria_nama'],
            'items' => []
        ];
    }
    $grouped[$key]['items'][] = $row;
}
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Skala Penilaian">
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
                    <h4 class="fw-bold mb-0">Skala Penilaian</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Skala Penilaian</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <?php foreach ($grouped as $group): ?>
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-light border-0 py-3 px-4">
                    <span class="badge bg-danger bg-opacity-10 text-danger border-0 px-3 py-2 me-2">
                        <?php echo $group['kriteria_kode']; ?>
                    </span>
                    <span class="fw-bold"><?php echo $group['sub_kriteria_kode']; ?> - <?php echo $group['sub_kriteria_nama']; ?></span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 py-2" style="width: 80px;">NILAI</th>
                                <th class="py-2">KETERANGAN</th>
                                <th class="pe-4 py-2 text-end" style="width: 100px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($group['items'] as $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-danger"><?php echo $item['nilai']; ?></td>
                                <td><?php echo $item['keterangan']; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn btn-light btn-sm rounded-circle p-1 me-1 border shadow-sm">
                                        <i class="bi bi-pencil text-primary small"></i>
                                    </a>
                                    <a href="../../actions/skala_action.php?delete=<?php echo $item['id']; ?>" class="btn btn-light btn-sm rounded-circle p-1 border shadow-sm" onclick="return confirm('Yakin ingin menghapus skala ini?')">
                                        <i class="bi bi-trash text-danger small"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

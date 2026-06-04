<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();
include_once '../../templates/header.php';

$stmt = $pdo->query("SELECT * FROM alternatif ORDER BY nama ASC");
$alternatif = $stmt->fetchAll();
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>

    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi Alternatif">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" id="dropdownUser" data-bs-toggle="dropdown">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </div>
                            <span class="fw-medium small"><?php echo $_SESSION['username']; ?></span>
                            <i class="bi bi-chevron-down user-arrow-icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                            <li><a class="dropdown-item py-2 text-danger" href="<?php echo baseUrl('actions/auth_action.php?logout=1'); ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Data Alternatif</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Alternatif</li>
                        </ol>
                    </nav>
                </div>
                <a href="tambah.php" class="btn btn-danger btn-sm px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Alternatif
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 50px;">NO</th>
                                    <th class="py-3">NAMA</th>
                                    <th class="py-3">NIK</th>
                                    <th class="py-3">ALAMAT</th>
                                    <th class="py-3">RT/RW</th>
                                    <th class="py-3">KELURAHAN</th>
                                    <th class="py-3">KECAMATAN</th>
                                    <th class="py-3">NO HP</th>
                                    <th class="pe-4 py-3 text-end" style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($alternatif)): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        Belum ada data alternatif
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($alternatif as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted"><?php echo $no++; ?></td>
                                    <td class="fw-medium"><?php echo $row['nama']; ?></td>
                                    <td><code><?php echo $row['nik']; ?></code></td>
                                    <td class="text-muted small"><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['rt_rw']; ?></td>
                                    <td><?php echo $row['kelurahan']; ?></td>
                                    <td><?php echo $row['kecamatan']; ?></td>
                                    <td><?php echo $row['no_hp'] ?: '-'; ?></td>
                                    <td class="pe-4 text-end">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 me-1 border shadow-sm">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </a>
                                        <a href="../../actions/alternatif_action.php?delete=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 border shadow-sm" onclick="return confirm('Yakin ingin menghapus alternatif ini? Semua penilaian terkait juga akan terhapus.')">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

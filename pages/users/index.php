<?php
require_once '../../includes/auth_helper.php';
require_once '../../includes/db.php';
checkLogin();

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Akses ditolak.";
    header("Location: " . baseUrl('pages/dashboard.php'));
    exit;
}

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();

$currentUser = $_SESSION['user_id'] ?? null;

include_once '../../templates/header.php';
?>

<div id="wrapper">
    <?php include_once '../../templates/sidebar.php'; ?>
    <div id="content">
        <nav class="navbar navbar-expand-lg top-navbar" aria-label="Navigasi User">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-light border-0"><i class="bi bi-list"></i></button>
                <div class="ms-auto d-flex align-items-center"><span class="fw-medium small"><?php echo $_SESSION['username']; ?></span></div>
            </div>
        </nav>

        <div class="main-content animate-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Data User</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="../dashboard.php" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                </div>
                <a href="tambah.php" class="btn btn-danger btn-sm px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah User
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

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 60px;">NO</th>
                                    <th class="py-3">USERNAME</th>
                                    <th class="py-3">EMAIL</th>
                                    <th class="py-3">ROLE</th>
                                    <th class="py-3">TANGGAL DAFTAR</th>
                                    <th class="pe-4 py-3 text-end" style="width: 150px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">Belum ada data user.</td>
                                </tr>
                                <?php else: $no = 1; foreach ($users as $row): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?php echo $no++; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td class="text-muted"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <?php if ($row['role'] === 'admin'): ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border-0 px-3 py-2">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border-0 px-3 py-2">Operator</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                    <td class="pe-4 text-end">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 me-1 border shadow-sm">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </a>
                                        <?php if ($row['id'] != $currentUser): ?>
                                        <a href="../../actions/user_action.php?delete=<?php echo $row['id']; ?>" class="btn btn-light btn-sm rounded-circle p-2 border shadow-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="bi bi-trash text-danger"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../../templates/footer.php'; ?>

<?php
require_once '../includes/auth_helper.php';
checkLogin();
include '../templates/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">SPK VIKOR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users/index.php">Manajemen User</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Halo, <?php echo $_SESSION['username']; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../actions/auth_action.php?logout=1">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2 class="fw-bold">Selamat Datang, <?php echo $_SESSION['username']; ?>! 👋</h2>
            <p class="text-muted">Gunakan sistem ini untuk melakukan perhitungan bantuan sosial dengan metode VIKOR.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#4e73df" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2 2 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                        </svg>
                    </div>
                    <h5 class="fw-bold mb-1">Manajemen User</h5>
                    <p class="small text-muted">Kelola data admin dan pengguna sistem.</p>
                    <a href="users/index.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">Buka Fitur</a>
                </div>
            </div>
        </div>
        <!-- Card lainnya bisa ditambahkan di sini -->
    </div>
</div>

<?php include '../templates/footer.php'; ?>

<!-- templates/sidebar.php -->
<nav id="sidebar">
    <div class="sidebar-header text-center">
        <img src="<?php echo baseUrl('public/img/logo-remove-bg.png'); ?>" alt="Logo" class="img-fluid mb-2" style="max-height: 60px;">
        <h5 class="fw-bold mb-0" style="color: #d9534f;">SPK VIKOR</h5>
        <small class="text-muted">Dinas Sosial Merangin</small>
    </div>

    <ul class="list-unstyled components">

        <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
            <a href="<?php echo baseUrl('pages/dashboard.php'); ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <div class="menu-label">Data Master</div>
        <li>
            <a href="#dataKriteriaMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex align-items-center justify-content-between">
                <span><i class="bi bi-list-task"></i> Data Master</span>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], 'kriteria') !== false || strpos($_SERVER['PHP_SELF'], 'alternatif') !== false) ? 'show' : ''; ?>" id="dataKriteriaMenu">
                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'kriteria/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/kriteria/index.php'); ?>">Data Kriteria</a>
                </li>

                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'sub_kriteria/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/sub_kriteria/index.php'); ?>">Data Sub-Kriteria</a>
                </li>
                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'alternatif/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/alternatif/index.php'); ?>">Data Alternatif</a>
                </li>
            </ul>
        </li>

        <div class="menu-label">Analisis</div>
        <li>
            <a href="#prosesMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex align-items-center justify-content-between">
                <span><i class="bi bi-calculator"></i> Proses VIKOR</span>
                <i class="bi bi-chevron-down arrow-icon"></i>
            </a>
            <ul class="collapse list-unstyled <?php echo (strpos($_SERVER['PHP_SELF'], 'penilaian') !== false || strpos($_SERVER['PHP_SELF'], 'perhitungan') !== false) ? 'show' : ''; ?>" id="prosesMenu">
                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'penilaian/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/penilaian/index.php'); ?>">Input Penilaian</a>
                </li>
                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'perhitungan/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/perhitungan/index.php'); ?>">Hasil Perhitungan</a>
                </li>
                <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'ranking/') !== false) ? 'active' : ''; ?>">
                    <a href="<?php echo baseUrl('pages/ranking/index.php'); ?>">Ranking</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo baseUrl('pages/skala_penilaian/index.php'); ?>" class="<?php echo (strpos($_SERVER['PHP_SELF'], 'skala_penilaian') !== false) ? 'text-danger fw-bold' : ''; ?>">
                <i class="bi bi-rulers"></i> Skala Penilaian
            </a>
        </li>
        <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'laporan/') !== false) ? 'active' : ''; ?>">
            <a href="<?php echo baseUrl('pages/laporan/index.php'); ?>">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
        </li>

        <div class="menu-label">Sistem</div>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'users/') !== false) ? 'active' : ''; ?>">
                <a href="<?php echo baseUrl('pages/users/index.php'); ?>">
                    <i class="bi bi-people"></i> Manajemen User
                </a>
            </li>
        <?php endif; ?>
        <li class="<?php echo (strpos($_SERVER['PHP_SELF'], 'profil/') !== false) ? 'active' : ''; ?>">
            <a href="<?php echo baseUrl('pages/profil/index.php'); ?>">
                <i class="bi bi-person-circle"></i> Profil
            </a>
        </li>
        <li>
            <a href="<?php echo baseUrl('actions/auth_action.php?logout=1'); ?>" class="text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</nav>
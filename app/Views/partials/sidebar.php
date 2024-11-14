<!-- ======= Sidebar ======= -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Identitas Aplikasi -->
    <a href="<?= base_url() ?>/index3.html" class="brand-link bg-primary">
        <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= env('APP_NAME') ?></span>
    </a>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <!-- Pilihan Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Menu General (Semua Level) -->
                <li class="nav-header">General</li>
                <li class="nav-item <?= (uri_string() == 'dashboard') ? 'active' : ''; ?>">
                    <a href="/dashboard" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Menu Level User/Pelapor -->
                <?php if (in_array('user', session()->get('level'))): ?>
                <?php $userId = session()->get('id_user') ?>
                <li class="nav-header">Pelapor</li>
                <li class="nav-item <?= (preg_match('/^pengaduan\/user\/[a-zA-Z0-9-]+$/', uri_string()) 
                || preg_match('/^pengaduan\/edit\/[a-zA-Z0-9-]+$/', uri_string()) 
                || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
                    <a href="/pengaduan/user/<?= $userId ?>" class="nav-link <?= (preg_match('/^pengaduan\/user\/[a-zA-Z0-9-]+$/', uri_string()) 
                    || preg_match('/^pengaduan\/edit\/[a-zA-Z0-9-]+$/', uri_string()) 
                    || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Pengaduan Saya</p>
                    </a>
                </li>

                <li class="nav-item <?= (preg_match('/^pengaduan\/user\/riwayat\/[a-zA-Z0-9-]+$/', uri_string())) ? 'active' : ''; ?>">
                    <a href="/pengaduan/user/riwayat/<?= $userId ?>" class="nav-link <?= (preg_match('/^pengaduan\/user\/riwayat\/[a-zA-Z0-9-]+$/', uri_string())) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Pengaduan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bookmark"></i>
                        <p>Bookmarks</p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Operator -->
                <?php if (in_array('operator', session()->get('level'))): ?>
                <li class="nav-header">Operator</li>
                <li class="nav-item <?= (uri_string() == 'pengaduan/operator') ? 'active' : ''; ?>">
                    <a href="/pengaduan/operator" class="nav-link <?= (uri_string() == 'pengaduan/operator') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-envelope-open"></i>
                        <p>Pengaduan Masuk</p>
                    </a>
                </li>

                <li class="nav-item <?= (uri_string() == 'pengaduan/operator/riwayat') ? 'active' : ''; ?>">
                    <a href="/pengaduan/operator/riwayat" class="nav-link <?= (uri_string() == 'pengaduan/operator/riwayat') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Pengaduan</p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Verifikator -->
                <?php if (in_array('verifikator', session()->get('level'))): ?>
                <li class="nav-header">Verifikator</li>

                <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                    <a href="/pengaduan/verifikator" class="nav-link <?= (uri_string() == 'pengaduan/verifikator') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-envelope-open"></i>
                        <p>Pengaduan Masuk</p>
                    </a>
                </li>

                <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                    <a href="/pengaduan/verifikator/riwayat" class="nav-link <?= (uri_string() == 'pengaduan/verifikator/riwayat') ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Pengaduan</p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Superadmin -->
                <?php if (in_array('superadmin', session()->get('level'))): ?>
                    <li class="nav-header">Super Admin</li>
                <li class="nav-item <?= (uri_string() == 'user-level') 
                || (uri_string() == 'user-level/assign')
                || preg_match('/^user-level\/edit\/[a-zA-Z0-9-]+$/', uri_string()) ? 'active' : ''; ?>">
                    <a href="/user-level" class="nav-link <?= (uri_string() == 'user-level') 
                    || (uri_string() == 'user-level/assign')
                    || preg_match('/^user-level\/edit\/[a-zA-Z0-9-]+$/', uri_string()) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Manajemen Level</p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Lainnya (Semua Level) -->
                <li class="nav-header">Lainnya</li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Keluar</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<!-- ======= Sidebar ======= -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Identitas Aplikasi -->
    <a href="<?= base_url() ?>/index3.html" class="brand-link bg-primary">
        <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= env('APP_NAME') ?></span>
    </a>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <!-- Profil User (not used) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="<?= base_url() ?>dist/img/anonymous.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">Pelapor</a>
            </div>
        </div> -->
        
        <!-- Pilihan Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Menu General (Semua Level) -->
                <li class="nav-header">General</li>
                <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                    <a href="/dashboard" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Menu Level User/Pelapor -->
                <?php if (in_array('user', session()->get('level'))): ?>
                <?php $userId = session()->get('id_user') ?>
                <li class="nav-header">Pelapor</li>
                <li class="nav-item <?= (preg_match('/^pengaduan\/user\/\d+$/', uri_string()) || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
                    <a href="/pengaduan/user/<?= $userId ?>" class="nav-link <?= (preg_match('/^pengaduan\/user\/\d+$/', uri_string()) || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Pengaduan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Riwayat Pengaduan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>
                            Bookmarks
                        </p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Operator -->
                <?php if (in_array('operator', session()->get('level'))): ?>
                <li class="nav-header">Operator</li>
                <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                    <a href="/pengaduan" class="nav-link <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-tasks"></i>
                        <p>
                            Semua Pengaduan
                        </p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Verifikator -->
                <?php if (in_array('verifikator', session()->get('level'))): ?>
                <li class="nav-header">Verifikator</li>
                <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                    <a href="/pengaduan" class="nav-link <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-tasks"></i>
                        <p>
                            Semua Pengaduan
                        </p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Level Superadmin -->
                <?php if (in_array('superadmin', session()->get('level'))): ?>
                    <li class="nav-header">Super Admin</li>
                <li class="nav-item <?= (uri_string() == 'level') ? 'active' : ''; ?>">
                    <a href="/user-level" class="nav-link <?= (uri_string() == 'level') ? 'active' : ''; ?>">
                        <i class="nav-icon fa fa-tasks"></i>
                        <p>
                            Manajemen Level
                        </p>
                    </a>
                </li>
                <?php endif ?>

                <!-- Menu Lainnya (Semua Level) -->
                <li class="nav-header">Lainnya</li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link">
                        <i class="nav-icon fa fa-tasks"></i>
                        <p>
                            Keluar
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    </aside>
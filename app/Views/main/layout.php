<!DOCTYPE html>
<html lang="en">
    <!-- HEADER -->
    <head>
        <!-- INISIALISASI HALAMAN -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WBS Buleleng</title>

        <!-- STYLESHEET -->
        <!-- =========================================================================================== -->
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
        <!-- DateTime Picker -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- =========================================================================================== -->
    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <!-- NAVBAR -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- HAMBURGER -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <!-- EXPAND -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- SIDEBAR -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- LOGO APLIKASI -->
                <a href="<?= base_url() ?>/index3.html" class="brand-link">
                    <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">WBS Buleleng</span>
                </a>

                <div class="sidebar">
                    <!-- USER PROFILE -->
                    <!-- Sidebar user (optional) -->
                    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                        <img src="<?= base_url() ?>dist/img/anonymous.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                        <a href="#" class="d-block">Pelapor</a>
                        </div>
                    </div> -->
                    
                    <!-- SIDEBAR MENU -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            
                            <!-- MENU GENERAL | SEMUA ROLE -->
                            <li class="nav-header">General</li>
                            <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                <a href="/dashboard" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <!-- MENU ROLE PELAPOR -->
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

                            <!-- MENU ROLE OPERATOR -->
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

                            <!-- MENU ROLE VERIFIKATOR -->
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

                            <!-- MENU ROLE SUPER ADMIN -->
                            <?php if (in_array('superadmin', session()->get('level'))): ?>
                                <li class="nav-header">Super Admin</li>
                            <li class="nav-item <?= (uri_string() == 'level') ? 'active' : ''; ?>">
                                <a href="/userlevel" class="nav-link <?= (uri_string() == 'level') ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-tasks"></i>
                                    <p>
                                        Manajemen Level
                                    </p>
                                </a>
                            </li>
                            <?php endif ?>

                            <!-- MENU LAINNYA | SEMUA ROLE-->
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

            <!-- WRAPPER KONTEN UTAMA -->
            <div class="content-wrapper">
                <!-- HEADER KONTEN -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <!-- JUDUL -->
                            <div class="col-sm-6">
                                <h1>
                                    <?= $this->renderSection('judul') ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ISI KONTEN -->
                <section class="content">
                    <div class="card card-outline card-primary">
                        <!-- HEADER CARD -->
                        <div class="card-header">
                            <!-- SUBJUDUL -->
                            <h3 class="card-title">
                            <?= $this->renderSection('subjudul') ?>
                            </h3>
                            <!-- COLLAPES BUTTON -->
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- ISI -->
                        <div class="card-body">
                        <?= $this->renderSection('isi') ?>
                        </div>
                    </div>
                </section>
            </div>

            <!-- FOOTER -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; Brandon</strong> All rights reserved.
            </footer>

            
            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>

        <!-- GLOBAL SCRIPTS -->
        <!-- =========================================================================================== -->
        <!-- jQuery -->
        <script src="<?= base_url() ?>plugins/jquery/jquery.min.js"></script>
        <!-- jQuery for adding/removing rows -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url() ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>
        <!-- DataTables JS -->
        <script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url() ?>/plugins/jszip/jszip.min.js"></script>
        <script src="<?= base_url() ?>/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="<?= base_url() ?>/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="<?= base_url() ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- DateTime Picker -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
        <!-- Sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- DataTables Initialization -->
        <script>
            $(function () {
                $('#pengaduanTable').DataTable({
                    "lengthMenu": [5, 10, 25, 50, 100],
                    "pageLength": 5,
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "language": {
                        "url": "<?= base_url() ?>/plugins/datatables/i18n/Indonesian.json"
                    },
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#pengaduanTable_wrapper .col-md-6:eq(0)');
            });
        </script>
        <!-- =========================================================================================== -->
        
        <!-- INDIVIDUAL PAGE SCRIPTS -->
        <?= $this->renderSection('scripts') ?>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WBS Buleleng</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    </head>

    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="<?= base_url() ?>/index3.html" class="brand-link">
                    <img src="<?= base_url() ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">WBS Buleleng</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                        <img src="<?= base_url() ?>dist/img/anonymous.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                        <a href="#" class="d-block">Pelapor</a>
                        </div>
                    </div> -->
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Menu general, menu yang selalu ada -->
                            <li class="nav-header">General</li>
                            <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                <a href="/dashboard" class="nav-link <?= (uri_string() == 'dashboard') ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <!-- Cek apakah user memiliki role "pelapor" -->
                            <?php if (in_array('user', session()->get('level'))): ?>
                            <li class="nav-header">Pelapor</li>
                            <li class="nav-item <?= (preg_match('/^pengaduan\/user\/\d+$/', uri_string()) || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
                                <a href="/pengaduan/user/1" class="nav-link <?= (preg_match('/^pengaduan\/user\/\d+$/', uri_string()) || uri_string() == 'pengaduan/create') ? 'active' : ''; ?>">
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

                            <!-- Cek apakah user memiliki role "operator" -->
                            <?php if (in_array('operator', session()->get('level'))): ?>
                            <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                <a href="/pengaduan" class="nav-link <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-tasks"></i>
                                    <p>
                                        Semua Pengaduan
                                    </p>
                                </a>
                            </li>
                            <?php endif ?>

                            <!-- Cek apakah user memiliki role "operator" -->
                            <?php if (in_array('operator', session()->get('level'))): ?>
                            <li class="nav-item <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                <a href="/pengaduan" class="nav-link <?= (uri_string() == 'pengaduan') ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-tasks"></i>
                                    <p>
                                        Semua Pengaduan
                                    </p>
                                </a>
                            </li>
                            <?php endif ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    <?= $this->renderSection('judul') ?>
                                </h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                            <?= $this->renderSection('subjudul') ?>
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                        <?= $this->renderSection('isi') ?>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; Brandon</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="<?= base_url() ?>plugins/jquery/jquery.min.js"></script>
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

    </body>

</html>
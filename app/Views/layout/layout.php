<!DOCTYPE html>
<html lang="en">

<head>
<?= $this->include('partials/head') ?>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed background-color">
    <div class="wrapper">
        <!-- ======= Topbar ======= -->
        <?= $this->include('partials/topbar') ?>

        <!-- ======= Sidebar ======= -->
        <?= $this->include('partials/sidebar') ?>
    
        <!-- ======= Main ======= -->
        <div class="content-wrapper background-color">
            <!-- Content Header -->
            <section class="content-header background-color">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="font-weight-bold">
                                <?= $this->renderSection('judul') ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Content Body -->
            <section class="content background-color">
                <?= $this->renderSection('isi') ?>
            </section>
        </div>
        
        <!-- ======= Footer ======= -->
        <?= $this->include('partials/footer') ?>
        
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>
    </div>

    <!-- ======= Scripts ======= -->
    <?= $this->include('partials/scripts') ?>
     
    <!-- ======= Scripts Tambahan ======= -->
    <!-- Scripts khusus suatu halaman, di inisialisasikan di kode halaman itu sendiri -->
    <?= $this->renderSection('scripts') ?>
</body>

</html>
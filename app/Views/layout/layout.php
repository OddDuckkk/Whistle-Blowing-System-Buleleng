<!DOCTYPE html>
<html lang="en">

<head>
<?= $this->include('partials/head') ?>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <div class="wrapper">
        <!-- ======= Topbar ======= -->
        <?= $this->include('partials/topbar') ?>

        <!-- ======= Sidebar ======= -->
        <?= $this->include('partials/sidebar') ?>
    
        <!-- ======= Main ======= -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                <?= $this->renderSection('judul') ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Content Body -->
            <section class="content">
                <div class="card card-outline card-primary">
                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 class="card-title">
                        <?= $this->renderSection('card-header') ?>
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="card-body p-5">
                    <?= $this->renderSection('isi') ?>
                    </div>
                </div>
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
<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Statistik Pengaduan
<?= $this->endSection('judul') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="card">
    <!-- Content -->
    <div class="card-body p-5">
    <div class="pb-3">
        <h5 class="text-primary"><strong>JUMLAH PENGADUAN</strong></h5>
    </div>
    <div class="row">
        <!-- Total Pengaduan -->
        <div class="col-md-3">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fa fa-list-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pengaduan</span>
                    <span class="info-box-number"><?= $totalPengaduan ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        Pengaduan di Sistem
                    </span>
                </div>
            </div>
        </div>

        <!-- Completed Pengaduan (Selesai) -->
        <div class="col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pengaduan Selesai</span>
                    <span class="info-box-number"><?= $completedPengaduan ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $completedPercentage ?>%"></div>
                    </div>
                    <span class="progress-description">
                        <?= number_format($completedPercentage, 2) ?>% dari Total
                    </span>
                </div>
            </div>
        </div>
        <!-- In-Progress Pengaduan -->
        <div class="col-md-3">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fa fa-spinner"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pengaduan Diproses</span>
                        <span class="info-box-number"><?= $inProgressPengaduan ?></span>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?= $inProgressPercentage ?>%"></div>
                        </div>
                        <span class="progress-description">
                            <?= number_format($inProgressPercentage, 2) ?>% dari Total
                        </span>
                    </div>
                </div>
        </div>

        <!-- Rejected Pengaduan (Ditolak) -->
        <div class="col-md-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fa fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pengaduan Ditolak</span>
                    <span class="info-box-number"><?= $rejectedPengaduan ?></span>
                    <div class="progress">
                        <div class="progress-bar" style="width: <?= $rejectedPercentage ?>%"></div>
                    </div>
                    <span class="progress-description">
                        <?= number_format($rejectedPercentage, 2) ?>% dari Total
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3">
        <h5 class="text-primary"><strong>JUMLAH PENGADUAN BERDASARKAN WAKTU</strong></h5>
    </div>
    <div class="row">
        <!-- Pengaduan Created Today -->
        <div class="col-md-4">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fa fa-calendar-day"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Pengaduan Hari ini</span>
                        <span class="info-box-number"><?= $pengaduanToday ?></span>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Created This Month -->
            <div class="col-md-4">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fa fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Pengaduan Bulan ini</span>
                        <span class="info-box-number"><?= $pengaduanThisMonth ?></span>
                    </div>
                </div>
            </div>

            <!-- Pengaduan Created This Year -->
            <div class="col-md-4">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Pengaduan Tahun ini</span>
                        <span class="info-box-number"><?= $pengaduanThisYear ?></span>
                    </div>
                </div>
            </div>
    </div>

    <div class="py-3">
        <h5 class="text-primary"><strong>GRAFIK PENGADUAN</strong></h5>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Grafik Total Pengaduan</h3>
                </div>
                <div class="card-body d-flex justify-content-center m-0">
                    <div style="width: 100%; height: 300px;">
                        <canvas id="donutChart" style="width: 100%; height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pengaduan per Bulan</h3>
                </div>
                <div class="card-body d-flex justify-content-center m-0">
                    <div style="width: 100%; height: 300px;">
                        <canvas id="areaChart" style="width: 100%; height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Index Pengaduan -->
<script>
    var completedPengaduan = <?= $completedPengaduan ?>;
    var inProgressPengaduan = <?= $inProgressPengaduan ?>;
    var rejectedPengaduan = <?= $rejectedPengaduan ?>;
    var monthlyData = <?= json_encode($monthlyData) ?>;
</script>
<script src="<?= base_url() ?>/dist/js/pages/statistik_pengaduan.js"></script>
<?= $this->endSection('scripts') ?>
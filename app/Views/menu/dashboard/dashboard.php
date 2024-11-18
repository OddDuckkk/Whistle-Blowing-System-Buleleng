<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Selamat Datang di WBS Buleleng
<?= $this->endSection('judul') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="card">
    <!-- Content -->
    <div class="card-body p-5">
        <?php $userId = session()->get('id_user') ?>
        <div class="container mt-4">
            <!-- Greeting Section -->
            <div class="text-center p-4 rounded shadow">
                <h1 class="mb-3">Selamat Datang di Whistle Blowing System Buleleng</h1>
                <p>
                    Whistle Blowing System (WBS) adalah platform aman dan terpercaya untuk melaporkan pelanggaran 
                    di lingkungan kerja. Mari bersama-sama menciptakan budaya kerja yang jujur dan transparan.
                </p>
            </div>

            <!-- Ajukan Pengaduan Button -->
            <div class="text-center mt-5">
                <a href="/pengaduan/user/<?= $userId ?>" class="btn btn-primary btn-lg shadow-sm" style="padding: 10px 40px; border-radius: 30px;">
                    <i class="fa fa-paper-plane"></i> Ajukan Pengaduan
                </a>
            </div>

            <!-- Timeline Section -->
            <div class="mt-5">
                <h2 class="text-center mb-4">Proses Pengaduan</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon bg-primary text-white"><i class="fa fa-edit"></i></div>
                        <div class="timeline-content">
                            <h4>1. Pengajuan Pengaduan</h4>
                            <p>Ajukan pengaduan dengan mengisi informasi lengkap pada formulir yang tersedia.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-info text-white"><i class="fa fa-check"></i></div>
                        <div class="timeline-content">
                            <h4>2. Verifikasi Operator</h4>
                            <p>Operator kami akan memverifikasi kelengkapan dan keabsahan laporan Anda.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-warning text-white"><i class="fa fa-user-check"></i></div>
                        <div class="timeline-content">
                            <h4>3. Verifikasi Verifikator</h4>
                            <p>Pengaduan yang valid diteruskan ke verifikator untuk pemeriksaan lebih lanjut.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-success text-white"><i class="fa fa-gavel"></i></div>
                        <div class="timeline-content">
                            <h4>4. Penyelesaian</h4>
                            <p>Jika terbukti, langkah-langkah penyelesaian akan diambil dengan tindakan yang sesuai.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon bg-dark text-white"><i class="fa fa-folder-check"></i></div>
                        <div class="timeline-content">
                            <h4>5. Penutupan Kasus</h4>
                            <p>Kasus dianggap selesai setelah semua tindakan yang diperlukan telah dilakukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styling for the Timeline -->
<style>
    .timeline {
        position: relative;
        padding: 0;
        margin: 0 auto;
        max-width: 800px;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
    }

    .timeline-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 20px;
        font-size: 20px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .timeline-content {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .timeline-content h4 {
        margin-top: 0;
        color: #333;
    }

    .timeline-content p {
        margin: 0;
        color: #555;
    }
</style>

<?= $this->endSection('isi') ?>

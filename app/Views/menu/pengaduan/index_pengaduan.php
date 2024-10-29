<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Data Pengaduan
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<div class="card-tools">
        <a href="<?= base_url('pengaduan/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pengaduan Baru
        </a>
</div>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<!-- Tabel Daftar Pengaduan -->
<table id="pengaduanTable" class="table datatable table-bordered">
    <!-- Header Tabel -->
    <thead>
        <tr>
            <th>Nomor Pengaduan</th>
            <th>Judul</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <!-- Body Tabel -->
    <tbody>
        <?php foreach ($pengaduan as $p): ?>
            <tr>
                <td><?= $p['nomor_pengaduan']; ?></td>
                <td><?= $p['judul']; ?></td>
                <td>
                <?php
                    $locale = 'id_ID';
                    $date = new DateTime($p['tanggal']);
                    $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    echo $formatter->format($date);
                ?>
                </td>
                <td>
                    <span class="badge custom-badge 
                    <?php if ($p['status'] == 'baru') echo 'badge-primary'; ?>
                    <?php if ($p['status'] == 'diproses operator') echo 'badge-warning'; ?>
                    <?php if ($p['status'] == 'diproses verifikator') echo 'badge-warning'; ?>
                    <?php if ($p['status'] == 'selesai') echo 'badge-success'; ?>
                    <?php if ($p['status'] == 'ditolak') echo 'badge-danger'; ?>">

                    <?php if ($p['status'] == 'baru') echo 'baru'; ?>
                    <?php if ($p['status'] == 'diproses operator') echo 'diproses operator'; ?>
                    <?php if ($p['status'] == 'diproses verifikator') echo 'diproses operator'; ?>
                    <?php if ($p['status'] == 'selesai') echo 'selesai'; ?>
                    <?php if ($p['status'] == 'ditolak') echo 'ditolak'; ?>
                    </span>
                </td>
                <td>
                    <a href="<?= base_url('pengaduan/details/' . $p['id']); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="<?= base_url('pengaduan/edit/' . $p['id']); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('pengaduan/delete/' . $p['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection('isi') ?>

<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Data Pengaduan
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<div class="card-tools">
        <a href="<?= base_url('pengaduan/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pengaduan Baru
        </a>
</div>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<!-- <div class="card-header">
    
</div> -->
<div class="card-body">
    <table id="pengaduanTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Pengaduan</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status Pengajuan</th>
                <th>Status Verifikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengaduan as $p): ?>
                <tr>
                    <td><?= $p['nomor_pengaduan']; ?></td>
                    <td><?= $p['judul']; ?></td>
                    <td><?= $p['tanggal']; ?></td>
                    <td>
                        <span class="rounded-0 badge 
                        <?php if ($p['status'] == 'diproses operator') echo 'badge-warning'; ?>
                        <?php if ($p['status'] == 'diproses verifikator') echo 'badge-success'; ?>
                        <?php if ($p['status'] == 'selesai') echo 'badge-success'; ?>
                        <?php if ($p['status'] == 'ditolak operator') echo 'badge-danger'; ?>
                        <?php if ($p['status'] == 'ditolak verifikator') echo 'badge-success'; ?>">
                        <?php if ($p['status'] == 'diproses operator') echo 'diproses operator'; ?>
                        <?php if ($p['status'] == 'diproses verifikator') echo 'diterima operator'; ?>
                        <?php if ($p['status'] == 'selesai') echo 'diterima operator'; ?>
                        <?php if ($p['status'] == 'ditolak operator') echo 'ditolak operator'; ?>
                        <?php if ($p['status'] == 'ditolak verifikator') echo 'diterima operator'; ?>
                        </span>
                    </td>
                    <td>
                        <span class="rounded-0 badge
                        <?php if ($p['status'] == 'diproses operator') echo 'badge-secondary'; ?>
                        <?php if ($p['status'] == 'diproses verifikator') echo 'badge-warning'; ?>
                        <?php if ($p['status'] == 'selesai') echo 'badge-sucess'; ?>
                        <?php if ($p['status'] == 'ditolak operator') echo 'badge-warning'; ?>
                        <?php if ($p['status'] == 'ditolak verifikator') echo 'badge-danger'; ?>">
                        <?php if ($p['status'] == 'diproses operator') echo 'diproses verifikator'; ?>
                        <?php if ($p['status'] == 'diproses verifikator') echo 'diproses verifikator'; ?>
                        <?php if ($p['status'] == 'selesai') echo 'diterima verifikator'; ?>
                        <?php if ($p['status'] == 'ditolak operator') echo 'ditolak operator'; ?>
                        <?php if ($p['status'] == 'ditolak verifikator') echo 'ditolak verifikator'; ?>
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
</div>

<?= $this->endSection('isi') ?>

<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Daftar Level Pengguna
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<a href="<?= base_url('/user-level/assign'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Level</a>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="card-body">
    <table id="userLevelTable" class="table datatable table-bordered">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan Pegawai</th>
                <th>Unit Kerja</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($userLevels)): ?>
                <?php foreach ($userLevels as $userLevel): ?>
                    <tr>
                        <td><?= esc($userLevel['nip']); ?></td>
                        <td><?= esc($userLevel['nama_pegawai']); ?></td>
                        <td><?= esc($userLevel['jabatan_pegawai']); ?></td>
                        <td><?= esc($userLevel['unit_kerja']); ?></td>
                        <td><?= esc($userLevel['level']); ?></td> 
                        <td>
                            <a href="<?= base_url('user-level/edit/' . $userLevel['nip']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a id="delete-user-level" class="btn btn-danger btn-sm" onclick="confirmDelete('<?= $userLevel['nip']; ?>')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Index User Level -->
<script src="<?= base_url() ?>/dist/js/pages/index_user_level.js"></script>
<?= $this->endSection('scripts') ?>

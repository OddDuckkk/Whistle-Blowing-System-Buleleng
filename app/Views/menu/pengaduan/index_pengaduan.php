<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Data Pengaduan
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<div class="card-tools">
    <?php if (preg_match('/^pengaduan\/user\/[a-zA-Z0-9-]+$/', uri_string())): ?>
        <a href="<?= base_url('pengaduan/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pengaduan Baru
        </a>
    <?php endif ?>
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
                    <?php if ($p['status'] == 'baru') echo 'badge-secondary'; ?>
                    <?php if ($p['status'] == 'dikirim') echo 'badge-primary'; ?>
                    <?php if ($p['status'] == 'diproses operator') echo 'badge-warning'; ?>
                    <?php if ($p['status'] == 'diproses verifikator') echo 'badge-warning'; ?>
                    <?php if ($p['status'] == 'selesai') echo 'badge-success'; ?>
                    <?php if ($p['status'] == 'ditolak') echo 'badge-danger'; ?>
                    <?php if ($p['status'] == 'dikembalikan') echo 'badge-secondary'; ?>
                    ">

                    <?php if ($p['status'] == 'baru') echo 'draf'; ?>
                    <?php if ($p['status'] == 'dikirim') echo 'dikirim'; ?>
                    <?php if ($p['status'] == 'diproses operator') echo 'diproses operator'; ?>
                    <?php if ($p['status'] == 'diproses verifikator') echo 'diproses verifikator'; ?>
                    <?php if ($p['status'] == 'selesai') echo 'selesai'; ?>
                    <?php if ($p['status'] == 'ditolak') echo 'ditolak'; ?>
                    <?php if ($p['status'] == 'dikembalikan') echo 'dikembalikan'; ?>
                    </span>
                </td>
                <td>
                    <?php if (uri_string() == 'pengaduan/operator' && in_array('operator', session()->get('level')) && ($p['status'] == 'dikirim')): ?>
                    <form action="<?= base_url('pengaduan/change-status') ?>" method="post" id="operator-pengaduan-status-form">
                        <input type="hidden" name="pengaduan_id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="status" value="diproses operator"> 
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                    </form>
                    <?php else: ?>
                    <button onclick="handleDetails('<?= $p['id'] ?>')" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Lihat
                    </button>
                    <?php endif; ?>

                    <!-- Add or Remove Bookmark Button -->
                    <?php if (preg_match('/^pengaduan\/user\/[a-zA-Z0-9-]+$/', uri_string()) 
                    || preg_match('/^pengaduan\/user\/riwayat\/[a-zA-Z0-9-]+$/', uri_string())
                    || preg_match('/^bookmark\/user\/[a-zA-Z0-9-]+$/', uri_string())): ?>
                        <?php if (in_array($p['id'], $bookmarkedIds)): ?>
                            <!-- Remove Bookmark Button -->
                            <form action="<?= base_url('bookmark/remove') ?>" method="post" class="d-inline">
                                <input type="hidden" name="pengaduan_id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-bookmark fa-lg"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Add Bookmark Button -->
                            <form action="<?= base_url('bookmark/add') ?>" method="post" class="d-inline">
                                <input type="hidden" name="pengaduan_id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="far fa-bookmark fa-lg"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Index Pengaduan -->
<script src="<?= base_url() ?>/dist/js/pages/index_pengaduan.js"></script>
<?= $this->endSection('scripts') ?>

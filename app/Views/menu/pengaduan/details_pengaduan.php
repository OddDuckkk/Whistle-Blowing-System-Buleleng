<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
<p><strong><?= $pengaduan['judul']; ?></strong> | <small class="text-muted"><?= $pengaduan['nomor_pengaduan']; ?></small></p>
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<a href="<?= base_url('pengaduan'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div>
    <h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5>
</div>
<table id="pengaduanDetailsTable" class="table table-sm table-borderless">
    <tbody>
        <tr>
            <td class="w-25"><strong>Status</strong></td>
            <td class="w-75"><strong>: </strong><span class="badge custom-badge
                    <?php if ($pengaduan['status'] == 'baru') echo 'badge-primary'; ?>
                    <?php if ($pengaduan['status'] == 'diproses operator') echo 'badge-warning'; ?>
                    <?php if ($pengaduan['status'] == 'diproses verifikator') echo 'badge-warning'; ?>
                    <?php if ($pengaduan['status'] == 'selesai') echo 'badge-success'; ?>
                    <?php if ($pengaduan['status'] == 'ditolak') echo 'badge-danger'; ?>">

                    <?php if ($pengaduan['status'] == 'baru') echo 'baru'; ?>
                    <?php if ($pengaduan['status'] == 'diproses operator') echo 'diproses operator'; ?>
                    <?php if ($pengaduan['status'] == 'diproses verifikator') echo 'diproses operator'; ?>
                    <?php if ($pengaduan['status'] == 'selesai') echo 'selesai'; ?>
                    <?php if ($pengaduan['status'] == 'ditolak') echo 'ditolak'; ?>
                    </span></td>
        </tr>
        <tr>
            <td><strong>Nomor Pengaduan</strong></td>
            <td><strong>: </strong><?= $pengaduan['nomor_pengaduan']; ?></td>
        </tr>
        <tr>
            <td><strong>Judul</strong></td>
            <td><strong>: </strong><?= $pengaduan['judul']; ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td><strong>: </strong><?php
                    $locale = 'id_ID';
                    $date = new DateTime($pengaduan['tanggal']);
                    $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    echo $formatter->format($date);
                ?>
            </td>
        </tr>
        <tr>
            <td><strong>Tempat</strong></td>
            <td><strong>: </strong><?= $pengaduan['tempat']; ?></td>
        </tr>
        <tr>
            <td><strong>Nominal</strong></td>
            <td><strong>: </strong><?= $pengaduan['nominal'] ? 'Rp ' . number_format($pengaduan['nominal'], 2, ',', '.') : '-'; ?></td>
        </tr>
        <tr>
            <td><strong>Deskripsi</strong></td>
            <td><strong>: </strong><?= $pengaduan['deskripsi']; ?></td>
        </tr>
    </tbody>
</table>
<hr>
<div>
    <h5 class="text-primary"><strong>PIHAK YANG DIDUGA TERLIBAT</strong></h5>
</div>
<?php if (!empty($pihak_terlibat)) : ?>

        <?php foreach ($pihak_terlibat as $pihak) : ?>
            
            <div class="card-body ps-0">
                <h6 class="card-title text-center text-primary"><?= $pihak['nama_terlapor']; ?></h6>
                <p class="card-text"><strong><i class="fas fa-briefcase"></i> Jabatan:</strong> <?= $pihak['jabatan_terlapor']; ?>
                <br><strong><i class="fas fa-building"></i> Unit Kerja:</strong> <?= $pihak['unit_kerja']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    
<?php else : ?>
    <p>Tidak ada pihak terlibat.</p>
<?php endif; ?>
<hr>
<div>
    <h5 class="text-primary"><strong>LAMPIRAN PENDUKUNG</strong></h5>
</div>
<?php if (!empty($lampiran)) : ?>
    <div class="card-body">
            <?php foreach ($lampiran as $lamp) : ?>
                <div class="col-md-4 mb-3"> <!-- Adjust number of columns as needed -->
                    <div class="d-flex flex-row">
                        <a href="<?= base_url($lamp['file_lampiran']); ?>" target="_blank" class="p-2">
                            <img src="<?= base_url($lamp['file_lampiran']); ?>" alt="<?= $lamp['deskripsi']; ?>" class="img-thumbnail" style="height: 150px; width: 150px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title"><?= $lamp['deskripsi']; ?></h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Tidak ada lampiran.</p>
<?php endif; ?>
</div>
<?= $this->endSection('isi') ?>
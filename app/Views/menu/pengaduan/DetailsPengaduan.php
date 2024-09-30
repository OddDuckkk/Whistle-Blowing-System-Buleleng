<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
<p><strong><?= $pengaduan['judul']; ?></strong>   |    <small class="text-muted"><?= $pengaduan['nomor_pengaduan']; ?></small></p>
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<a href="<?= base_url('pengaduan'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>     Kembali</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<div class="box-body">
    <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
    <table id="pengaduanDetailsTable" class="table table-sm table-borderless">
    <tbody>
        <tr>
            <td class="w-25"><strong>Status</strong></td>
            <td class="w-75"><strong>:   </strong><span class="badge 
            <?= $pengaduan['status'] == 'diproses operator' ? 'badge-warning' : ''; ?>
            <?= $pengaduan['status'] == 'diproses verifikator' ? 'badge-warning' : ''; ?>
            <?= $pengaduan['status'] == 'selesai' ? 'badge-success' : ''; ?>
            <?= $pengaduan['status'] == 'ditolak operator' ? 'badge-danger' : ''; ?>
            <?= $pengaduan['status'] == 'ditolak verifikator' ? 'badge-danger' : ''; ?>">
            <?= $pengaduan['status']; ?>
            </span></td>
        </tr>
        <tr>
            <td><strong>Nomor Pengaduan</strong></td>
            <td><strong>:   </strong><?= $pengaduan['nomor_pengaduan']; ?></td>
        </tr>
        <tr>
            <td><strong>Judul</strong></td>
            <td><strong>:   </strong><?= $pengaduan['judul']; ?></td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td><strong>:   </strong><?= $pengaduan['tanggal']; ?></td>
        </tr>
        <tr>
            <td><strong>Tempat</strong></td>
            <td><strong>:   </strong><?= $pengaduan['tempat']; ?></td>
        </tr>
        <tr>
            <td><strong>Nominal</strong></td>
            <td><strong>:   </strong><?= $pengaduan['nominal'] ? 'Rp ' . number_format($pengaduan['nominal'], 2, ',', '.') : '-'; ?></td>
        </tr>
        <tr>
            <td><strong>Deskripsi</strong></td>
            <td><strong>:   </strong><?= $pengaduan['deskripsi']; ?></td>
        </tr>
    </tbody>
    </table>
</div>


<div class="box-body">
    <hr>
    <div><h5 class="text-primary"><strong>PIHAK YANG DIDUGA TERLIBAT</strong></h5></div>
        <?php if (!empty($pihak_terlibat)) : ?>
            <ul>
                <?php foreach ($pihak_terlibat as $pihak) : ?>
                    <li><strong>Nama:</strong> <?= $pihak['nama_terlapor']; ?> | <strong>Jabatan:</strong> <?= $pihak['jabatan_terlapor']; ?> | <strong>Unit Kerja:</strong> <?= $pihak['unit_kerja']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Tidak ada pihak terlibat.</p>
        <?php endif; ?>
    <hr>
</div>

<div class="box-body">
<div><h5 class="text-primary"><strong>LAMPIRAN PENDUKUNG</strong></h5></div>
    <?php if (!empty($lampiran)) : ?>
        <ul>
            <?php foreach ($lampiran as $lamp) : ?>
                <li>
                    <a href="<?= base_url($lamp['file_lampiran']); ?>" target="_blank">Download</a>
                    (<?= $lamp['deskripsi']; ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Tidak ada lampiran.</p>
    <?php endif; ?>
</div>

</div>
<?= $this->endSection('isi') ?>
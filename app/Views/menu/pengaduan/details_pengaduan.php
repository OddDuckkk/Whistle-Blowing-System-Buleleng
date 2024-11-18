<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
<p><strong><?= $pengaduan['judul']; ?></strong> | <small class="text-muted"><?= $pengaduan['nomor_pengaduan']; ?></small></p>
<?= $this->endSection('judul') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="card">
    <!-- Card Header -->
    <div class="card-header">
        <h3 class="card-title">
        <button onclick="handleBack()" class="btn btn-primary">
            <i class="fa fa-arrow-left"></i> Kembali
        </button>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- Content -->
    <div class="card-body p-5">
        <div>
            <div>
                <h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5>
            </div>
            <div class="card card-outline">
                <div class="card-header">
                    <h6 class="card-title mb-0 text-uppercase"><strong><?= $pengaduan['judul']; ?></strong></h6>
                </div>
                <div class="card-body">
                    <table id="pengaduanDetailsTable" class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <td class="w-25"><strong>Status Pengaduan</strong></td>
                                <td class="w-75"><strong>: </strong><span class="badge custom-badge
                                        <?php if ($pengaduan['status'] == 'baru') echo 'badge-secondary'; ?>
                                        <?php if ($pengaduan['status'] == 'dikirim') echo 'badge-primary'; ?>
                                        <?php if ($pengaduan['status'] == 'diproses operator') echo 'badge-warning'; ?>
                                        <?php if ($pengaduan['status'] == 'diproses verifikator') echo 'badge-warning'; ?>
                                        <?php if ($pengaduan['status'] == 'selesai') echo 'badge-success'; ?>
                                        <?php if ($pengaduan['status'] == 'ditolak') echo 'badge-danger'; ?>
                                        <?php if ($pengaduan['status'] == 'dikembalikan') echo 'badge-secondary'; ?>
                                        ">
                    
                                        <?php if ($pengaduan['status'] == 'baru') echo 'draf'; ?>
                                        <?php if ($pengaduan['status'] == 'dikirim') echo 'dikirim'; ?>
                                        <?php if ($pengaduan['status'] == 'diproses operator') echo 'diproses operator'; ?>
                                        <?php if ($pengaduan['status'] == 'diproses verifikator') echo 'diproses verifikator'; ?>
                                        <?php if ($pengaduan['status'] == 'selesai') echo 'selesai'; ?>
                                        <?php if ($pengaduan['status'] == 'ditolak') echo 'ditolak'; ?>
                                        <?php if ($pengaduan['status'] == 'dikembalikan') echo 'dikembalikan'; ?>
                                        </span></td>
                            </tr>
                            <tr>
                                <td><strong>Nomor Pengaduan</strong></td>
                                <td><strong>: </strong><?= $pengaduan['nomor_pengaduan']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Pengaduan Masuk</strong></td>
                                <td><strong>: </strong><?php
                                        $locale = 'id_ID';
                                        $date = new DateTime($pengaduan['created_at']);
                                        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                        echo $formatter->format($date);
                                    ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Kejadian</strong></td>
                                <td><strong>: </strong><?php
                                        $locale = 'id_ID';
                                        $date = new DateTime($pengaduan['tanggal']);
                                        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                        echo $formatter->format($date);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Kejadian</strong></td>
                                <td><strong>: </strong><?= $pengaduan['tempat']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nominal Uang (jika ada)</strong></td>
                                <td><strong>: </strong><?= $pengaduan['nominal'] ? 'Rp ' . number_format($pengaduan['nominal'], 2, ',', '.') : '-'; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Deskripsi Pengaduan</strong></td>
                                <td><strong>: </strong><?= $pengaduan['deskripsi']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h5 class="text-primary"><strong>PIHAK YANG DIDUGA TERLIBAT</strong></h5>
            </div>
            <?php if (!empty($pihak_terlibat)) : ?>

                <div class="row pt-2">
                <?php foreach ($pihak_terlibat as $index => $pihak) : ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card card-outline w-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0 text-uppercase"><strong><?= $pihak['nama_terlapor']; ?></strong></h6>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong><i class="fas fa-briefcase"></i> Jabatan:</strong> <?= $pihak['jabatan_terlapor']; ?>
                                    <br><strong><i class="fas fa-building"></i> Unit Kerja:</strong> <?= $pihak['unit_kerja']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if (($index + 1) % 3 == 0) : ?>
                        </div><div class="row"> <!-- Close and reopen row after every 3 items -->
                    <?php endif; ?>
                <?php endforeach; ?>
                </div>

                
            <?php else : ?>
                <p>Tidak ada pihak terlibat.</p>
            <?php endif; ?>

            <div class="pb-2">
                <h5 class="text-primary"><strong>LAMPIRAN PENDUKUNG</strong></h5>
            </div>
            <?php if (!empty($lampiran)) : ?>
                <div class="row">
                    <?php foreach ($lampiran as $lamp) : ?>
                        <div class="col-12 mb-3c">
                            <div class="card card-outline w-100">
                                <!-- Card Header with file name -->
                                <div class="card-header">
                                    <strong>
                                        <h6 class="card-title mb-0"><strong>
                                        <?php 
                                        
                                        $fileName = basename($lamp['file_lampiran']);
                                        
                                        $cleanFileName = preg_replace('/^[a-z0-9]+-/', '', $fileName);

                                        echo $cleanFileName; 
                                        ?>
                                        </strong>
                                        </h6>
                                    </strong>
                                </div>

                                <!-- Card Body with Thumbnail and Description Side by Side -->
                                <div class="row no-gutters">
                                    <div class="col-md-3">
                                        <div class="card-body px-5 text-center">
                                            <a href="<?= strpos($lamp['file_lampiran'], '.pdf') !== false ? '#pdfModal' : base_url($lamp['file_lampiran']); ?>" 
                                            data-toggle="lightbox" 
                                            data-gallery="lampiran-gallery" 
                                            data-type="<?= (strpos($lamp['file_lampiran'], '.pdf') !== false) ? 'iframe' : 'image' ?>" 
                                            class="lampiran-link" 
                                            data-file="<?= base_url($lamp['file_lampiran']); ?>"
                                            data-description="<?= $lamp['deskripsi']; ?>"> 
                                                <?php if (strpos($lamp['file_lampiran'], '.pdf') !== false) : ?>
                                                    <img src="<?= base_url('dist/img/pdf-icon.svg'); ?>" 
                                                        alt="PDF Icon" 
                                                        class="lampiran-pdf pdf-icon img-thumbnail" style="width: 100%; max-width: 150px;">
                                                <?php else : ?>
                                                    <img src="<?= base_url($lamp['file_lampiran']); ?>" 
                                                        alt="<?= $lamp['deskripsi']; ?>" 
                                                        class="lampiran-image img-thumbnail" style="width: 100%; max-width: 150px;">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Description Section -->
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h6><strong>Deskripsi lampiran:</strong></h6>
                                            <h6 class="card-text"><?= $lamp['deskripsi']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>Tidak ada lampiran.</p>
            <?php endif; ?>
            <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <iframe id="pdfIframe" src="" width="100%" height="500px" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div>
                <h5 class="text-primary"><strong>AKSI</strong></h5>
            </div>
            <!-- Conditional Buttons untuk Pelapor -->
            <?php if ($pengaduan['user_id'] == session()->get('id_user')): ?>
                <form action="<?= base_url('pengaduan/change-status') ?>" method="post" id="pelapor-pengaduan-status-form">
                    <?php if ($pengaduan['status'] == 'baru' || $pengaduan['status'] == 'dikembalikan'): ?>
                    <div class="mt-3 row align-items-center">
                        <div class="col-auto">
                                <input type="hidden" name="pengaduan_id" value="<?= $pengaduan['id'] ?>">
                                <input type="hidden" name="status" value="dikirim">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-paper-plane"></i> Kirim
                                </button>
                        </div>
                        <div class="col-auto me-3"> 
                            <button type="button" class="btn btn-warning" onclick="handleEdit('<?= $pengaduan['id'] ?>')">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                        </div>
                        <?php if ($pengaduan['status'] == 'baru'): ?>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" onclick="handleDelete('<?= $pengaduan['id'] ?>')">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else : ?>
                        <p>Tidak ada aksi yang dapat dilakukan.</p>
                    <?php endif; ?>
                </form>
            <!-- Conditional Buttons untuk Operator -->
            <?php elseif (in_array('operator', session()->get('level')) && $pengaduan['user_id'] != session()->get('id_user')) : ?>
                <form action="<?= base_url('pengaduan/change-status') ?>" method="post" id="operator-pengaduan-status-form">
                    <?php if ($pengaduan['status'] == 'dikirim' || $pengaduan['status'] == 'diproses operator'): ?>
                    <div class="mt-3 row align-items-center">
                        <input type="hidden" name="pengaduan_id" value="<?= $pengaduan['id'] ?>">
                        <input type="hidden" name="status" id="status-field">
                        <div class="col-auto">
                            <!-- Teruskan Button -->
                            <button type="submit" class="btn btn-success" onclick="setStatus('diproses verifikator')">
                                <i class="fa fa-arrow-right"></i> Teruskan
                            </button>
                        </div>
                        <div class="col-auto">
                            <!-- Kembalikan Button -->
                            <button type="submit" class="btn btn-danger" onclick="setStatus('dikembalikan')">
                                <i class="fa fa-arrow-left"></i> Kembalikan
                            </button>
                        </div>
                        <div class="col-auto">
                        <!-- Tolak Button -->
                        <button type="submit" class="btn btn-danger" onclick="setStatus('ditolak')">
                            <i class="fa fa-times"></i> Tolak
                        </button>
                        </div>
                    </div>
                    <?php else : ?>
                        <p>Tidak ada aksi yang dapat dilakukan.</p>
                    <?php endif; ?>
                </form>
            <!-- Conditional Buttons untuk Verifikator -->
            <?php elseif (in_array('verifikator', session()->get('level')) && $pengaduan['user_id'] != session()->get('id_user')) : ?>
            <form action="<?= base_url('pengaduan/change-status') ?>" method="post" id="verifikator-pengaduan-status-form">
                <?php if ($pengaduan['status'] == 'diproses verifikator'): ?>
                <div class="mt-3 row align-items-center">
                    <input type="hidden" name="pengaduan_id" value="<?= $pengaduan['id'] ?>">
                    <input type="hidden" name="status" id="status-field">
                    <div class="col-auto">
                        <!-- Selesai Button -->
                        <button type="submit" class="btn btn-success" onclick="setStatus('selesai')">
                            <i class="fa fa-check"></i> Selesai
                        </button>
                    </div>
                </div>
                <?php else : ?>
                    <p>Tidak ada aksi yang dapat dilakukan.</p>
                <?php endif; ?>
            </form>
            <?php else : ?>
                <p>Tidak ada aksi yang dapat dilakukan.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Detail Pengaduan -->
<script src="<?= base_url() ?>/dist/js/pages/details_pengaduan.js"></script>
<?= $this->endSection('scripts') ?>
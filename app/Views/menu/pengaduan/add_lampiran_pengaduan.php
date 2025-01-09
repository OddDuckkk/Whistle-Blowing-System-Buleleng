<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Tambah Lampiran
<?= $this->endSection('judul') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="card">
    <!-- Card Header -->
    <div class="card-header">
        <h3 class="card-title">
            <button onclick="history.back()" class="btn btn-primary">
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
        <!-- Form Edit Pengaduan -->
        <form id="lampiran_form" action="<?= base_url('pengaduan/store-additional-lampiran/' . $pengaduan['id']); ?>" method="post" enctype="multipart/form-data" autocomplete="off">

            <!-- Inputs lampiran -->
            <div class="box-body">
                <div>
                    <h5 class="text-primary"><strong>LAMPIRAN PENGADUAN</strong></h5>
                </div>
                <!-- Dropzone File -->
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>File Lampiran <label class="text-danger">*</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <!-- Dropzone Element -->
                                <div class="dropzone-container">
                                    <div id="dropzone-lampiran" class="dropzone mb-3">
                                        <div class="dz-message text-center">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-2 text-primary"></i> <!-- Customize icon color and size here -->
                                            <p class="font-weight-bold mb-1">Klik Box atau Tarik File untuk Mengupload</p>
                                            <p class="text-muted font-weight-bold" style="font-size: 0.9rem;">PNG, JPG, JPEG, PDF maksimal 10Mb</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="fileInputs">
                                    <?php if (old('file_lampiran')) : ?>
                                        <?php foreach (old('file_lampiran') as $index => $filePath) : ?>
                                            <input type="hidden" name="old_file_lampiran[]" value="<?= old('file_lampiran.' . $index) ?>">
                                        <?php endforeach; ?>
                                    <?php elseif (!empty($lampiran)): ?>
                                        <?php foreach ($lampiran as $index => $lamp): ?>
                                            <input type="hidden" name="old_file_lampiran[]" value="<?= old('file_lampiran.' . $index, $lamp['file_lampiran']) ?>">
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php if (old('deskripsi_lampiran')) : ?>
                    <?php foreach (old('deskripsi_lampiran') as $index => $deskripsiLampiran) : ?>
                        <input type="hidden" name="old_deskripsi_lampiran[<?= $index ?>]" value="<?= htmlspecialchars($deskripsiLampiran, ENT_QUOTES, 'UTF-8') ?>">
                        <?php if (isset(session()->getFlashdata('errDeskripsiLampiran')[$index])) : ?>
                            <input type="hidden" name="old_error_deskripsi[<?= $index ?>]" value="true">
                        <?php else : ?>
                            <input type="hidden" name="old_error_deskripsi[<?= $index ?>]" value="false">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php elseif (!empty($lampiran)) : ?>
                    <?php foreach ($lampiran as $index => $lamp) : ?>
                        <input type="hidden" name="old_deskripsi_lampiran[<?= $index ?>]" value="<?= htmlspecialchars(old('deskripsi_lampiran.' . $index, $lamp['deskripsi']), ENT_QUOTES, 'UTF-8') ?>">
                        <?php if (isset(session()->getFlashdata('errDeskripsiLampiran')[$index])) : ?>
                            <input type="hidden" name="old_error_deskripsi[<?= $index ?>]" value="true">
                        <?php else : ?>
                            <input type="hidden" name="old_error_deskripsi[<?= $index ?>]" value="false">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- Input Deskripsi Lampiran -->
                <table class="table table-borderless" id="lampiranDetailsTable" style="display: none;">
                    <thead>
                        <tr>
                            <th>Nama Lampiran</th>
                            <th>Deskripsi Lampiran <label class="text-danger">*</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row deskripsi secara dinamis (create_pengaduan.js) -->
                    </tbody>
                </table>
            </div>

            <!-- Button Submit & Batal -->
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('pengaduan'); ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Create Pengaduan -->
<script src="<?= base_url() ?>/dist/js/pages/add_lampiran_pengaduan.js"></script>
<?= $this->endSection('scripts') ?>
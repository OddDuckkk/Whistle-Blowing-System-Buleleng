<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Buat Pengaduan
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<?php $userId = session()->get('id_user') ?>
<a href="<?= base_url("pengaduan/user/$userId"); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>     Kembali</a>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<!-- Form Tambah Pengaduan -->
<form id="pengaduan_form" action="<?= base_url('pengaduan/store'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <!-- Inputs Detail Laporan -->
    <div class="box-body">
        <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
        <div class="row">
            <!-- Input Judul -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="judul">Judul Pengaduan <label class="text-danger">*</label></label>
                    <input type="text"
                        class="form-control <?= session()->getFlashdata('errJudul') ? 'is-invalid' : '' ?>" 
                        id="judul" 
                        name="judul" 
                        placeholder="Masukkan judul pengaduan" 
                        value="<?= old('judul') ?>">
                        <!-- Error Handling -->
                    <?php if (session()->getFlashdata('errJudul')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errJudul'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Input Tanggal -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal">Tanggal Kejadian <label class="text-danger">*</label></label>
                    <div class="input-group date" id="tanggalkejadian" data-target-input="nearest">
                        <div class="input-group-prepend" data-target="#tanggalkejadian" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        <input type="text" 
                        class="form-control datetimepicker-input <?= session()->getFlashdata('errTanggal') ? 'is-invalid' : '' ?>" 
                        id="tanggal" 
                        name="tanggal" 
                        value="<?= old('tanggal') ?>" 
                        data-target="#tanggalkejadian"
                        inputmode="numeric"
                        placeholder="YYYY-MM-DD">
                        <!-- Error Handling -->
                        <?php if (session()->getFlashdata('errTanggal')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errTanggal'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Input Tempat -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tempat">Tempat Kejadian <label class="text-danger">*</label></label>
                    <input type="text" 
                    class="form-control <?= session()->getFlashdata('errTempat') ? 'is-invalid' : '' ?>" 
                    id="tempat" 
                    name="tempat" 
                    placeholder="Masukkan tempat kejadian" 
                    value="<?= old('tempat') ?>">
                    <!-- Error Handling -->
                    <?php if (session()->getFlashdata('errTempat')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errTempat'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Input Nominal Uang -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nominal">Nominal Uang <label>(jika ada)</label></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span> 
                        </div>
                        <input type="number" 
                        class="form-control <?= session()->getFlashdata('errNominal') ? 'is-invalid' : '' ?>" 
                        id="nominal" 
                        name="nominal" 
                        placeholder="Masukkan nominal uang" 
                        value="<?= old('nominal') ?>">
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span> 
                        </div>
                        <!-- Error Handling -->
                        <?php if (session()->getFlashdata('errNominal')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errNominal'); ?>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Input Deskripsi -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Pengaduan <label class="text-danger">*</label> (jelaskan pengaduan secara terperinci)</label>
                    <textarea class="form-control <?= session()->getFlashdata('errDeskripsi') ? 'is-invalid' : '' ?>" 
                    id="deskripsi" 
                    name="deskripsi" 
                    rows="4" 
                    placeholder="Masukkan deskripsi pengaduan"><?= old('deskripsi') ?></textarea>
                    <!-- Error Handling -->
                    <?php if (session()->getFlashdata('errDeskripsi')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errDeskripsi'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Inputs Pihak Terlibat -->
    <div class="box-body">
        <div><h5 class="text-primary"><strong>PIHAK TERLIBAT</strong></h5></div>
        <!-- Tabel Input Pihak Terlibat -->
        <table class="table table-borderless" id="pihakTerlibatTable">
            <!-- Judul Field -->
            <thead>
                <tr>
                    <th>NIP Terlapor <label class="text-danger">*</label></th>
                    <th>Nama Terlapor <label class="text-danger">*</label></th>
                    <th>Jabatan Terlapor <label class="text-danger">*</label></th>
                    <th>Unit Kerja <label class="text-danger">*</label></th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <!-- Input Field -->
            <tbody>
                <!-- Tampilan input pihak terlibat jika terdapat error -->
                <?php if (old('nip_terlapor')): ?>
                    <?php foreach (old('nip_terlapor') as $index => $nipTerlapor): ?>
                    <tr>
                        <!-- Input nip -->
                        <td>
                            <div class="input-group">
                                <input type="text" 
                                name="nip_terlapor[]" 
                                class="form-control <?= isset(session()->getFlashdata('errNipTerlapor')[$index]) ? 'is-invalid' : '' ?>" 
                                placeholder="NIP Terlapor" 
                                value="<?= old('nip_terlapor.' . $index) ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary search-nip">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Error Handling -->
                            <?php if (isset(session()->getFlashdata('errNipTerlapor')[$index])): ?>
                                <div class="invalid-feedback" style="display: block;">
                                    <?= session()->getFlashdata('errNipTerlapor')[$index]; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <!-- Input Nama -->
                        <td>
                            <input type="text" 
                            name="nama_terlapor[]" 
                            class="form-control <?= isset(session()->getFlashdata('errNamaTerlapor')[$index]) ? 'is-invalid' : '' ?>" 
                            placeholder="Nama Terlapor" 
                            value="<?= old('nama_terlapor.' . $index) ?>" 
                            readonly>
                            <!-- Error Handling -->
                            <?php if (isset(session()->getFlashdata('errNamaTerlapor')[$index])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errNamaTerlapor')[$index]; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <!-- Input Jabatan -->
                        <td>
                            <input type="text" 
                            name="jabatan_terlapor[]" 
                            class="form-control <?= isset(session()->getFlashdata('errJabatanTerlapor')[$index]) ? 'is-invalid' : '' ?>" 
                            placeholder="Jabatan Terlapor" 
                            value="<?= old('jabatan_terlapor.' . $index) ?>" 
                            readonly>
                            <!-- Error Handling -->
                            <?php if (isset(session()->getFlashdata('errJabatanTerlapor')[$index])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errJabatanTerlapor')[$index]; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <!-- Input Unit Kerja -->
                        <td>
                            <input type="text" 
                            name="unit_kerja[]" 
                            class="form-control <?= isset(session()->getFlashdata('errUnitKerja')[$index]) ? 'is-invalid' : '' ?>" 
                            placeholder="Unit Kerja Terlapor" 
                            value="<?= old('unit_kerja.' . $index) ?>" 
                            readonly>
                            <!-- Error Handling -->
                            <?php if (isset(session()->getFlashdata('errUnitKerja')[$index])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errUnitKerja')[$index]; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($index == 0): ?>
                                <button type="button" class="btn btn-success add-row">+</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-danger remove-row">-</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- Tampilan Input terlapor dalam keadaan normal -->
                <?php else: ?>
                    <tr>
                        <td>
                            <div class="input-group">
                                <input type="text" 
                                name="nip_terlapor[]" 
                                class="form-control" 
                                placeholder="NIP Terlapor">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary search-nip">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" 
                            name="nama_terlapor[]" 
                            class="form-control" 
                            placeholder="Nama Terlapor" 
                            readonly>
                        </td>
                        <td>
                            <input type="text" 
                            name="jabatan_terlapor[]" 
                            class="form-control" 
                            placeholder="Jabatan Terlapor" 
                            readonly>
                        </td>
                        <td>
                            <input type="text" 
                            name="unit_kerja[]" 
                            class="form-control" 
                            placeholder="Unit Kerja Terlapor" 
                            readonly>
                        </td>
                        <td><button type="button" class="btn btn-success add-row">+</button></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Inputs lampiran -->
    <div class="box-body">
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
                            <!-- Hidden input path file ditambah secara dinamis (create_pengaduan.js) -->
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

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
<?= $this->endSection('isi') ?>


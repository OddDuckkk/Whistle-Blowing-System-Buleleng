<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Buat Pengaduan
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<?php $userId = session()->get('id_user') ?>
<a href="<?= base_url("pengaduan/user/$userId"); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>     Kembali</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<form action="<?= base_url('pengaduan/store'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">
        <div class="box-body">
            <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Input Judul -->
                    <div class="form-group">
                        <label for="judul">Judul Pengaduan <label class="text-danger">*</label></label>
                        <input type="text" class="form-control <?= session()->getFlashdata('errJudul') ? 'is-invalid' : '' ?>" id="judul" name="judul" placeholder="Masukkan judul pengaduan" value="<?= old('judul') ?>">
                        <?php if (session()->getFlashdata('errJudul')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errJudul'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Input Tanggal -->
                    <div class="form-group">
                        <label for="tanggal">Tanggal Kejadian <label class="text-danger">*</label></label>
                        <div class="input-group date">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="date" class="form-control <?= session()->getFlashdata('errTanggal') ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal') ?>">
                            <?php if (session()->getFlashdata('errTanggal')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errTanggal'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Input Tempat -->
                    <div class="form-group">
                        <label for="tempat">Tempat Kejadian <label class="text-danger">*</label></label>
                        <input type="text" class="form-control <?= session()->getFlashdata('errTempat') ? 'is-invalid' : '' ?>" id="tempat" name="tempat" placeholder="Masukkan tempat kejadian" value="<?= old('tempat') ?>">
                        <?php if (session()->getFlashdata('errTempat')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errTempat'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Input Nominal Uang -->
                    <div class="form-group">
                        <label for="nominal">Nominal Uang (jika ada)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span> 
                            </div>
                            <input type="number" class="form-control <?= session()->getFlashdata('errNominal') ? 'is-invalid' : '' ?>" id="nominal" name="nominal" placeholder="Masukkan nominal uang" value="<?= old('nominal') ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">,00</span> 
                            </div>
                            <?php if (session()->getFlashdata('errNominal')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errNominal'); ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- Input Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Pengaduan <label class="text-danger">*</label> (jelaskan pengaduan secara terperinci)</label>
                        <textarea class="form-control <?= session()->getFlashdata('errDeskripsi') ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pengaduan"><?= old('deskripsi') ?></textarea>
                        <?php if (session()->getFlashdata('errDeskripsi')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errDeskripsi'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div><h5 class="text-primary"><strong>PIHAK TERLIBAT</strong></h5></div>
            <!-- Pihak Terlibat -->
            <table class="table table-borderless" id="pihakTerlibatTable">
                <thead>
                    <tr>
                        <th>Nama Terlapor <label class="text-danger">*</label></th>
                        <th>Jabatan Terlapor <label class="text-danger">*</label></th>
                        <th>Unit Kerja <label class="text-danger">*</label></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="nama_terlapor[]" class="form-control <?= session()->getFlashdata('errNamaTerlapor') ? 'is-invalid' : '' ?>" placeholder="Nama Terlapor" value="<?= old('nama_terlapor[]') ?>">
                            <?php if (session()->getFlashdata('errNamaTerlapor')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errNamaTerlapor'); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="jabatan_terlapor[]" class="form-control <?= session()->getFlashdata('errJabatanTerlapor') ? 'is-invalid' : '' ?>" placeholder="Jabatan Terlapor">
                            <?php if (session()->getFlashdata('errJabatanTerlapor')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errJabatanTerlapor'); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="text" name="unit_kerja[]" class="form-control <?= session()->getFlashdata('errUnitKerja') ? 'is-invalid' : '' ?>" placeholder="Unit Kerja Terlapor">
                            <?php if (session()->getFlashdata('errUnitKerja')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errUnitKerja'); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><button type="button" class="btn btn-success add-row">+</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-body">
            <div><h5 class="text-primary"><strong>LAMPIRAN</strong></h5></div>
            <!-- Lampiran -->
            <table class="table table-borderless" id="lampiranTable">
                <thead>
                    <tr>
                        <th>File Lampiran <label class="text-danger">*</label></th>
                        <th>Deskripsi Lampiran <label class="text-danger">*</label></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="file" name="file_lampiran[]" class="form-control <?= session()->getFlashdata('errFileLampiran') ? 'is-invalid' : '' ?>">
                            <?php if (session()->getFlashdata('errFileLampiran')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errFileLampiran'); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <textarea name="deskripsi_lampiran[]" class="form-control <?= session()->getFlashdata('errDeskripsiLampiran') ? 'is-invalid' : '' ?>" rows="2" placeholder="Deskripsi Lampiran"></textarea>
                            <?php if (session()->getFlashdata('errDeskripsiLampiran')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errDeskripsiLampiran'); ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><button type="button" class="btn btn-success add-row">+</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('pengaduan'); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>

<!-- jQuery for adding/removing rows -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.querySelector('.input-group-text').addEventListener('click', function() {
        document.querySelector('#tanggal').focus();
    });
</script>
<script>
    // Add row for Pihak Terlibat
    $('#pihakTerlibatTable').on('click', '.add-row', function() {
        var newRow = `<tr>
                        <td><input type="text" name="nama_terlapor[]" class="form-control" placeholder="Nama Terlapor"</td>
                        <td><input type="text" name="jabatan_terlapor[]" class="form-control" placeholder="Jabatan Terlapor"></td>
                        <td><input type="text" name="unit_kerja[]" class="form-control" placeholder="Unit Kerja Terlapor"></td>
                        <td><button type="button" class="btn btn-danger remove-row">-</button></td>
                    </tr>`;
        $('#pihakTerlibatTable tbody').append(newRow);
    });

    // Remove row for Pihak Terlibat
    $('#pihakTerlibatTable').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });

    // Add row for Lampiran
    $('#lampiranTable').on('click', '.add-row', function() {
        var newRow = `<tr>
                        <td><input type="file" name="file_lampiran[]" class="form-control"></td>
                        <td><textarea name="deskripsi_lampiran[]" class="form-control" rows="2" placeholder="Deskripsi Lampiran"></textarea></td>
                        <td><button type="button" class="btn btn-danger remove-row">-</button></td>
                    </tr>`;
        $('#lampiranTable tbody').append(newRow);
    });

    // Remove row for Lampiran
    $('#lampiranTable').on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });
</script>

<?= $this->endSection('isi') ?>

<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Edit Aduan
<?= $this->endSection('judul') ?>

<!-- ======= Section Card Header ======= -->
<?= $this->section('card-header') ?>
<a href="<?= base_url('pengaduan'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>

<form action="<?= base_url('pengaduan/update/' . $pengaduan['id']); ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Input Judul -->
                    <div class="form-group">
                        <label for="judul">Judul Pengaduan <label class="text-danger">*</label></label>
                        <input type="text" class="form-control <?= session()->getFlashdata('errJudul') ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul', $pengaduan['judul']) ?>" placeholder="Masukkan judul pengaduan">
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
                            <input type="date" class="form-control <?= session()->getFlashdata('errTanggal') ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal', $pengaduan['tanggal']) ?>" min="1990-01-01" max="2100-01-01" >
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
                        <input type="text" class="form-control <?= session()->getFlashdata('errTempat') ? 'is-invalid' : '' ?>" id="tempat" name="tempat" value="<?= old('tempat', $pengaduan['tempat']) ?>" placeholder="Masukkan tempat kejadian" >
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
                            <input type="number" class="form-control <?= session()->getFlashdata('errNominal') ? 'is-invalid' : '' ?>" id="nominal" name="nominal" value="<?= old('nominal', $pengaduan['nominal']) ?>" placeholder="Masukkan nominal uang">
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
                        <textarea class="form-control <?= session()->getFlashdata('errDeskripsi') ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pengaduan" ><?= old('deskripsi', $pengaduan['deskripsi']) ?></textarea>
                        <?php if (session()->getFlashdata('errDeskripsi')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errDeskripsi'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input pihak terlibat -->
        <div class="box-body">
            <div><h5 class="text-primary"><strong>PIHAK TERLIBAT</strong></h5></div>
            <!-- Pihak Terlibat -->
            <table class="table table-borderless" id="pihakTerlibatTable">
                <thead>
                    <!-- Header tabel -->
                    <tr>
                        <th>Nama Terlapor <label class="text-danger">*</label></th>
                        <th>Jabatan Terlapor <label class="text-danger">*</label></th>
                        <th>Unit Kerja <label class="text-danger">*</label></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <!-- form input -->
                <tbody>
                    <?php if (!empty($terlibat)): ?>
                        <?php foreach ($terlibat as $index => $pihak): ?>
                        <tr>
                            <td>
                                <input type="text" name="nama_terlapor[]" class="form-control <?= session()->getFlashdata('errNamaTerlapor') ? 'is-invalid' : '' ?>" placeholder="Nama Terlapor" value="<?= old('nama_terlapor.' . $index, $pihak['nama_terlapor']) ?>">
                                <?php if (session()->getFlashdata('errNamaTerlapor')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errNamaTerlapor'); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="text" name="jabatan_terlapor[]" class="form-control <?= session()->getFlashdata('errJabatanTerlapor') ? 'is-invalid' : '' ?>" placeholder="Jabatan Terlapor" value="<?= old('jabatan_terlapor.' . $index, $pihak['jabatan_terlapor']) ?>">
                                <?php if (session()->getFlashdata('errJabatanTerlapor')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errJabatanTerlapor'); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="text" name="unit_kerja[]" class="form-control <?= session()->getFlashdata('errUnitKerja') ? 'is-invalid' : '' ?>" placeholder="Unit Kerja Terlapor" value="<?= old('unit_kerja.' . $index, $pihak['unit_kerja']) ?>">
                                <?php if (session()->getFlashdata('errUnitKerja')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errUnitKerja'); ?>
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
                    <?php else: ?>
                        <tr>
                            <td>
                                <input type="text" name="nama_terlapor[]" class="form-control <?= session()->getFlashdata('errNamaTerlapor') ? 'is-invalid' : '' ?>" placeholder="Nama Terlapor">
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Input lampiran -->
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
                    <?php if (!empty($lampiran)): ?>
                        <?php foreach ($lampiran as $index => $lamp): ?>
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
                                <textarea name="deskripsi_lampiran[]" class="form-control <?= session()->getFlashdata('errDeskripsiLampiran') ? 'is-invalid' : '' ?>" rows="2" placeholder="Deskripsi Lampiran"><?= old('deskripsi_lampiran.' . $index, $lamp['deskripsi']) ?></textarea>
                                <?php if (session()->getFlashdata('errDeskripsiLampiran')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errDeskripsiLampiran'); ?>
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
                    <?php else: ?>
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
                    <?php endif; ?>
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
            // Add row for Pihak Terlibat
            $('#pihakTerlibatTable').on('click', '.add-row', function() {
                var newRow = `<tr>
                                <td><input type="text" name="nama_terlapor[]" class="form-control" placeholder="Nama Terlapor"></td>
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

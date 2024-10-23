<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Buat Pengaduan
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<?php $userId = session()->get('id_user') ?>
<a href="<?= base_url("pengaduan/user/$userId"); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>     Kembali</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<!-- FORM TAMBAH PENGADUAN -->
<form action="<?= base_url('pengaduan/store'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="card-body">

        <!-- SECTION DETAIL LAPORAN -->
        <div class="box-body">
            <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
            <div class="row">
                <!-- INPUT JUDUL -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="judul">Judul Pengaduan <label class="text-danger">*</label></label>
                        <input type="text"
                         class="form-control <?= session()->getFlashdata('errJudul') ? 'is-invalid' : '' ?>" 
                         id="judul" 
                         name="judul" 
                         placeholder="Masukkan judul pengaduan" 
                         value="<?= old('judul') ?>">
                         <!-- ERROR MESSAGE -->
                        <?php if (session()->getFlashdata('errJudul')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errJudul'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- INPUT TANGGAL -->
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
                            placeholder="DD-MM-YYYY">
                            <!-- ERROR MESSAGE -->
                            <?php if (session()->getFlashdata('errTanggal')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errTanggal'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- INPUT TEMPAT -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tempat">Tempat Kejadian <label class="text-danger">*</label></label>
                        <input type="text" 
                        class="form-control <?= session()->getFlashdata('errTempat') ? 'is-invalid' : '' ?>" 
                        id="tempat" 
                        name="tempat" 
                        placeholder="Masukkan tempat kejadian" 
                        value="<?= old('tempat') ?>">
                        <!-- ERROR MESSAGE -->
                        <?php if (session()->getFlashdata('errTempat')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errTempat'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- INPUT NOMINAL UANG -->
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
                            <!-- ERROR MESSAGE -->
                            <?php if (session()->getFlashdata('errNominal')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errNominal'); ?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- INPUT DESKRIPSI -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Pengaduan <label class="text-danger">*</label> (jelaskan pengaduan secara terperinci)</label>
                        <textarea class="form-control <?= session()->getFlashdata('errDeskripsi') ? 'is-invalid' : '' ?>" 
                        id="deskripsi" 
                        name="deskripsi" 
                        rows="4" 
                        placeholder="Masukkan deskripsi pengaduan"><?= old('deskripsi') ?></textarea>
                        <!-- ERROR MESSAGE -->
                        <?php if (session()->getFlashdata('errDeskripsi')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errDeskripsi'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION DETAIL PIHAK TERLIBAT -->
        <div class="box-body">
            <div><h5 class="text-primary"><strong>PIHAK TERLIBAT</strong></h5></div>
            <table class="table table-borderless" id="pihakTerlibatTable">
                <!-- INPUT HEADER -->
                <thead>
                    <tr>
                        <th>NIP Terlapor <label class="text-danger">*</label></th>
                        <th>Nama Terlapor <label class="text-danger">*</label></th>
                        <th>Jabatan Terlapor <label class="text-danger">*</label></th>
                        <th>Unit Kerja <label class="text-danger">*</label></th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <!-- INPUT BODY -->
                <tbody>
                    <?php if (old('nip_terlapor')): ?>
                        <?php foreach (old('nip_terlapor') as $index => $nipTerlapor): ?>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input type="text" 
                                    name="nip_terlapor[]" 
                                    class="form-control <?= session()->getFlashdata('errNipTerlapor.' . $index) ? 'is-invalid' : '' ?>" 
                                    placeholder="NIP Terlapor" 
                                    value="<?= old('nip_terlapor.' . $index) ?>">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary search-nip"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                <?php if (session()->getFlashdata('errNipTerlapor.' . $index)): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errNipTerlapor.' . $index); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="text" 
                                name="nama_terlapor[]" 
                                class="form-control" 
                                placeholder="Nama Terlapor" 
                                value="<?= old('nama_terlapor.' . $index) ?>" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="jabatan_terlapor[]" 
                                class="form-control" 
                                placeholder="Jabatan Terlapor" 
                                value="<?= old('jabatan_terlapor.' . $index) ?>" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="unit_kerja[]" 
                                class="form-control" 
                                placeholder="Unit Kerja Terlapor" 
                                value="<?= old('unit_kerja.' . $index) ?>" 
                                disabled>
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
                                <div class="input-group">
                                    <input type="text" 
                                    name="nip_terlapor[]" 
                                    class="form-control <?= session()->getFlashdata('errNipTerlapor') ? 'is-invalid' : '' ?>" 
                                    placeholder="NIP Terlapor">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary search-nip"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" 
                                name="nama_terlapor[]" 
                                class="form-control <?= session()->getFlashdata('errNamaTerlapor') ? 'is-invalid' : '' ?>" 
                                placeholder="Nama Terlapor" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="jabatan_terlapor[]" 
                                class="form-control <?= session()->getFlashdata('errJabatanTerlapor') ? 'is-invalid' : '' ?>" 
                                placeholder="Jabatan Terlapor" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="unit_kerja[]" 
                                class="form-control <?= session()->getFlashdata('errUnitKerja') ? 'is-invalid' : '' ?>" 
                                placeholder="Unit Kerja Terlapor" 
                                disabled>
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
                    <?php if (old('deskripsi_lampiran')): ?>
                        <?php foreach (old('deskripsi_lampiran') as $index => $deskripsiLampiran): ?>
                        <tr>
                            <td>
                                <input type="file" name="file_lampiran[]" class="form-control <?= session()->getFlashdata('errFileLampiran.' . $index) ? 'is-invalid' : '' ?>">
                                <?php if (session()->getFlashdata('errFileLampiran.' . $index)): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errFileLampiran.' . $index); ?>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <textarea name="deskripsi_lampiran[]" class="form-control <?= session()->getFlashdata('errDeskripsiLampiran.' . $index) ? 'is-invalid' : '' ?>" rows="2" placeholder="Deskripsi Lampiran"><?= old('deskripsi_lampiran.' . $index) ?></textarea>
                                <?php if (session()->getFlashdata('errDeskripsiLampiran.' . $index)): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errDeskripsiLampiran.' . $index); ?>
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

        <!-- TOMBOL SUBMIT DAN BATAL -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('pengaduan'); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>
<?= $this->endSection('isi') ?>

<?= $this->section('scripts') ?>
<!-- SCRIPTS HALAMAN CREATE PENGADUAN -->
<!-- =========================================================================================== -->
<!-- SCRIPT DATE-TIME PICKER TANGGAL KEJADIAN -->
<script type="text/javascript">
    $(function () {
        $('#tanggalkejadian').datetimepicker({
            format: 'DD-MM-YYYY', 
            icons: {
                time: 'fa fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-calendar-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
    });
</script>
<!-- SCRIPT TAMBAH DAN HILANGKAN ROW -->
<script>
    // Add row for Pihak Terlibat
    $('#pihakTerlibatTable').on('click', '.add-row', function() {
        var newRow = `<tr>
                        <td>
                                <div class="input-group">
                                    <input type="text" 
                                    name="nip_terlapor[]" 
                                    class="form-control" 
                                    placeholder="NIP Terlapor">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary search-nip"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" 
                                name="nama_terlapor[]" 
                                class="form-control" 
                                placeholder="Nama Terlapor" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="jabatan_terlapor[]" 
                                class="form-control" 
                                placeholder="Jabatan Terlapor" 
                                disabled>
                            </td>
                            <td>
                                <input type="text" 
                                name="unit_kerja[]" 
                                class="form-control" 
                                placeholder="Unit Kerja Terlapor" 
                                disabled>
                            </td>
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
<!-- SCRIPT MEMUNCULKAN TOAST -->
<script>
    function showToast(title, message, type) {
        // SweetAlert2 Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            icon: type, // Set the icon based on type
            title: title,
            text: message
        });

        // Display the toast
        Toast.fire();
    }
</script>

<!-- SCRIPT EVENT LISTENER BUTTON SEARCH NIP -->
<script>
    $(document).on('click', '.search-nip', function() {
        let row = $(this).closest('tr');
    
        // Retrieve NIP from the input field in the current row
        let nip = row.find('input[name="nip_terlapor[]"]').val();
    
        // teruskan ke controller
        $.ajax({
            url: '<?= base_url() ?>/auth/search-nip', 
            method: 'POST',
            data: { nip: nip },
            success: function(res) {
                if (!res.is_error) {
                    // Fill the fields in the same row with the response data
                    row.find('input[name="nama_terlapor[]"]').val(res.nama_terlapor);
                    row.find('input[name="jabatan_terlapor[]"]').val(res.jabatan_terlapor);
                    row.find('input[name="unit_kerja[]"]').val(res.unit_kerja);
                } else {
                    // Show error toast if there's an error in the response
                    // alert('Failed to connect to the server.');
                    showToast('Error', 'Data Pegawai tidak ditemukan', 'error');
                }
                },
                error: function() {
                    // Show error toast if server connection fails
                    showToast('Error', 'Failed to connect to the server.', 'error');
                }
        });
    });
</script>
<!-- =========================================================================================== -->
<?= $this->endSection('scripts') ?>


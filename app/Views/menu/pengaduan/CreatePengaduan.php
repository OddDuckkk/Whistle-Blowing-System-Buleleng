<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Buat Pengaduan
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<a href="<?= base_url('pengaduan/user/1'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i>     Kembali</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<form action="<?= base_url('pengaduan/store'); ?>" method="post" enctype="multipart/form-data">
    <div class="card-body">
        <div class="box-body">
            <div><h5 class="text-primary"><strong>DETAIL LAPORAN</strong></h5></div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Input Judul -->
                    <div class="form-group">
                        <label for="judul">Judul Pengaduan <label class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul pengaduan" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Input Tanggal -->
                    <div class="form-group">
                    <label for="tanggal">Tanggal Kejadian <label class="text-danger">*</label></label>
                        <div class="input-group date">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" min="1990-01-01" max="2100-01-01" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Input Tempat -->
                    <div class="form-group">
                        <label for="tempat">Tempat Kejadian <label class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Masukkan tempat kejadian" required>
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
                            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="Masukkan nominal uang" min="0" step="100000">
                            <div class="input-group-append">
                                <span class="input-group-text">,00</span> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <!-- Input Deskripsi -->
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Pengaduan <label class="text-danger">*</label> (jelaskan pengaduan secara terperinci)</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pengaduan" required></textarea>
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
                        <td><input type="text" name="nama_terlapor[]" class="form-control" placeholder="Nama Terlapor" required></td>
                        <td><input type="text" name="jabatan_terlapor[]" class="form-control" placeholder="Jabatan Terlapor" required></td>
                        <td><input type="text" name="unit_kerja[]" class="form-control" placeholder="Unit Kerja Terlapor" required></td>
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
                        <td><input type="file" name="file_lampiran[]" class="form-control"></td>
                        <td><textarea name="deskripsi_lampiran[]" class="form-control" rows="2" placeholder="Deskripsi Lampiran"></textarea></td>
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
    // Add row for Pihak Terlibat
    $('#pihakTerlibatTable').on('click', '.add-row', function() {
        var newRow = `<tr>
                        <td><input type="text" name="nama_terlapor[]" class="form-control" placeholder="Nama Terlapor" required></td>
                        <td><input type="text" name="jabatan_terlapor[]" class="form-control" placeholder="Jabatan Terlapor" required></td>
                        <td><input type="text" name="unit_kerja[]" class="form-control" placeholder="Unit Kerja Terlapor" required></td>
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

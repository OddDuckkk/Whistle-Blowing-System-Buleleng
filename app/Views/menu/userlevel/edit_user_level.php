<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Edit Level Pengguna
<?= $this->endSection('judul') ?>

<!-- ======= Section Sub judul ======= -->
<?= $this->section('card-header') ?>
<button onclick="history.back()" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i> Kembali
</button>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<form id="edit-user-level-form" action="<?= base_url('/user-level/update/' . $userLevel['nip']); ?>" method="post" enctype="multipart/form-UserLevel" autocomplete="off">
    <!-- Inputs User -->
    <div class="box-body">
        <div><h5 class="text-primary"><strong>UserLevel PEGAWAI</strong></h5></div>

        <!-- Tabel Input Pihak Terlibat -->
        <table class="table table-borderless" id="pihakTerlibatTable">
            <!-- Judul Field -->
            <thead>
                <tr>
                    <th>NIP Pegawai <label class="text-danger">*</label></th>
                    <th>Nama Pegawai <label class="text-danger">*</label></th>
                    <th>Jabatan <label class="text-danger">*</label></th>
                    <th>Unit Kerja <label class="text-danger">*</label></th>
                </tr>
            </thead>

            <!-- Input Field -->
            <tbody>
                <tr>
                    <td>
                        <div class="input-group">
                            <input type="text" 
                            name="nip_pegawai" 
                            class="form-control <?= session()->getFlashData('errNipPegawai') ? 'is-invalid' : '' ?>" 
                            value="<?= $userLevel['nip'] ?>" 
                            placeholder="NIP Pegawai" 
                            readonly>
                        </div>
                    </td>
                    <td>
                        <input type="text" 
                        name="nama_pegawai" 
                        class="form-control <?= session()->getFlashData('errNamaPegawai') ? 'is-invalid' : '' ?>" 
                        value="<?= $userLevel['nama_pegawai'] ?>" 
                        placeholder="Nama Pegawai" 
                        readonly>
                    </td>
                    <td>
                        <input type="text" 
                        name="jabatan_pegawai" 
                        class="form-control <?= session()->getFlashData('errJabatanPegawai') ? 'is-invalid' : '' ?>" 
                        value="<?= $userLevel['jabatan_pegawai'] ?>" 
                        placeholder="Jabatan Pegawai" 
                        readonly>
                    </td>
                    <td>
                        <input type="text" 
                        name="unit_kerja" 
                        class="form-control <?= session()->getFlashData('errUnitKerja') ? 'is-invalid' : '' ?>" 
                        value="<?= $userLevel['unit_kerja'] ?>" 
                        placeholder="Unit Kerja Pegawai" 
                        readonly>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Inputs Level -->
    <div class="box-body">
        <div><h5 class="text-primary"><strong>LEVEL</strong></h5></div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="judul">Level User <label class="text-danger">*</label></label>
                    <select name="level_pegawai" class="form-control select2 <?= session()->getFlashData('errLevelPegawai') ? 'is-invalid' : '' ?>">
                        <option value="" disabled><i class="text-muted">Pilih Level</i></option>
                        <option value="operator" <?= $userLevel['level'] == 'operator' ? 'selected' : '' ?>>Operator</option>
                        <option value="verifikator" <?= $userLevel['level'] == 'verifikator' ? 'selected' : '' ?>>Verifikator</option>
                        <option value="peninjau" <?= $userLevel['level'] == 'peninjau' ? 'selected' : '' ?>>Peninjau</option>
                        <option value="superadmin" <?= $userLevel['level'] == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                </div>
                <?php if (session()->getFlashData('errLevelPegawai')): ?>
                    <div class="invalid-feedback" style="display: block;">
                        <?= session()->getFlashData('errLevelPegawai'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="box-body pt-3">
        <!-- Button Submit & Batal -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('user-level'); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>

<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<!-- Script Halaman Edit User Level -->
<script src="<?= base_url() ?>/dist/js/pages/edit_user_level.js"></script>
<?= $this->endSection('scripts') ?>

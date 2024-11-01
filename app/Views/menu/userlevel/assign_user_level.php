<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
Tambah Level ke Pengguna
<?= $this->endSection('judul') ?>

<!-- ======= Section Sub judul ======= -->
<?= $this->section('card-header') ?>
<a href="<?= base_url('/user-level'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
<?= $this->endSection('card-header') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<form id="assign-user-level-form" action="<?= base_url('/user-level/store'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <!-- Inputs User -->
    <div class="box-body">
        <div><h5 class="text-primary"><strong>DATA PEGAWAI</strong></h5></div>

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
                            class="form-control <?= session()->getFlashdata('errNipPegawai') ? 'is-invalid' : '' ?>" 
                            placeholder="NIP Pegawai">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary search-user">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <?php if (session()->getFlashdata('errNipPegawai')): ?>
                            <div class="invalid-feedback" style="display: block;">
                                <?= session()->getFlashdata('errNipPegawai'); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                    <input type="text" 
                    name="nama_pegawai" 
                    class="form-control <?= session()->getFlashdata('errNamaPegawai') ? 'is-invalid' : '' ?>" 
                    placeholder="Nama Pegawai" 
                    readonly>
                    <?php if (session()->getFlashdata('errNamaPegawai')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errNamaPegawai'); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                    <input type="text" 
                    name="jabatan_pegawai" 
                    class="form-control <?= session()->getFlashdata('errJabatanPegawai') ? 'is-invalid' : '' ?>" 
                    placeholder="Jabatan Pegawai" 
                    readonly>
                    <?php if (session()->getFlashdata('errJabatanPegawai')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errJabatanPegawai'); ?>
                        </div>
                    <?php endif; ?>
                    </td>
                    <td>
                    <input type="text" 
                    name="unit_kerja" 
                    class="form-control <?= session()->getFlashdata('errUnitKerja') ? 'is-invalid' : '' ?>" 
                    placeholder="Unit Kerja Pegawai" 
                    readonly>
                    <?php if (session()->getFlashdata('errUnitKerja')): ?>
                        <div class="invalid-feedback">
                            <?= session()->getFlashdata('errUnitKerja'); ?>
                        </div>
                    <?php endif; ?>
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
                    <label for="judul">Level yang Ingin Diberikan <label class="text-danger">*</label></label>
                    <select name="level_pegawai" class="form-control select2 <?= session()->getFlashdata('errLevelPegawai') ? 'is-invalid' : '' ?>">
                                <option value="" disabled selected><i class="text-muted">Pilih Level</i></option>
                                <option value="operator">Operator</option>
                                <option value="verifikator">Verifikator</option>
                                <option value="peninjau">Peninjau</option>
                                <option value="superadmin">Superadmin</option>
                    </select>
                </div>
                <?php if (session()->getFlashdata('errLevelPegawai')): ?>
                    <div class="invalid-feedback" style="display: block;">
                        <?= session()->getFlashdata('errLevelPegawai'); ?>
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

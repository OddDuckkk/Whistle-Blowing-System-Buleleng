<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Tambah Level ke Pengguna
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<a href="<?= base_url('/userlevel'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<form action="<?= base_url('/validate-nip'); ?>" method="post" enctype="multipart/form-data">
    <div class="card-body rounded">
        <div class="box-body">
            <div><h5 class="text-primary"><strong>ASSIGN LEVEL</strong></h5></div>
            <div class="row">
                <div class="col-md-6">
                    <!-- Input NIP -->
                    <div class="form-group">
                        <label for="nip">NIP <label class="text-danger">*</label></label>
                        <input type="text" id="nip" name="nip" class="form-control <?= session()->getFlashdata('errNip') ? 'is-invalid' : '' ?>" placeholder="NIP" value="<?= old('nip'); ?>" autofocus>
                        <?php if (session()->getFlashdata('errNip')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errNip'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Dropdown Level -->
                    <div class="form-group">
                        <label for="level">Level <label class="text-danger">*</label></label>
                        <select class="form-control <?= session()->getFlashdata('errLevel') ? 'is-invalid' : '' ?>" placeholder="NIP" value="<?= old('nip'); ?>" id="level" name="level">
                            <option value="" disabled selected>Pilih Level</option>
                            <option value="operator">Operator</option>
                            <option value="verifikator">Verifikator</option>
                            <option value="superadmin">Superadmin</option>
                        </select>
                        <?php if (session()->getFlashdata('errLevel')): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errLevel'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal Konfirmasi -->
<?php if (session()->get('show_modal')): ?>
    <div class="modal fade show" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Tambah Level</h5>
                    <button type="button" class="close" aria-label="Close" id="closeModal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menambahkan level <strong><?= session()->getFlashdata('levelConfirm') ?></strong> kepada pengguna dengan NIP "<strong><?= session()->getFlashdata('nipConfirm') ?></strong>"?
                </div>
                <div class="modal-footer justify-content-between">
                    <!-- Dismiss button (Tutup) -->
                    <button type="button" class="btn btn-default" id="dismissModal">Tutup</button>
                    <!-- Action (Simpan) -->
                    <form action="<?= base_url('/userlevel/store'); ?>" method="post">
                        <input type="hidden" name="nip" id="hiddenNip">
                        <input type="hidden" name="level" id="hiddenLevel">

                        <button type="submit" class="btn btn-primary" onclick="submitForm()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
        // Copy values from the visible form to the hidden form before submission
        document.getElementById('hiddenNip').value = document.getElementById('nip').value;
        document.getElementById('hiddenLevel').value = document.getElementById('level').value;

        // Submit the hidden form
        document.getElementById('saveForm').submit();
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi modal 
            var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                keyboard: false
            });

            // tampilkan modal
            myModal.show();

            // Dismiss modal "tombol tutup"
            document.getElementById('dismissModal').addEventListener('click', function() {
                myModal.hide();
                // reset modal
                window.location.href = "<?= base_url('/userlevel/assign') ?>"; 
            });

            // Dismiss modal manually "tombol tutup"
            document.getElementById('closeModal').addEventListener('click', function() {
                myModal.hide();
                // Reset modal
                window.location.href = "<?= base_url('/userlevel/assign') ?>"; 
            });
        });
    </script>
<?php endif; ?>

<?= $this->endSection('isi') ?>

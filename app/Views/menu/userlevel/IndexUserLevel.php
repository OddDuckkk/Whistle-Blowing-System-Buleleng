<?= $this->extend('main/layout') ?>
<?= $this->section('judul') ?>
Daftar Level Pengguna
<?= $this->endSection('judul') ?>
<?= $this->section('subjudul') ?>
<a href="<?= base_url('/userlevel/assign'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Level</a>
<?= $this->endSection('subjudul') ?>
<?= $this->section('isi') ?>

<div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['nip']); ?></td>
                        <td><?= esc($user['levels']); ?></td> 
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection('isi') ?>

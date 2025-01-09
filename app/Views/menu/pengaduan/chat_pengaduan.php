<!-- ======= Layout Init ======= -->
<?= $this->extend('layout/layout') ?>

<!-- ======= Section Judul ======= -->
<?= $this->section('judul') ?>
<!-- <button onclick="history.back()" class="btn btn-primary">
    <i class="fa fa-arrow-left"></i> Kembali
</button> -->
<?= $this->endSection('judul') ?>

<!-- ======= Section Isi ======= -->
<?= $this->section('isi') ?>
<div class="container col-lg-12 d-flex justify-content-center">
    <div class="card col-lg-8">
        <!-- Card Header -->
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button onclick="history.back()" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i>
                </button>
            </div>
            <div class="text-center flex-grow-1">
                <h5 class="m-0 p-0">
                    <strong><?= $pengaduan['judul']; ?></strong> |
                    <small class="text-muted"><?= $pengaduan['nomor_pengaduan']; ?></small>
                </h5>
            </div>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="card-body" style="height: 60vh; overflow-y: auto; display: flex; flex-direction: column;">
            <!-- Chat Messages -->
            <div class="direct-chat-messages" id="chat-messages" style="flex-grow: 1; overflow-y: auto;">
                <p class="text-muted text-center">Ini adalah permulaan dari obrolan anda.</p>
                <?php foreach ($posts as $post): ?>
                    <div class="direct-chat-msg pb-1 <?= $post['user_id'] === session()->get('id_user') ? 'right' : '' ?>">
                        <div class="direct-chat-infos clearfix d-flex align-items-end <?= $post['user_id'] === session()->get('id_user') ? 'flex-row-reverse' : '' ?>">
                            <span class="direct-chat-name <?= $post['user_id'] === session()->get('id_user') ? 'float-right ml-2' : 'float-left mr-2' ?>">
                                <?= $post['user_id'] === session()->get('id_user') ? 'Anda' : ($post['user_id'] === $pengaduan['user_id'] ? 'Pelapor' : 'Verifikator') ?>
                            </span>
                            <!-- Parent Message (Separate Bubble) -->
                            <?php if (!empty($post['parent_message'])): ?>
                                <div class="parent-message-bubble font-weight-normal <?= $post['user_id'] === session()->get('id_user') ? 'right' : '' ?>">
                                    <a href="javascript:void(0);" data-id="<?= $post['parent_id'] ?>"><?= esc($post['parent_message']) ?></a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Direct Chat Reply Message -->
                        <div class="d-flex align-items-start mb-3 <?= $post['user_id'] === session()->get('id_user') ? 'flex-row-reverse' : '' ?>">
                            <img class="direct-chat-img elevation-2 <?= $post['user_id'] === session()->get('id_user') ? 'ml-2' : 'mr-2' ?>"
                                src="<?= base_url('/dist/img/anonymous.png') ?>" alt="User Image">

                            <!-- Direct Chat Text -->
                            <div class="direct-chat-text <?= $post['user_id'] === session()->get('id_user') ? '' : '' ?>"
                                id="<?= $post['id'] ?>"
                                style="display: inline-block; max-width: 60%; text-align: left; position: relative; margin:0">
                                <?= $post['is_deleted'] ? '<i>Pesan ini telah dihapus</i>' : esc($post['message']) ?>

                                <!-- Timestamp with Overflow Handling -->
                                <span class="text-muted small"
                                    style="position: absolute; bottom: -1.5rem; <?= $post['user_id'] === session()->get('id_user') ? 'right' : 'left' ?>: 0; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                    <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
                                </span>
                            </div>
                            <div class="m-2 <?= $post['user_id'] === session()->get('id_user') ? 'text-right' : '' ?>">
                                <?php if (!$post['is_deleted']) : ?>
                                    <button class="btn btn-link p-0" onclick="replyToPost('<?= $post['id'] ?>', '<?= $post['message'] ?>')">
                                        <span class="fas fa-reply"></span>
                                    </button>
                                <?php endif; ?>
                                <?php if ($post['user_id'] === session()->get('id_user') && !$post['is_deleted']) : ?>
                                    <button class="btn btn-link text-secondary p-0" onclick="handleDelete('<?= $post['id'] ?>')">
                                        <span class="fas fa-trash"></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (!$posts): ?>
                    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
                        <img src="<?= base_url('/dist/img/no-chats-found.png') ?>" alt="no-chats-found" style="max-width: 200px;">
                        <p class="mt-3 text-muted">Tidak ada pesan ditemukan. Mulai obrolan pertama anda.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Card Footer -->
        <div class="card-footer">
            <!-- Reply Context -->
            <div id="reply-context" style="display: none; margin-bottom: 1rem; padding: 0.5rem; background-color: #f8f9fa; border-radius: 4px; position: relative;">
                <strong class="mr-1">Membalas:</strong> <span id="reply-context-text"></span>
                <button type="button" class="btn btn-link p-0" onclick="clearReplyContext()" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);">
                    <span class="fas fa-times-circle"></span> Batal
                </button>
            </div>

            <form action="<?= base_url('pengaduan/chat/store'); ?>" method="POST" class="d-flex align-items-center">
                <input type="hidden" name="pengaduan_id" value="<?= $pengaduan['id'] ?>">
                <input type="hidden" name="parent_id" id="parent-id" value="">
                <textarea name="message" class="form-control me-2" rows="1" placeholder="Ketik pesan..." required style="resize: none;"></textarea>
                <button type="submit" class="btn btn-primary"><span class="fas fa-paper-plane"></span></button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('isi') ?>

<!-- ======= Section Scripts ======= -->
<?= $this->section('scripts') ?>
<script>
    let lastTimestamp = '<?= !empty($posts) ? $posts[count($posts) - 1]['created_at'] : '1970-01-01 00:00:00'; ?>';
    console.log(lastTimestamp);
    let pengaduanId = '<?= $pengaduan['id'] ?>';
    console.log(pengaduanId);
    let userId = '<?= session()->get('id_user') ?>';
    console.log(userId);
    let pelaporId = '<?= $pengaduan['user_id'] ?>';
    console.log(pelaporId);
</script>

<!-- Script Halaman chat -->
<script src="<?= base_url() ?>/dist/js/pages/chat_pengaduan.js"></script>
<?= $this->endSection('scripts') ?>
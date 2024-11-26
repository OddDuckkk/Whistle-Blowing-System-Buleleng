/* =======  VARIABEL & KOMPONEN INIT ======= */
// Inisialisasi modal pdf
$(document).ready(function() {
    $('.lampiran-link').click(function(e) {
        var fileUrl = $(this).data('file'); // ambil file url
        originalFileName = fileUrl.split('-').slice(1).join('-'); // nama file
        if (fileUrl.endsWith('.pdf')) {
            e.preventDefault(); 
            // Modal khusus pdf
            $('#pdfIframe').attr('src', fileUrl); 
            $('#pdfModalLabel').text(originalFileName); 
            $('#pdfModal').modal('show');
        }
    });
});

/* =======  FUNCTIONS ======= */
// Fungsi set value 'status-field'
function setStatus(status) {
    // Set the value of the hidden status field
    document.getElementById('status-field').value = status;
}

// Edit button
function handleEdit(pengaduanId) {
    window.location.href = baseUrl + "pengaduan/edit/" + pengaduanId;
}

// Delete button
function handleDelete(nip) {
showDeletionModal({
    title: 'Apakah Anda yakin?',
    text: 'Pengaduan akan dihapus selamanya!',
    icon: 'warning',
    confirmButtonText: 'Hapus',
    cancelButtonText: 'Batal',
    onConfirm: () => window.location.href = baseUrl + "pengaduan/delete/" + nip
});
}

// Back button
function handleBack() {
    const referrer = document.referrer;
    console.log(referrer);
    if (referrer.includes('pengaduan/detail')) {
        history.go(-2);
    } else {
        window.history.back();
    }
}




/* =======  EVENT LISTENERS ======= */
// Event listener success-message
document.addEventListener("DOMContentLoaded", function() {
    const flashData = document.getElementById("success-message").getAttribute("data-flashdata");

    if (flashData) {
        showSuccessionModal({
            title: 'Sukses',
            text: flashData,
            confirmButtonText: 'Selesai',
        });
    }
});

// Event listener failure-message
document.addEventListener("DOMContentLoaded", function() {
    const flashData = document.getElementById("failure-message").getAttribute("data-flashdata");

    if (flashData) {
        showFailureModal({
            title: 'Gagal',
            text: flashData,
            confirmButtonText: 'Kembali'
        });
    }
});
// Event listener info-message
document.addEventListener("DOMContentLoaded", function() {
    const flashData = document.getElementById("info-message").getAttribute("data-flashdata");

    if (flashData) {
        showInformationModal({
            title: 'Info',
            text: flashData,
            confirmButtonText: 'OK'
        });
    }
});

// Event listener lightbox
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    var fileUrl = $(this).data('file'); // ambil file url
    // Inisialisasi lightbox jika BUKAN pdf
    if (fileUrl && !fileUrl.endsWith('.pdf')) {
        event.preventDefault();  
        $(this).ekkoLightbox(); 
    }
});

// Event listener pelapor-pengaduan-status-form
const pelaporForm = document.getElementById('pelapor-pengaduan-status-form');
if (pelaporForm) {
    document.getElementById('pelapor-pengaduan-status-form').addEventListener('submit', function (event) {
        event.preventDefault(); 
        showConfirmationModal({
            title: 'Apakah Anda yakin?',
            text: 'Pengaduan akan dikirim ke tim investigasi dan tidak dapat dirubah lagi!',
            icon: 'warning',
            confirmButtonText: 'Kirim',
            cancelButtonText: 'Periksa lagi',
            onConfirm: () => this.submit()
        });
    });
}

// Event listener operator-pengaduan-status-form
const operatorForm = document.getElementById('operator-pengaduan-status-form');
if (operatorForm) {
    // Ganti status dari diproses operator ke diproses verifikator / dikembalikan / ditolak
    document.getElementById('operator-pengaduan-status-form').addEventListener('submit', function (event) {
        event.preventDefault(); 
        let newStatus = document.getElementById('status-field');
        console.log(newStatus);
        if (newStatus.value === 'diproses verifikator') {
            showConfirmationModalWithInput({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan diteruskan ke verifikator untuk proses verifikasi!',
                icon: 'warning',
                confirmButtonText: 'Teruskan',
                cancelButtonText: 'Periksa lagi',
                inputFieldName: 'Komentar',
                inputPlaceholder: 'Tambahkan keterangan untuk pelapor...',
                onConfirm: () => this.submit()
            }); 
        }
        else if (newStatus.value === 'dikembalikan') {
            showConfirmationModalWithInput({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan dikembalikan ke pelapor untuk di evaluasi kembali!',
                icon: 'warning',
                confirmButtonText: 'Kembalikan',
                cancelButtonText: 'Periksa lagi',
                inputFieldName: 'Komentar',
                inputPlaceholder: 'Tambahkan keterangan untuk pelapor...',
                onConfirm: () => this.submit()
            }); 
        }
        else if (newStatus.value === 'ditolak') {
            showConfirmationModalWithInput({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan ditolak, dan tidak dapat diubah lagi!',
                icon: 'warning',
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Periksa lagi',
                inputFieldName: 'Komentar',
                inputPlaceholder: 'Tambahkan keterangan untuk pelapor...',
                onConfirm: () => this.submit()
            }); 
        }
    });
} 

// Event listener verifikator-pengaduan-status-form
const verifikatorForm = document.getElementById('verifikator-pengaduan-status-form');
if (verifikatorForm) {
    // Ganti status dari diproses verifikator ke selesai
    document.getElementById('verifikator-pengaduan-status-form').addEventListener('submit', function (event) {
        event.preventDefault(); 
        let newStatus = document.getElementById('status-field');
        if (newStatus.value === 'selesai') {
            showConfirmationModalWithInput({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan diselesaikan, dan tidak dapat diubah lagi!',
                icon: 'warning',
                confirmButtonText: 'Selesaikan',
                cancelButtonText: 'Periksa lagi',
                inputFieldName: 'Komentar',
                inputPlaceholder: 'Tambahkan keterangan untuk pelapor...',
                onConfirm: () => this.submit()
            }); 
        }
    });
}




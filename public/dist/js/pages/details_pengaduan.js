// Ganti status dari baru ke dikirim
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

// set value input "status"
function setStatus(status) {
    // Set the value of the hidden status field
    document.getElementById('status-field').value = status;
}

const operatorForm = document.getElementById('operator-pengaduan-status-form');

if (operatorForm) {
    // Ganti status dari diproses operator ke diproses verifikator atau dikembalikan
    document.getElementById('operator-pengaduan-status-form').addEventListener('submit', function (event) {
        event.preventDefault(); 
        let newStatus = document.getElementById('status-field');
        if (newStatus.value === 'diproses verifikator') {
            showConfirmationModal({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan diteruskan ke verifikator untuk proses verifikasi!',
                icon: 'warning',
                confirmButtonText: 'Teruskan',
                cancelButtonText: 'Periksa lagi',
                onConfirm: () => this.submit()
            }); 
        }
        else if (newStatus.value === 'dikembalikan') {
            showConfirmationModal({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan dikembalikan ke pelapor untuk di evaluasi kembali!',
                icon: 'warning',
                confirmButtonText: 'Kembalikan',
                cancelButtonText: 'Periksa lagi',
                onConfirm: () => this.submit()
            }); 
        }
    });
} 

const verifikatorForm = document.getElementById('verifikator-pengaduan-status-form');

if (verifikatorForm) {
    // Ganti status dari diproses verifikator ke selesai atau ditolak
    document.getElementById('verifikator-pengaduan-status-form').addEventListener('submit', function (event) {
        event.preventDefault(); 
        let newStatus = document.getElementById('status-field');
        if (newStatus.value === 'selesai') {
            showConfirmationModal({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan diselesaikan, dan tidak dapat diubah lagi!',
                icon: 'warning',
                confirmButtonText: 'Selesaikan',
                cancelButtonText: 'Periksa lagi',
                onConfirm: () => this.submit()
            }); 
        }
        else if (newStatus.value === 'ditolak') {
            showConfirmationModal({
                title: 'Apakah Anda yakin?',
                text: 'Pengaduan akan ditolak, dan tidak dapat diubah lagi!',
                icon: 'warning',
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Periksa lagi',
                onConfirm: () => this.submit()
            }); 
        }
    });
}


// Handle edit button
function handleEdit(pengaduanId) {
        window.location.href = baseUrl + "pengaduan/edit/" + pengaduanId;
}

// Handle delete button
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


// Pemanggilan modal sukses, jika terdapat sucess-message
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

// Memanggil modal failure jika terdapat failure-message
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
// Memanggil modal info jika terdapat info-message
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
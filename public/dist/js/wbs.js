/* =======  VARIABEL & KOMPONEN INIT ======= */
// Base url
const baseUrl = document.body.getAttribute('base-url');

$(document).ready(function() {
    // Inisialisasi tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Inisialisasi select2
    $('.select2').select2();
});

/* =======  FUNCTIONS ======= */
// Function memunculkan toast
// Contoh penggunaan: showToast('Judul toast', 'Pesan yang akan ditampilkan', '(success/warning/danger)');
function showToast(title, message, type) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: type, 
        title: title,
        text: message
    });
    // Jalankan toast
    Toast.fire();
}

// Function menampilkan modal konfirmasi
// Contoh penggunaan:
/* showConfirmationModal({
    title: 'Judul Modal',
    text: 'Pesan modal',
    icon: '(warning/info)',
    confirmButtonText: 'Teks button confirm',
    cancelButtonText: 'Teks button cancel',
    onConfirm: () => this.submit() // hal yang dilakukan jika user klik confirm
}); */
function showConfirmationModal({title, text, icon, confirmButtonText, cancelButtonText, onConfirm}) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}

// Function menampilkan modal penghapusan data
// Contoh penggunaan:
/* showDeletionModal({
    title: 'Judul Modal',
    text: 'Pesan modal',
    icon: '(warning/error)',
    confirmButtonText: 'Teks button confirm',
    cancelButtonText: 'Teks button cancel',
    onConfirm: () => this.submit() // hal yang dilakukan jika user klik confirm
}); */
function showDeletionModal({title, text, icon, confirmButtonText, cancelButtonText, onConfirm}) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}

// Function menampilkan modal success
// Contoh penggunaan:
/* showSuccessionModal({
    title: 'Judul Modal',
    text: 'Pesan modal',
    confirmButtonText: 'Teks button confirm',
}); */
function showSuccessionModal({title, text, confirmButtonText}) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonColor: '#27a844',
        confirmButtonText: confirmButtonText
    })
}

// Function menampilkan modal kegagalan
// Contoh penggunaan:
/* showFailureModal({
    title: 'Judul Modal',
    text: 'Pesan modal',
    confirmButtonText: 'Teks button confirm'
}); */
function showFailureModal({title, text, confirmButtonText}) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonColor: '#007bff',
        confirmButtonText: confirmButtonText,
    })
}

function showInformationModal({title, text, confirmButtonText}) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonColor: '#007bff',
        confirmButtonText: confirmButtonText,
    })
}

// Fungsi ganti status pengaduan
function changeStatus(pengaduanId, status) {
    $.ajax({
        url: baseUrl + "/pengaduan/change-status",
        type: 'POST',
        data: {
            pengaduan_id: pengaduanId,
            status: status
        },
        error: function() {
            showToast('Error', 'Koneksi ke server gagal', 'error');
        }
    });
}

/* =======  EVENT LISTENER ======= */



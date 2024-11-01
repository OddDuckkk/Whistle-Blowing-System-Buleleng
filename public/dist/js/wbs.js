// Variabel base url
const baseUrl = document.body.getAttribute('base-url');

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

// Menampilkan tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

// Menampilkan select2
$(document).ready(function() {
    $('.select2').select2();
});

// Function menampilkan modal konfirmasi
// Contoh penggunaan:
/* showConfirmationModal({
    title: 'Judul Modal',
    text: 'Pesan modal',
    icon: '(success/warning/danger)',
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
    icon: '(warning/danger)',
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

function showSuccessionModal({title, text, icon, confirmButtonText, onConfirm}) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: '#27a844',
        confirmButtonText: confirmButtonText
    }).then((result) => {
        if (result.isConfirmed) {
            onConfirm();
        }
    });
}
/* =======  VARIABEL & KOMPONEN INIT ======= */
// Inisialisasi tabel pengaduan
$(document).ready(function() {
    $('#pengaduanTable').DataTable({
        "lengthMenu": [5, 10, 25, 50, 100],
        "pageLength": 10,
        "responsive": true,
        "lengthChange": true,
        "autoWidth": false,
        "language": {
            "url": "<?= base_url() ?>/plugins/datatables/i18n/Indonesian.json"
        },
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[0, 'desc']]
    }).buttons().container().appendTo('#pengaduanTable_wrapper .col-md-6:eq(0)');
});

/* =======  FUNCTIONS ======= */
// Handle button detail
function handleDetails(pengaduanId) {
    window.location.href = baseUrl + "pengaduan/details/" + pengaduanId;
}

function handleChat(pengaduanId) {
    window.location.href = baseUrl + "pengaduan/chat/" + pengaduanId;
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
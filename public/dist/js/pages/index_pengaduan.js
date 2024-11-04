// Config data table pengaduan
$(document).ready(function() {
    $('#pengaduanTable').DataTable({
        "lengthMenu": [5, 10, 25, 50, 100],
        "pageLength": 5,
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

// Handle button detail
function handleDetails(pengaduanId) {
    window.location.href = baseUrl + "/pengaduan/details/" + pengaduanId;
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
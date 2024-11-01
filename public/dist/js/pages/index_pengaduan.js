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




// Not working ***
document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.getElementById('successMessage').value;
    if (successMessage) {
        showToast('Success', successMessage, 'success');
    }
});
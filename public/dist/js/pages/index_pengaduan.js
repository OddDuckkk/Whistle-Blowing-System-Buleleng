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

document.addEventListener("DOMContentLoaded", function() {
    // Check if there's a success message in the session
    const successMessage = document.getElementById('successMessage').value;
    if (successMessage) {
        // Show SweetAlert toast
        showToast('Success', successMessage, 'success');
    }
});
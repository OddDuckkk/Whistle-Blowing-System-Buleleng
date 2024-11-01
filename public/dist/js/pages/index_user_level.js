$(document).ready(function() {
    $('#userLevelTable').DataTable({
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
    }).buttons().container().appendTo('#userLevelTable_wrapper .col-md-6:eq(0)');
});

function confirmDelete(nip) {
    showDeletionModal({
        title: 'Apakah Anda yakin?',
        text: 'User tidak akan lagi memiliki level tersebut!',
        icon: 'warning',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        onConfirm: () => window.location.href = baseUrl + "/user-level/delete/" + nip
    });
}
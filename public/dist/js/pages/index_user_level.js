// Config data table user-level 
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

// Handle edit button
function handleEdit(nip) {
    window.location.href = baseUrl + "/user-level/edit/" + nip;
}

// Handle delete button
function handleDelete(nip) {
    showDeletionModal({
        title: 'Apakah Anda yakin?',
        text: 'User tidak akan lagi memiliki level tersebut!',
        icon: 'warning',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        onConfirm: () => window.location.href = baseUrl + "/user-level/delete/" + nip
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
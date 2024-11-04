// Handle edit button
function handleEdit(pengaduanId) {
        window.location.href = baseUrl + "/pengaduan/edit/" + pengaduanId;
}

// Handle delete button
function handleDelete(nip) {
    showDeletionModal({
        title: 'Apakah Anda yakin?',
        text: 'Pengaduan akan dihapus selamanya!',
        icon: 'warning',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        onConfirm: () => window.location.href = baseUrl + "/pengaduan/delete/" + nip
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
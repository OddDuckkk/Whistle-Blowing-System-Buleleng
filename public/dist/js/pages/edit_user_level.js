/* =======  EVENT LISTENERS ======= */
// event listener form submit
document.getElementById('edit-user-level-form').addEventListener('submit', function (event) {
    event.preventDefault(); 
    // Tampilkan modal konfirmasi
    showConfirmationModal({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin untuk merubah level?',
        icon: 'warning',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Periksa Lagi',
        onConfirm: () => this.submit() 
    });
});
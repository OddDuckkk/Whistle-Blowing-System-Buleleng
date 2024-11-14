/* =======  EVENT LISTENERS ======= */
// Event listener button search data nip
$(document).on('click', '.search-user', function() {
    // Mengambil row dan nip
    let row = $(this).closest('tr');
    let nip = row.find('input[name="nip_pegawai"]').val();

    let spinner = row.find('.spinner-border');
    let icon = row.find('i.fa-search');

    spinner.show();
    icon.hide();

    // teruskan ke controller
    $.ajax({
        url: baseUrl + 'auth/search-nip', 
        method: 'POST',
        data: { nip: nip },
        success: function(res) {
            spinner.hide();
            icon.show();

            if (!res.is_error) {
                // Isi field lain dengan data yang didapat
                row.find('input[name="nama_pegawai"]').val(res.nama_pegawai);
                row.find('input[name="jabatan_pegawai"]').val(res.jabatan_pegawai);
                row.find('input[name="unit_kerja"]').val(res.unit_kerja);
            } else {
                // Error jika data tidak ditemukan
                showToast('Error', 'Data Pegawai tidak ditemukan', 'error');
            }
        },
        error: function() {
            spinner.hide();
            icon.show();
            // Error jika terdapat kesalahan dalam menghubungkan ke server
            showToast('Error', 'Failed to connect to the server.', 'error');
        }
    });
});

// Event listener form submit
document.getElementById('assign-user-level-form').addEventListener('submit', function (event) {
    event.preventDefault(); 

    showConfirmationModal({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin untuk memberi level?',
        icon: 'warning',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Periksa Lagi',
        onConfirm: () => this.submit() 
    });
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

// Event listener sucess-message
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
// Config date time picker
$(function () {
    $('#tanggalkejadian').datetimepicker({
        format: 'YYYY-MM-DD', 
        icons: {
            time: 'fa fa-clock',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-calendar-check',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        }
    });

    $('#tanggal').on('focus', function() {
        $('#tanggalkejadian').datetimepicker('show');
    });
});

// Event listener menambahkan row pihak terlibat
$('#pihakTerlibatTable').on('click', '.add-row', function() {
    var newRow = `<tr>
                    <td>
                            <div class="input-group">
                                <input type="text" 
                                name="nip_terlapor[]" 
                                class="form-control" 
                                placeholder="NIP Terlapor">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary search-nip">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" 
                            name="nama_terlapor[]" 
                            class="form-control" 
                            placeholder="Nama Terlapor" 
                            readonly>
                        </td>
                        <td>
                            <input type="text" 
                            name="jabatan_terlapor[]" 
                            class="form-control" 
                            placeholder="Jabatan Terlapor" 
                            readonly>
                        </td>
                        <td>
                            <input type="text" 
                            name="unit_kerja[]" 
                            class="form-control" 
                            placeholder="Unit Kerja Terlapor" 
                            readonly>
                        </td>
                    <td>
                    <button type="button" 
                    class="btn btn-danger remove-row"
                    data-toggle="tooltip" 
                    title="Hapus Baris"><span class="fa fa-minus"></span></button>
                    <button type="button" 
                    class="btn btn-info change-non-asn" 
                    data-toggle="tooltip" 
                    title="Ganti menjadi non-ASN"><span class="fas fa-sync-alt"></span></button>
                    </td>
                </tr>`;
    $('#pihakTerlibatTable tbody').append(newRow);
});

// Event listener menghapus row pihak terlibat
$('#pihakTerlibatTable').on('click', '.remove-row', function() {
    $(this).closest('tr').remove();
});

// Event listener mengganti mode row pihak terlibat menjadi non-asn
$('#pihakTerlibatTable').on('click', '.change-non-asn', function() {
    const $row = $(this).closest('tr');
    const isNonAsn = $(this).data('non-asn') || false; //cek state dari row

    if (isNonAsn) {
        // Ubah ke mode ASN
        $row.find('input[name="nip_terlapor[]"]').removeAttr('readonly').val('');
        $row.find('input[name="nama_terlapor[]"]').attr('readonly', 'true').val('');
        $row.find('input[name="jabatan_terlapor[]"]').attr('readonly', 'true').val('');
        $row.find('input[name="unit_kerja[]"]').attr('readonly', 'true').val('');
        
        $row.find('.change-non-asn').attr('data-original-title', 'Ganti menjadi non-ASN').tooltip('show'); // Update tooltip title and show it
        $(this).data('non-asn', false);
    } else {
        // Ubah ke mode non ASN
        $row.find('input[name="nip_terlapor[]"]').attr('readonly', 'true').val('Non-ASN');
        $row.find('input[name="nama_terlapor[]"]').removeAttr('readonly').val('');
        $row.find('input[name="jabatan_terlapor[]"]').removeAttr('readonly').val('');
        $row.find('input[name="unit_kerja[]"]').removeAttr('readonly').val('');
        
        $row.find('.change-non-asn').attr('data-original-title', 'Ganti menjadi ASN').tooltip('show'); // Update tooltip title and show it
        $(this).data('non-asn', true);
    }
    
});

// Event listener menampilkan tooltip info non-asn
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#non-asn-info').on('click', function (e) {
        e.preventDefault();

        const $nonAsnButton = $('.change-non-asn').first();
        
        if ($nonAsnButton.length) {
            $nonAsnButton.tooltip('show');
            $nonAsnButton.focus();
            setTimeout(() => {
                $nonAsnButton.tooltip('hide');
            }, 2000);
        }
    });
});

// Event listener mencari data nip
$(document).on('click', '.search-nip', function() {
    // Mengambil row dan nip
    let row = $(this).closest('tr');
    let nip = row.find('input[name="nip_terlapor[]"]').val();

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
                row.find('input[name="nama_terlapor[]"]').val(res.nama_pegawai);
                row.find('input[name="jabatan_terlapor[]"]').val(res.jabatan_pegawai);
                row.find('input[name="unit_kerja[]"]').val(res.unit_kerja);
            } else {
                // Error jika data tidak ditemukan
                showToast('Error', 'Data Pegawai tidak ditemukan', 'error');
            }
        },
        error: function() {
            spinner.hide();
            icon.show();
            // Error jika terdapat kesalahan dalam menghubungkan ke server
            showToast('Error', 'Koneksi ke server gagal', 'error');
        }
    });
});

// Memanggil modal konfirmasi simpan
document.getElementById('pengaduan_form').addEventListener('submit', function (event) {
    event.preventDefault(); 
    
    showConfirmationModal({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menyimpan pengaduan ini?',
        icon: 'warning',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Periksa Lagi',
        onConfirm: () => this.submit() 
    });
});

// Config dropzone
Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone-lampiran", {
    url: baseUrl + "pengaduan/upload-file",
    maxFilesize: 10,
    maxFiles: 3,
    addRemoveLinks: true,
    dictRemoveFile: "Hapus File",
    acceptedFiles: ".jpeg,.jpg,.png,.pdf",
    init: function() {
        const myDropzone = this;
        let isEmittingMockFile = false;
        let mockFilesCounter = 0;

        // Fungsi event file ditambah
        myDropzone.on("addedfile", function(file) {

            if (file.type === "application/pdf") {
                myDropzone.emit("thumbnail", file, baseUrl + "dist/img/pdf-icon.svg"); 
            }

            // Validasi jika file lebih dari yang ditentukan
            if ((myDropzone.files.length + mockFilesCounter) > myDropzone.options.maxFiles) {
                showToast('Warning', 'Jumlah maksimum file sudah diraih!', 'warning');
                myDropzone.removeFile(file);
            } 

            // Validasi ukuran file
            if (file.size > myDropzone.options.maxFilesize * 1024 * 1024) {
                showToast('Warning', 'Ukuran file tidak boleh melebihi 10MB!', 'warning');
                myDropzone.removeFile(file);
            }
        
            // Tampilkan tabel detail dan deskripsi lampiran
            const detailsTable = document.getElementById("lampiranDetailsTable");
            detailsTable.style.display = "table";

            // Tambahkan row pada tabel detail deskripsi lampiran
            const rowId = `row-${file.upload.uuid}`;
            const rowHtml = `
                <tr id="${rowId}">
                    <td style="width: 50%; word-break: break-all;">${file.name}</td>
                    <td style="width: 50%;">
                        <textarea name="deskripsi_lampiran[]" 
                        class="form-control" rows="2" 
                        placeholder="Deskripsi Lampiran"></textarea>
                    </td>
                </tr>
            `;
            detailsTable.querySelector("tbody").insertAdjacentHTML("beforeend", rowHtml);

            // Inisialisasi hidden input untuk dikirimkan ke controller
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "file_lampiran[]";
            input.value = ''; 
            input.dataset.uuid = file.upload.uuid;
            document.getElementById("fileInputs").appendChild(input);
            file.hiddenInput = input; 
            file.rowId = rowId; 

            if (file.isMock) {
                file.hiddenInput.value = file.filePath; 
                mockFilesCounter++;
            }

            const dzMessage = document.querySelector(".dz-message");
            if ((myDropzone.files.length + mockFilesCounter) === 0) {
                dzMessage.style.display = 'block';
            } else {
                dzMessage.style.display = 'none';
            }
        });


        // Fungsi event file dihapus
        this.on("removedfile", function(file) {
            // Hapus hidden input
            if (file.hiddenInput) {
                file.hiddenInput.remove();
            }

            // Hapus row tabel detail deskripsi lampiran
            const row = document.getElementById(file.rowId);
            if (row) {
                row.remove();
            }

            // Hilangkan tabel detail deskripsi apabila tidak ada lampiran
            const detailsTable = document.getElementById("lampiranDetailsTable");
            if (detailsTable.querySelector("tbody").children.length === 0) {
                detailsTable.style.display = "none";
            }

            // Jalankan request hapus file ke controller
            const filePath = file.filePath.replace(/\\/g, ''); 
            fetch(baseUrl + "pengaduan/delete-file", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ filePath: filePath })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });

            if (file.isMock) {
                mockFilesCounter--;
            }

            const dzMessage = document.querySelector(".dz-message");
            if ((myDropzone.files.length + mockFilesCounter) === 0) {
                dzMessage.style.display = 'block';
            } else {
                dzMessage.style.display = 'none';
            }
        });

        // Handling repopulasi data
        const savedFiles = document.querySelectorAll("input[name='old_file_lampiran[]']");
        savedFiles.forEach((input, index) => {
            const filePath = input.value;
            const fileName = filePath.split('/').pop();

            // Buat mock file
            const mockFile = {
                name: fileName,
                size: 12345, 
                filePath: filePath,
                upload: { uuid: 'mock-' + index }, 
                isMock: true
            };

            // isEmittingMockFile = true;

            // Tambah mock file ke dropzone
            myDropzone.emit("addedfile", mockFile);

            // set thumbnail
            if (filePath.endsWith(".pdf")) {
                myDropzone.emit("thumbnail", mockFile, baseUrl + "dist/img/pdf-icon.svg");
            } else {
                myDropzone.emit("thumbnail", mockFile, baseUrl + filePath);
            }

            myDropzone.emit("complete", mockFile);

            // isEmittingMockFile = false;

        });

        // Fungsi jika page di reload
        window.addEventListener('beforeunload', function(event) {
            myDropzone.files.forEach(file => {
                const filePath = file.filePath.replace(/\\/g, ''); // Get the correct file path
                if (!isFormSubmitted) {
                    if (filePath) {
                        // Synchronous request sehingga reload page menunggu penghapusan file selesai
                        navigator.sendBeacon(baseUrl + "pengaduan/delete-file", JSON.stringify({ filePath: filePath }));
                    }
                }
            });
        });
        
        const form = document.getElementById("pengaduan_form"); 
        form.addEventListener("submit", function() {
            isFormSubmitted = true;
        });
        
    },
    success: function(file, response) {
        // Fungsi jika file berhasil ditambah

        // Parse response
        if (typeof response === 'string') {
            response = JSON.parse(response);
        }

        //Simpan filePath
        file.filePath = response.filePath.replace(/\\/g, '');

        // Update hidden input
        if (file.hiddenInput) {
            file.hiddenInput.value = file.filePath; 
        }
        console.log(response.filePath);
    }
});



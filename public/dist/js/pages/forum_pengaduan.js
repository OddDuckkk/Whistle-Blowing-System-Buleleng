function replyToPost(postId, postContent) {
    // Focus the message textarea
    const messageBox = document.querySelector('textarea[name="message"]');
    messageBox.focus();

    // Set the parent_id value
    document.getElementById('parent-id').value = postId;

    // Display the reply context with the post content (first 30 characters followed by "...")
    const replyContext = document.getElementById('reply-context');
    const replyContextText = document.getElementById('reply-context-text');
    
    // Trim the content to the first 30 characters, followed by "..."
    const trimmedContent = postContent.length > 30 ? postContent.slice(0, 100) + '...' : postContent;
    
    replyContextText.textContent = 'Membalas: ' + trimmedContent;
    replyContext.style.display = 'flex';
}


function clearReplyContext() {
    // Hide the reply context and clear the parent_id
    document.getElementById('reply-context').style.display = 'none';
    document.getElementById('parent-id').value = '';
    document.getElementById('reply-context-text').textContent = '';
}

function handleDelete(post_id) {
    showDeletionModal({
        title: 'Apakah Anda yakin?',
        text: 'Pesan akan dihapus!',
        icon: 'warning',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        onConfirm: () => window.location.href = baseUrl + "pengaduan/forum/delete/" + post_id
    });
    }

window.onload = function() {
    window.scrollTo(0, document.body.scrollHeight);
};

// Inisialisasi dropzone
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
        let rowIndex = 0;

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

            let originalFileName = file.name; 

            if (document.querySelector(`input[name='old_deskripsi_lampiran[${rowIndex}]']`)) {
                originalFileName = file.name.split('-').slice(1).join('-');  
            };

            const rowId = `row-${file.upload.uuid}`;
            const deskripsiInput = document.querySelector(`input[name='old_deskripsi_lampiran[${rowIndex}]']`);
            const errorInput = document.querySelector(`input[name='old_error_deskripsi[${rowIndex}]']`);
            const deskripsiValue = deskripsiInput ? deskripsiInput.value : "";
            const hasError = errorInput && errorInput.value === "true";
            const errorClass = hasError ? "is-invalid" : "";

            // Create a single row for each file
            const rowHtml = `
                <tr id="${rowId}">
                    <td style="width: 50%; word-break: break-all;">${originalFileName}</td>
                    <td style="width: 50%;">
                        <textarea name="deskripsi_lampiran[]" 
                        class="form-control ${errorClass}" 
                        rows="2" 
                        placeholder="Deskripsi Lampiran">${deskripsiValue}</textarea>
                        ${hasError ? `
                            <div class="invalid-feedback">
                                Deskripsi lampiran tidak boleh kosong
                            </div>
                        ` : ""}
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

            rowIndex++;
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

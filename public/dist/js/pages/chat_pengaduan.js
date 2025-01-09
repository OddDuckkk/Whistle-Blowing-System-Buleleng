function replyToPost(postId, message) {
    const trimmedMessage = message.length > 70 ? message.slice(0, 70) + '...' : message;
    document.getElementById('parent-id').value = postId;
    const replyContext = document.getElementById('reply-context');
    const replyText = document.getElementById('reply-context-text');
    replyText.innerHTML = ` ${trimmedMessage}`;
    replyContext.style.display = 'flex';
}

function clearReplyContext() {
    document.getElementById('parent-id').value = '';
    document.getElementById('reply-context').style.display = 'none';
}

function handleDelete(post_id) {
    showDeletionModal({
        title: 'Apakah Anda yakin?',
        text: 'Pesan akan dihapus!',
        icon: 'warning',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        onConfirm: () => window.location.href = baseUrl + "pengaduan/chat/delete/" + post_id
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var chatMessages = document.getElementById('chat-messages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});

function fetchNewMessages() {
    let fetchUrl = baseUrl + '/pengaduan/chat/new-messages/' + pengaduanId + '/' + encodeURIComponent(lastTimestamp);
    console.log(fetchUrl);

    fetch(fetchUrl)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                let chatMessages = document.getElementById('chat-messages');
                console.log(data);

                data.forEach(message => {
                    console.log(message);

                    // Parse `is_deleted` to a boolean
                    const isDeleted = message.is_deleted === "1";

                    // Create message element
                    let messageElement = document.createElement('div');
                    messageElement.classList.add('direct-chat-msg', 'pb-1');
                    if (message.user_id === userId) messageElement.classList.add('right');

                    // Add message HTML structure
                    messageElement.innerHTML = `
                        <div class="direct-chat-infos clearfix d-flex align-items-end ${message.user_id === userId ? 'flex-row-reverse' : ''}">
                            <span class="direct-chat-name ${message.user_id === userId ? 'float-right ml-2' : 'float-left mr-2'}">
                                ${message.user_id === userId ? 'Anda' : (message.user_id === pelaporId ? 'Pelapor' : 'Verifikator')}
                            </span>
                            ${message.parent_id ? `
                                <div class="parent-message-bubble font-weight-normal ${message.user_id === userId ? 'right' : ''}">
                                    <a href="#${message.parent_id}">${message.parent_message}</a>
                                </div>` : ''}
                        </div>

                        <div class="d-flex align-items-start mb-3 ${message.user_id === userId ? 'flex-row-reverse' : ''}">
                            <img class="direct-chat-img elevation-2 ${message.user_id === userId ? 'ml-2' : 'mr-2'}"
                                src="${baseUrl + '/dist/img/anonymous.png'}" alt="User Image">

                            <div class="direct-chat-text"
                                id="${message.id}"
                                style="display: inline-block; max-width: 60%; text-align: left; position: relative; margin: 0;">
                                ${isDeleted ? '<i>Pesan ini telah dihapus</i>' : message.message}

                                <span class="text-muted small"
                                    style="position: absolute; bottom: -1.5rem; ${message.user_id === userId ? 'right' : 'left'}: 0; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                    ${new Date(message.created_at).toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                </span>
                            </div>

                            <div class="m-2 ${message.user_id === userId ? 'text-right' : ''}">
                                ${!isDeleted ? `
                                    <button class="btn btn-link p-0" onclick="replyToPost('${message.id}', '${message.message}')">
                                        <span class="fas fa-reply"></span>
                                    </button>` : ''}
                                ${message.user_id === userId && !isDeleted ? `
                                    <button class="btn btn-link text-secondary p-0" onclick="handleDelete('${message.id}')">
                                        <span class="fas fa-trash"></span>
                                    </button>` : ''}
                            </div>
                        </div>
                    `;

                    // Append the constructed element to the chat container
                    chatMessages.appendChild(messageElement);

                    // Auto-scroll to the bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                });

                // Update lastTimestamp
                lastTimestamp = data[data.length - 1].created_at;
            }
        })
        .catch(error => console.error('Error fetching new messages:', error));
}



setInterval(fetchNewMessages, 3000);

document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('a[data-id]'); // Assuming your parent_message links use data-id attributes
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default anchor behavior

            const targetId = this.getAttribute('data-id'); // Get the target ID
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                // Calculate the position to scroll to
                const container = document.querySelector('#chat-messages'); // Your scrollable container
                const targetPosition = targetElement.offsetTop; // Element's position within the container
                const containerHeight = container.offsetHeight;
                const targetHeight = targetElement.offsetHeight;

                // Offset to center the element
                const scrollToPosition = targetPosition - (containerHeight / 2) + (targetHeight / 2);

                // Smooth scroll
                container.scrollTo({
                    top: scrollToPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});





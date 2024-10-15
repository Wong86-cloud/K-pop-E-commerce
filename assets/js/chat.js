const form = document.querySelector(".typing-area"),
      inputField = form.querySelector(".input-field"),
      sendBtn = form.querySelector(".send-button"),
      attachButton = form.querySelector(".attach-button"),
      attachInput = form.querySelector(".attach-input"),
      chatBox = document.querySelector(".chat-box");

attachButton.onclick = () => {
    attachInput.click(); // Trigger file input click
};

attachInput.onchange = () => {
    const file = attachInput.files[0];
    if (file) {
        console.log("File selected: ", file.name);
    }
};

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "db_connection/chat/insert_chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = ""; // Clear input field
                attachInput.value = ""; // Clear file input
                fetchChatMessages(); // Fetch updated chat messages
            }
        }
    };

    let formData = new FormData(form);
    let file = attachInput.files[0];
    if (file) {
        formData.append("attachment", file);
    }
    xhr.send(formData);
};


let isAtBottom = true; // Track if user is at the bottom of the chat

// Function to fetch chat messages
function fetchChatMessages() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "db_connection/chat/get_chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            if(xhr.status === 200) {
                chatBox.innerHTML = xhr.response; // Update chat box content
                if (isAtBottom) {
                    scrollToBottom(); // Scroll to the bottom only if user is at the bottom
                }
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
}

// Function to scroll chat to the bottom
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
}

// Event listener to track scrolling
chatBox.addEventListener('scroll', () => {
    // Check if user is at the bottom
    isAtBottom = chatBox.scrollHeight - chatBox.scrollTop <= chatBox.clientHeight + 1;
});

// Set interval to update messages every 500 milliseconds
setInterval(fetchChatMessages, 500);

function openModal(imageSrc) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImage.src = imageSrc;
}

function closeModal() {
    const modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

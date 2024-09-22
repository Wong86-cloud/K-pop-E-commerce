/// Open the tracking modal
function openTracking() {
    document.getElementById('tracking-modal').style.display = 'block';
}

// Close the tracking modal
function closeTracking() {
    document.getElementById('tracking-modal').style.display = 'none';
}

// Mark the product as received and hide it from the list
function markAsReceived(button) {
    button.closest('.product').remove();
    alert("You have marked this product as received.");
}

// Open the chat modal
function openChat() {
    document.getElementById('tracking-modal').style.display = 'none';
    document.getElementById('chat-modal').style.display = 'block';
}

// Close the chat modal
function closeChat() {
    document.getElementById('chat-modal').style.display = 'none';
}

// Simulate sending a chat message
function sendMessage() {
    const message = document.getElementById('chat-input').value;
    const chatBox = document.querySelector('.chat-box');
    if (message.trim()) {
        chatBox.innerHTML += `<p><strong>You:</strong> ${message}</p>`;
        document.getElementById('chat-input').value = ''; // Clear input
        chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll to the bottom
    }
}

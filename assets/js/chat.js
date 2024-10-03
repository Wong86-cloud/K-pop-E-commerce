const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest(); // creating XML object
    xhr.open("POST", "server/insert_chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = ""; // once message inserted into database, leave the input field
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending form data to php    
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}
chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval(() => { 
    // let's start Ajax
    let xhr = new XMLHttpRequest(); // creating XML object
    xhr.open("POST", "server/get_chat.php", true); //receive data not to send 
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                chatBox.innerHTML = data;   
                if(!chatBox.classList.contains("active")){
                    scrollToBottom();
                }   
            }
        }
    }
    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending form data to php    
}, 500); //this function will run every 500 milliseconds

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}
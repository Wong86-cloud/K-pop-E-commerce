const form = document.querySelector('.register form'),
continueBtn = form.querySelector('.button input'),
errorText = form.querySelector('.error-txt');

form.onsubmit = (e) => {
    e.preventDefault(); // preventing form from submitting
}

continueBtn.onclick = () => {
    let xhr = new XMLHttpRequest(); // creating XML object
    xhr.open("POST", "server/register_info.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response.trim();
                console.log(data);
                if(data == "success"){
                    location.href = "home.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";    
                }
            }
        }
    }
    let formData = new FormData(form); // creating new formData object
    xhr.send(formData); // sending form data to php    
}

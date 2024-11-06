/*Show and hide password*/
const pswrdField = document.querySelector('.form .field input[type="password"]'),
toggleBtn = document.querySelector(".form .field i");

if (toggleBtn) {
    toggleBtn.onclick = ()=>{
        if(pswrdField.type == "password"){
            pswrdField.type = "text";
            toggleBtn.classList.add("active");
        }else{
            pswrdField.type = "password";
            toggleBtn.classList.remove("active");
        }
    }
}

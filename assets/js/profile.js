// Background Picture Upload
const backgroundImage = document.querySelector('#background-picture');
const backgroundFile = document.querySelector('#upload-background-picture');

backgroundFile.addEventListener('change', function(){
    const choosedFile = this.files[0];

    if(choosedFile){
        const reader = new FileReader();

        reader.addEventListener('load', function(){
            backgroundImage.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});

// Profile Header Upload
const headerImg = document.querySelector('#profile-photo');
const headerFile = document.querySelector('#upload-profile-header');

headerFile.addEventListener('change', function(){
    const choosedFile = this.files[0];

    if(choosedFile){
        const reader = new FileReader();

        reader.addEventListener('load', function(){
            headerImg.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});

// Modal Structure for Viewing Images
const modal = document.getElementById('image-modal');
const modalImg = document.getElementById('modal-image');
const closeModal = document.querySelector('.close');

// Function to show image in modal
function showModal(imgSrc) {
    modal.style.display = 'block';
    modalImg.src = imgSrc;
}

// Add click event to profile photo
headerImg.addEventListener('click', function() {
    showModal(this.src);
});

// Add click event to background photo
backgroundImage.addEventListener('click', function() {
    showModal(this.src);
});

// Close the modal when the close button is clicked
closeModal.addEventListener('click', function() {
    modal.style.display = 'none';
});

// Close the modal when the user clicks outside the modal
window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});


document.getElementById("save-changes").onclick = function() {
    let formData = new FormData();
    formData.append('fname', document.getElementById('profile-name').value.split(' ')[0]);
    formData.append('lname', document.getElementById('profile-name').value.split(' ')[1]);
    
    // Check if a new profile photo is selected
    let profilePhoto = document.getElementById('upload-profile-photo').files[0];
    if (profilePhoto) {
        formData.append('profile_photo', profilePhoto);
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "server/update_profile.php", true);
    xhr.onload = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Profile updated successfully!");
                location.reload(); // Refresh the page to reflect the updated info
            }
        }
    };
    xhr.send(formData);
}
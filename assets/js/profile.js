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
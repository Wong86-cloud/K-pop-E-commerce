// Background Picture Upload
const backgroundImage = document.querySelector('#background-picture');
const backgroundFile = document.querySelector('#upload-background-picture');

backgroundFile.addEventListener('change', function() {
    const choosedFile = this.files[0];

    if (choosedFile) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            backgroundImage.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});

// Profile Header Upload
const headerImg = document.querySelector('#profile-photo');
const headerFile = document.querySelector('#upload-profile-header');

headerFile.addEventListener('change', function() {
    const choosedFile = this.files[0];

    if (choosedFile) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
            headerImg.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});

// Save Changes Button Click Event
document.getElementById("save-changes").onclick = function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Create a new FormData object
    let formData = new FormData();
    formData.append('profile-name', document.getElementById('profile-name').value);
    
    // Check if a new background image is selected
    let backgroundImageFile = document.getElementById('upload-background-picture').files[0];
    if (backgroundImageFile) {
        formData.append('upload-background-picture', backgroundImageFile);
    }
    
    // Check if a new profile image is selected
    let profilePhotoFile = document.getElementById('upload-profile-header').files[0];
    if (profilePhotoFile) {
        formData.append('upload-profile-header', profilePhotoFile);
    }

    // Create a new XMLHttpRequest to send the form data
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "db_connection/update_profile.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Optional: Handle successful response
            alert("Profile updated successfully!");
            location.reload(); // Reload to see the updates
        } else {
            // Optional: Handle error response
            alert("Failed to update profile. Please try again.");
        }
    };
    xhr.send(formData);
};

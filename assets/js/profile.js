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

// Open modal function
function openModal(imageId) {
    var modal = document.getElementById("image-modal");
    var modalImg = document.getElementById("modal-image");
    var img = document.getElementById(imageId);
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = img.alt;
}

// Close modal function
function closeModal() {
    var modal = document.getElementById("image-modal");
    modal.style.display = "none";
}

function likeButton(button) {
    const postId = button.getAttribute('data-post-id');

    // AJAX call to like/unlike the post
    $.ajax({
        url: 'db_connection/like_post.php',
        type: 'POST',
        data: { post_id: postId },
        success: function(response) {
            const res = JSON.parse(response);
            const likeCountSpan = button.querySelector('span');
            const currentLikeCount = parseInt(likeCountSpan.innerText);

            if (res.status === 'liked') {
                // Like the post
                likeCountSpan.innerText = currentLikeCount + 1;
                button.classList.add('liked');
                button.querySelector('i').style.color = 'red'; // Change to red when liked
            } else if (res.status === 'unliked') {
                // Unlike the post
                likeCountSpan.innerText = currentLikeCount - 1;
                button.classList.remove('liked');
                button.querySelector('i').style.color = ''; // Reset to original color
            }
        }
    });
}

// Show/Hide the comment box when the comment button is clicked
function toggleCommentBox(postId) {
    var commentBox = document.getElementById("comment-box-" + postId);
    
    // Check the current display state and toggle
    if (commentBox.style.display === "none") {
        commentBox.style.display = "block";  // Show comment box
    } else {
        commentBox.style.display = "none";   // Hide comment box
    }
}

function toggleCommentList(postId) {
    const commentList = document.getElementById(`comment-list-${postId}`);
    const viewCommentsText = document.getElementById(`view-comments-text-${postId}`);
    const arrowIcon = document.getElementById(`arrow-icon-${postId}`);

    // Check if the comment list is currently hidden or visible
    if (commentList.style.display === "none") {
        commentList.style.display = "block"; // Show the comment list
        viewCommentsText.innerText = "Hide Comments"; // Change button text
        arrowIcon.classList.remove("fa-chevron-down"); // Change arrow direction
        arrowIcon.classList.add("fa-chevron-up");
    } else {
        commentList.style.display = "none"; // Hide the comment list
        viewCommentsText.innerText = "View Comments"; // Change button text
        arrowIcon.classList.remove("fa-chevron-up"); // Change arrow direction back
        arrowIcon.classList.add("fa-chevron-down");
    }
}

// Submit the comment using AJAX
function submitComment(postId) {
    const commentInput = document.getElementById(`comment-input-${postId}`);
    const commentText = commentInput.value.trim(); // Get the comment text

    if (commentText) {
        // AJAX call to add the comment
        $.ajax({
            url: 'db_connection/comment_post.php',
            type: 'POST',
            data: { post_id: postId, comment: commentText },
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response.success) {
                    // Hide the "No comments yet" message
                    $(`#no-comments-message-${postId}`).hide();

                    // Prepare the new comment HTML
                    const newCommentHtml = `
                        <div class="comment-bar" id="comment-${response.comment_id}">
                            <div class="comment-header">
                                <img src="assets/images/profile/${response.profile_image}" class="comment-profile-photo">
                                <span class="comment-name">${response.user_name}</span>
                                <span class="comment-date">${response.comment_date}</span>
                            </div>
                            <div class="comment-content">
                                <p>${response.comment}</p>
                            </div>
                        </div>
                    `;

                    // Append the new comment to the comment list
                    $(`#comment-list-${postId}`).append(newCommentHtml);

                    // Clear the comment input field
                    commentInput.value = '';

                    // Update the comment count
                    const commentCountSpan = $(`#comment-button-${postId} span`);
                    commentCountSpan.text(parseInt(commentCountSpan.text()) + 1);
                } else {
                    alert("Failed to add comment: " + response.error); // Show error if available
                }
            },
            error: function(xhr, status, error) {
                alert("AJAX error: " + error); // Handle AJAX errors
            }
        });
    } else {
        alert("Comment cannot be empty.");
    }
}

function deleteComment(commentId) {
    $.ajax({
        url: 'db_connection/delete_comment.php',
        type: 'POST',
        data: { comment_id: commentId },
        dataType: 'json', // Expect a JSON response
        success: function(response) {
            if (response.success) {
                // Remove the comment from the DOM
                $(`#comment-${commentId}`).remove();

                // Optionally update the comment count displayed
                const postId = response.post_id; // Ensure you return post_id in response
                const commentCountSpan = $(`#comment-button-${postId} span`);
                commentCountSpan.text(parseInt(commentCountSpan.text()) - 1);
            } else {
                alert("Failed to delete comment: " + response.error); // Show error if available
            }
        },
        error: function(xhr, status, error) {
            alert("AJAX error: " + error); // Handle AJAX errors
        }
    });
}

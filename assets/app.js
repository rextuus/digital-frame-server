/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import Sha1 from 'js-sha1';


// public/js/image_upload_preview.js

// Function to handle the image preview
function handleImagePreview(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Selected Image" style="">`;
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// Event listener to trigger the image preview when a file is selected
const imageFileInput = document.querySelector('.custom-file-input');
if (imageFileInput) {
    imageFileInput.addEventListener('change', function () {
        handleImagePreview(this);
    });
}
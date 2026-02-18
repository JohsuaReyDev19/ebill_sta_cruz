let step = document.getElementsByClassName('step');
let form = document.getElementsByTagName('form')[0];
let preloader = document.getElementById('preloader-wrapper');
let bodyElement = document.querySelector('body');
let succcessDiv = document.getElementById('success');

form.onsubmit = () => { return false }

let current_step = 0;
let stepCount = 1
step[current_step].classList.add('d-block');

const showWarningMessage = (message) => {
    Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: message
    });
};

const loginForm = document.getElementById('form-wrapper');
const loginBtn = document.getElementById('login-btn');

loginForm.addEventListener('submit', (event) => {
    event.preventDefault();

    // Check if any required field in the form is empty
    const requiredFields = loginForm.querySelectorAll('[required]');
    let fieldsAreValid = true; // Initialize as true
    requiredFields.forEach(field => {
        if (field.value.trim() === '') {
            fieldsAreValid = false; // Set to false if any required field is empty
            field.style.border = '1px solid red'; // Add red border to missing field
        } else {
            field.style.border = ''; // Remove red border if field is filled
        }
    });

    // Proceed with AJAX request if all required fields are filled
    if (fieldsAreValid) {
        // Show preloader
        preloader.classList.add('d-block');

        // Perform AJAX request
        const formData = new FormData(loginForm);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './action/login_action.php', true);
        xhr.onload = function () {
            preloader.classList.remove('d-block');

            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    const role = parseInt(response.role); // ensure numeric

                    if (role === 1 || role === 2) {
                        // Admin and staff both go to admin dashboard
                        window.location.href = './admin/index.php?title=Dashboard';
                    } else {
                        showWarningMessage('Unknown role: ' + role);
                    }
                } else {
                    showWarningMessage(response.message || 'Invalid credentials.');
                }
            } else {
                showWarningMessage('Failed to submit the form. Please try again later.');
                console.error(xhr.responseText);
            }
        };

        xhr.onerror = function () {
            // If AJAX request fails, show SweetAlert error message
            showWarningMessage('Failed to submit the form. Please try again later.');
            console.error(xhr.statusText);

            // Hide preloader in case of error
            preloader.classList.remove('d-block');
        };
        xhr.send(formData);
    } else {
        // If any required field is empty, show SweetAlert error message
        showWarningMessage('Please fill out all required fields.');
    }
});


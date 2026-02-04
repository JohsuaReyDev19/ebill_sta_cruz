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
            // Hide preloader after AJAX request completes
            preloader.classList.remove('d-block');

            if (xhr.status >= 200 && xhr.status < 300) {
                // If AJAX request is successful and response indicates success, redirect or perform necessary actions
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Show preloader for a brief period before redirecting
                    preloader.classList.add('d-block');

                    setTimeout(() => {
                        // Redirect based on session role after a brief delay
                        const role = parseInt(response.role);
                        // Redirect based on user role
                        if (role === 1) {
                            window.location.href = './admin/index.php'; // Redirect to admin dashboard
                        } else if (role === 2) {
                            window.location.href = './staff/index.php'; // Redirect to staff dashboard
                        } else {
                            showWarningMessage('Invalid user role type.'); // Show error for unknown role
                        }
                    }, 1000); // Adjust the delay time as needed (in milliseconds)
                }
                 else {
                    // If AJAX request is successful but response indicates error, show SweetAlert error message
                    showWarningMessage(response.message || 'Invalid student/employee number or password. Please try again.');
                }
            } else {
                // If AJAX request fails, show SweetAlert error message
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


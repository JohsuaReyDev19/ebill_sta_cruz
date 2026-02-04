const progress = (value) => {
    document.querySelector('.progress-bar').style.width = `${value}%`;
};

let step = document.getElementsByClassName('step');
let prevBtn = document.getElementById('prev-btn');
let nextBtn = document.getElementById('next-btn');
let submitBtn = document.getElementById('submit-btn');
let form = document.getElementById('form-wrapper');
let preloader = document.getElementById('preloader-wrapper');
let successDiv = document.getElementById('success');
let aoaa = document.getElementById('aoaa');

form.onsubmit = () => { return false; };

let current_step = 0;
let stepCount = 3; // 3 steps
step[current_step].classList.add('d-block');
if (current_step === 0) {
    prevBtn.classList.add('d-none');
    submitBtn.classList.add('d-none');
    nextBtn.classList.add('d-inline-block');
}

// SweetAlert2 warning popup
const showWarningMessage = (message) => {
    Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: message
    });
};

// ==============================
// Next Button
// ==============================
nextBtn.addEventListener('click', () => {
    const currentStepFields = step[current_step].querySelectorAll('[required]');
    let fieldsAreValid = true;

    currentStepFields.forEach(field => {
        if ((field.type === "checkbox" && !field.checked) || 
            (field.type !== "checkbox" && field.value.trim() === '')) {
            fieldsAreValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });

    if (!fieldsAreValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Please fill out all required fields.'
        });
        return;
    }

    // STEP 2: validate username & email uniqueness
    if (current_step === 1) {
        const usernameField = document.querySelector('input[name="username"]');
        const emailField = document.querySelector('input[name="email"]');
        const passwordField = document.querySelector('input[name="password"]');
        const confirmPasswordField = document.querySelector('input[name="confirm_password"]');

        const username = usernameField.value.trim();
        const email = emailField.value.trim();
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (!email.includes('@')) {
            showWarningMessage('Please enter a valid email address.');
            emailField.classList.add('is-invalid');
            return;
        } else {
            emailField.classList.remove('is-invalid');
            emailField.classList.add('is-valid');
        }

        if (password !== confirmPassword) {
            showWarningMessage("Passwords don't match. Please check and try again.");
            passwordField.classList.add('is-invalid');
            confirmPasswordField.classList.add('is-invalid');
            return;
        } else {
            passwordField.classList.remove('is-invalid');
            confirmPasswordField.classList.remove('is-invalid');
            passwordField.classList.add('is-valid');
            confirmPasswordField.classList.add('is-valid');
        }

        // AJAX check for username/email uniqueness
        $.ajax({
            url: './action/check_user.php',
            type: 'POST',
            dataType: 'json',
            data: { username: username, email: email },
            success: function (data) {
                if (data.usernameExists) {
                    showWarningMessage("Username already exists. Please choose another.");
                    usernameField.classList.add('is-invalid');
                    return;
                }
                if (data.emailExists) {
                    showWarningMessage("Email already exists. Please use another.");
                    emailField.classList.add('is-invalid');
                    return;
                }
                // Passed → go to step 3
                goToNextStep();
            },
            error: function () {
                showWarningMessage("Failed to validate username/email. Please try again later.");
            }
        });
    } else {
        goToNextStep();
    }
});

// ==============================
// Go to next step
// ==============================
function goToNextStep() {
    current_step++;
    let previous_step = current_step - 1;

    if (current_step < step.length) {
        prevBtn.classList.remove('d-none');
        step[current_step].classList.remove('d-none');
        step[current_step].classList.add('d-block');
        step[previous_step].classList.remove('d-block');
        step[previous_step].classList.add('d-none');
    }

    if (current_step === stepCount - 1) {
        submitBtn.classList.remove('d-none');
        nextBtn.classList.add('d-none');
    }

    progress(Math.round((100 / stepCount) * (current_step + 1)));
}

// ==============================
// Go to previous step
// ==============================
prevBtn.addEventListener('click', () => {
    if (current_step > 0) {
        current_step--;
        let previous_step = current_step + 1;

        step[current_step].classList.remove('d-none');
        step[current_step].classList.add('d-block');
        step[previous_step].classList.remove('d-block');
        step[previous_step].classList.add('d-none');
    }

    if (current_step === 0) {
        prevBtn.classList.add('d-none');
    }

    submitBtn.classList.add('d-none');
    nextBtn.classList.remove('d-none');
    progress(Math.round((100 / stepCount) * (current_step + 1)));
});

// ==============================
// Submit
// ==============================
$('#submit-btn').on('click', function (event) {
    event.preventDefault();

    // Final check: all required fields + checkbox in step 3
    const requiredFields = $('#form-wrapper [required]');
    let fieldsAreValid = true;

    requiredFields.each(function () {
        if ($(this).attr('type') === 'checkbox') {
            if (!$(this).is(':checked')) {
                fieldsAreValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        } else if ($(this).val().trim() === '') {
            fieldsAreValid = false;
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    if (!fieldsAreValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Please fill out all required fields and confirm the declaration.'
        });
        return; // stop submission
    }

    var formData = new FormData($('#form-wrapper')[0]);

    $.ajax({
        url: './action/register_action.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'  // ensure JSON parsing
    })
    .then(function (data) {
        if (data.status === 'success') {
            $('#preloader-wrapper').addClass('d-block');
            return new Promise(resolve => setTimeout(resolve, 2000));
        } else {
            return Promise.reject(data.message || 'Failed to submit the form.');
        }
    })
    .then(function () {
        $('body').addClass('loaded');
        $('.step').removeClass('d-block').addClass('d-none');
        $('#prev-btn, #submit-btn').addClass('d-none');
        $('#success').removeClass('d-none').addClass('d-block');
        $('#aoaa').addClass('d-none');
    })
    .catch(function (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error
        });
        console.error(error);
    });
});

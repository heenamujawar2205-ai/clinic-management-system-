// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Phone validation
function validatePhone(phone) {
    const re = /^[0-9]{10}$/;
    return re.test(phone);
}

// Password validation
function validatePassword(password) {
    return password.length >= 6;
}

// Form validation for registration
function validateRegistration() {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const dob = document.getElementById('dob').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    clearErrors();

    let isValid = true;

    if (firstName === '') {
        showError('first_name', 'First name is required');
        isValid = false;
    }

    if (lastName === '') {
        showError('last_name', 'Last name is required');
        isValid = false;
    }

    if (email === '') {
        showError('email', 'Email is required');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('email', 'Invalid email format');
        isValid = false;
    }

    if (phone === '') {
        showError('phone', 'Phone number is required');
        isValid = false;
    } else if (!validatePhone(phone)) {
        showError('phone', 'Phone number must be 10 digits');
        isValid = false;
    }

    if (dob === '') {
        showError('dob', 'Date of birth is required');
        isValid = false;
    }

    if (password === '') {
        showError('password', 'Password is required');
        isValid = false;
    } else if (!validatePassword(password)) {
        showError('password', 'Password must be at least 6 characters');
        isValid = false;
    }

    if (confirmPassword === '') {
        showError('confirm_password', 'Please confirm password');
        isValid = false;
    } else if (password !== confirmPassword) {
        showError('confirm_password', 'Passwords do not match');
        isValid = false;
    }

    return isValid;
}

// Form validation for login
function validateLogin() {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    clearErrors();

    let isValid = true;

    if (email === '') {
        showError('email', 'Email is required');
        isValid = false;
    } else if (!validateEmail(email)) {
        showError('email', 'Invalid email format');
        isValid = false;
    }

    if (password === '') {
        showError('password', 'Password is required');
        isValid = false;
    }

    return isValid;
}

// Form validation for appointment booking
function validateAppointment() {
    const doctor = document.getElementById('doctor').value;
    const date = document.getElementById('appointment_date').value;
    const time = document.getElementById('appointment_time').value;
    const reason = document.getElementById('reason').value.trim();

    clearErrors();

    let isValid = true;

    if (doctor === '') {
        showError('doctor', 'Please select a doctor');
        isValid = false;
    }

    if (date === '') {
        showError('appointment_date', 'Please select a date');
        isValid = false;
    }

    if (time === '') {
        showError('appointment_time', 'Please select a time');
        isValid = false;
    }

    if (reason === '') {
        showError('reason', 'Please enter reason for visit');
        isValid = false;
    }

    return isValid;
}

// Show error message
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
    }
}

// Clear all errors
function clearErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(el => el.remove());
    const invalidFields = document.querySelectorAll('.is-invalid');
    invalidFields.forEach(field => field.classList.remove('is-invalid'));
}
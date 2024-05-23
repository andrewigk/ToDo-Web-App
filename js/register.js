// grab entire form
const form = document.getElementById("registerForm");

// grab each form input
const emailInput = document.getElementById("email");
const loginInput = document.getElementById("login");
const passwordInput = document.getElementById("pass");
const passwordReInput = document.getElementById("pass2");
const termsInput = document.getElementById("terms");

// grab array of all text inputs and all check inputs
const formTextInputs = document.querySelectorAll(".textfield");
const formCheckInputs = document.querySelectorAll(".checkbox");

// create error message element for each input and insert it into DOM
let emailError = document.createElement("p");
emailError.setAttribute("class", "warning");
formTextInputs[0].append(emailError);

let loginError = document.createElement("p");
loginError.setAttribute("class", "warning");
formTextInputs[1].append(loginError);

let passwordError = document.createElement("p");
passwordError.setAttribute("class", "warning");
formTextInputs[2].append(passwordError);

let passwordReError = document.createElement("p");
passwordReError.setAttribute("class", "warning");
formTextInputs[3].append(passwordReError);

let termsError = document.createElement("p");
termsError.setAttribute("class", "warning");
formCheckInputs[0].append(termsError);

// Default error message is blank
const defaultErrorMessage = "";

// Add event listeners to all inputs so they constantly update
emailInput.addEventListener("input", validateEmail);
loginInput.addEventListener("input", validateLogin);
passwordInput.addEventListener("input", validatePassword);
passwordReInput.addEventListener("input", validatePasswordRe);
termsInput.addEventListener("change", validateTerms);

function validate() {
    
    let validated = true;

    if (validateEmail() !== defaultErrorMessage) {
        validated = false;
    }

    if (validateLogin() !== defaultErrorMessage) {
        validated = false;
    }

    if (validatePassword() !== defaultErrorMessage) {
        validated = false;
    }

    if (validatePasswordRe() !== defaultErrorMessage) {
        validated = false;
    }

    if (validateTerms() !== defaultErrorMessage) {
        validated = false;
    }

    return validated;
}


function validateEmail() {
    let email = emailInput.value;
    let emailFormat = /\S+@\S+\.\S+/;
    let error;


    if (emailFormat.test(email)) {
        error = defaultErrorMessage;
    } else {
        error = "Please enter a valid email address.";
    }

    emailError.textContent = error;
    return error;
}

function validateLogin() {
    let login = loginInput.value;
    let error;

    if (login.length >= 30) {
        error = "Login must be less than 30 characters."
    } else if(login === "") {
        error = "Login must not be empty."
    } else {
        error = defaultErrorMessage;
    }

    loginError.textContent = error;
    return error;
}

function validatePassword() {
    let password = passwordInput.value;
    let error;

    if (password === "") {
        error = "Password must not be empty."
    } else if (password.length < 8) {
        error = "Password must be 8 characters."
    } else {
        error = defaultErrorMessage;
    }

    passwordError.textContent = error;
    return error;
}

function validatePasswordRe() {
    let password = passwordInput.value;
    let passwordRe = passwordReInput.value;
    let error;

    if (passwordRe === "") {
        error = "Password must not be empty."
    } else if (passwordRe.length < 8) {
        error = "Password must be 8 characters."
    } else if (password !== passwordRe) {
        error = "Passwords do not match."
    } else {
        error = defaultErrorMessage;
    }

    passwordReError.textContent = error;
    return error;
}

function validateTerms() {
    let error;

    if (termsInput.checked) {
        error = defaultErrorMessage;
    } else {
        error = "You must agree to the terms and conditions."
    }

    termsError.textContent = error;
    return error;
}

function resetErrors() {
    emailError.textContent = defaultErrorMessage;
    loginError.textContent = defaultErrorMessage;
    passwordError.textContent = defaultErrorMessage;
    passwordReError.textContent = defaultErrorMessage;
    termsError.textContent = defaultErrorMessage;
}
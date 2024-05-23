// grab entire form
const form = document.getElementById("registerForm");

// grab each form input
const loginInput = document.getElementById("login");
const passwordInput = document.getElementById("pass");

// create error message element for each input and insert it into DOM
const formTextInputs = document.querySelectorAll(".textfield");

let loginError = document.createElement("p");
loginError.setAttribute("class", "warning");
formTextInputs[0].append(loginError);

let passwordError = document.createElement("p");
passwordError.setAttribute("class", "warning");
formTextInputs[1].append(passwordError);


// Default error message is blank
const defaultErrorMessage = "";

// Add event listeners to all inputs so they constantly update

loginInput.addEventListener("input", validateLogin);
passwordInput.addEventListener("input", validatePassword);

function validate() {
    let validated = true;

    if (validateLogin() !== defaultErrorMessage) {
        validated = false;
    }

    if (validatePassword() !== defaultErrorMessage) {
        validated = false;
    }

    return validated;
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

function resetErrors() {
    loginError.textContent = defaultErrorMessage;
    passwordError.textContent = defaultErrorMessage;
}
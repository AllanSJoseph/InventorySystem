
const userNameField = document.getElementById('username');
const passwordField = document.getElementById('password');
const confPassField = document.getElementById('confpassword');
const emailField = document.getElementById('email');
const phoneField = document.getElementById('phone');
const addressField = document.getElementById('address');
const typeField = document.getElementById('type');

const submit = document.getElementById('submit');

//Regular Expressions
var lowerCase = /[a-z]/g;
var upperCase = /[A-Z]/g;
var number = /[0-9]/g;
var specialChar = /[!@#$%^&*(),.?":{}|<>]/g;

function validate(){
    let name = userNameField.value;
    let password = passwordField.value;
    let confpassword = confPassField.value;
    let email = emailField.value;
    let phone = phoneField.value;
    let address = addressField.value;
    let type = typeField;

    if (name === '' || email === '' || phone === '' || address === '' || password === '' || confpassword === '' || type === '') {
        alert('Please fill in all fields.');
        return false;
    }

    if (password !== confpassword) {
        alert('Passwords do not match.');
        return false;
    }

    return true;
}




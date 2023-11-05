//add function on eye to show the password
const eye = document.querySelector('.fa-eye');

eye.addEventListener('mousedown', ()=> {
    const password = document.querySelector('input[name="password"]')
    password.type = "text";
})

eye.addEventListener('mouseup', ()=> {
    const password = document.querySelector('input[name="password"]')
    password.type = "password";
})




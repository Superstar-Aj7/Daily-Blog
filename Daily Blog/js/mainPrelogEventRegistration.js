let email = document.getElementById("email_2");
let password = document.getElementById("pwd");
let mainPrelogForm = document.getElementById("login-form");


email.addEventListener("blur",emailHandler2);
password.addEventListener("blur",pwdHandler2);
mainPrelogForm.addEventListener("submit",mainPrelogValidator);
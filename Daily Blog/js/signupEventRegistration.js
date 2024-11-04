let email = document.getElementById("email");
email.addEventListener("blur",emailHandler);

let uname = document.getElementById("username");
uname.addEventListener("blur", unameHandler);

let dob = document.getElementById("dob");
dob.addEventListener("blur", dobHandler);

let pwd = document.getElementById("password");
pwd.addEventListener("input", pwdHandler);

let cpwd = document.getElementById("confirm-password");
cpwd.addEventListener("input", cpwdHandler);

let pfp = document.getElementById("profile-photo");
pfp.addEventListener("change", pfpHandler);

let submit = document.getElementById("signup-form");
submit.addEventListener("submit", signupValidator);
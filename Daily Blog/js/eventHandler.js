function validateEmail(email){
    let regEx =/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
   
    if(regEx.test(email) == true){
        return true;
    }
    else{
        return false;
    }
 }

 function validateUname(uname){
    let regEx = /^[a-zA-Z0-9_]+$/;

    if(regEx.test(uname) == true){
        return true;
    }
    else{
        return false;
    }
 }

 function validateDob(dob){
    let regEx =  /^\d{4}[-]\d{2}[-]\d{2}$/;
    
    if(regEx.test(dob) == true){
        return true;
    }
    else{
        return false;
    }
 }

function validatepwd(pwd){
    let regEx = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z])[a-zA-Z0-9!@#$%^&*]{6}$/;

    if(regEx.test(pwd) == true){
        return true;
    }
    else{
        return false;
    }

}

 function validatePfp(pfp){
    let regEx = /^[^\n]+\.[a-zA-Z]{3,4}$/
    
    if(regEx.test(pfp) == true){
        return true;
    } 
    else{
        return false;
    }
 }

 function emailHandler(event){
    let email = event.target.value;
    let errorTextMessageEmail = document.getElementById("error-text-email");
    let emailBox = document.getElementById("email");
    
    if(!validateEmail(email)){
        emailBox.classList.add("invalid");
        errorTextMessageEmail.classList.remove("hidden");
    }
    else{
        emailBox.classList.remove("invalid");
        errorTextMessageEmail.classList.add("hidden");
       
    }
 }

 function unameHandler(event){
    let uname = event.target.value;
    let errorTextMessageUname = document.getElementById("error-text-username");
    let unameBox = document.getElementById("username");
    
    if(!validateUname(uname)){
        unameBox.classList.add("invalid");
        errorTextMessageUname.classList.remove("hidden");
    }
    else{
        unameBox.classList.remove("invalid");
        errorTextMessageUname.classList.add("hidden");
       
    }
 }
 function dobHandler(event){
    let dob = event.target.value;
    let errorTextMessageDob = document.getElementById("error-text-dob");
    let dobBox = document.getElementById("dob");
    
    if(!validateDob(dob)){
        dobBox.classList.add("invalid");
        errorTextMessageDob.classList.remove("hidden");
    }
    else{
        dobBox.classList.remove("invalid");
        errorTextMessageDob.classList.add("hidden");
       
    }
 }

 function pwdHandler(event){
    let pwd = event.target.value;
    let errorTextMessagePwd = document.getElementById("error-text-pwd");
    let pwdBox = document.getElementById("password");
   
    if(!validatepwd(pwd)){
        pwdBox.classList.add("invalid");
        errorTextMessagePwd.classList.remove("hidden");
    }
    else{
        pwdBox.classList.remove("invalid");
        errorTextMessagePwd.classList.add("hidden");
       
    }
 }

 function cpwdHandler(event){
    let cpwd = event.target.value;
    let pwd = document.getElementById("password").value
    let errorTextMessageCpwd = document.getElementById("error-text-cpwd");
    let cpwdBox = document.getElementById("confirm-password");
   
    if(cpwd != pwd){
        cpwdBox.classList.add("invalid");
        errorTextMessageCpwd.classList.remove("hidden");
    }
    else{
        cpwdBox.classList.remove("invalid");
        errorTextMessageCpwd.classList.add("hidden");
    }
 }

 
 function pfpHandler(event){
    let pfp = event.target.value;
    let errorTextMessagePfp = document.getElementById("error-text-pfp");
    let pfpBox = document.getElementById("profile-photo");
   
    if(!validatePfp(pfp)){
        pfpBox.classList.add("invalid");
        errorTextMessagePfp.classList.remove("hidden");
    }
    else{
        pfpBox.classList.remove("invalid");
        errorTextMessagePfp.classList.add("hidden");
    }
 }


 function signupValidator(event){

    let email = document.getElementById("email").value;
    let uname = document.getElementById("username").value;
    let dob = document.getElementById("dob").value;
    let pwd = document.getElementById("password").value;
    let cpwd = document.getElementById("confirm-password").value;
    let pfp = document.getElementById("profile-photo").value;
    let formIsValid = true;

    if(!validateEmail(email)){
        formIsValid = false;
    }
    if(!validateUname(uname)){
        formIsValid = false;
    }
    if(!validateDob(dob)){
        formIsValid = false;
    }
    if(!validatepwd(pwd)){
        formIsValid = false;
    }
    if(cpwd!= pwd){
        formIsValid = false;
    }
    if(!validatePfp(pfp)){
        formIsValid = false;
    }

    if(formIsValid === false){
       event.preventDefault();
    }
    
 }
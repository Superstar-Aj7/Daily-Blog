
/*RegEx  and other validator functions*/
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
    let regEx =  /^(?=.*[^a-zA-Z])[^\s]{6,20}$/;

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

  function isEmpty(field){
    if(field == 0){
     return true;    
    }
    else{
        return false;
    }

  }

 /*Signup event handler functions*/
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
    let pwd = document.getElementById("password").value;
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

// sign Up submition event handler.
 function signupValidator(event){

    let email = document.getElementById("email").value;
    let uname = document.getElementById("username").value;
    let dob = document.getElementById("dob").value;
    let pwd = document.getElementById("password").value;
    let cpwd = document.getElementById("confirm-password").value;
    let pfp = document.getElementById("profile-photo").value;
    let errorMessageEmail = document.getElementById("error-text-email")
    let errorMessageUname = document.getElementById("error-text-username")
    let errorMessageDob = document.getElementById("error-text-dob")
    let errorMessagePwd = document.getElementById("error-text-pwd")
    let errorMessageCpwd = document.getElementById("error-text-cpwd")
    let errorMessagePfp = document.getElementById("error-text-pfp")
    let formIsValid = true;


    if(!validateEmail(email)){
        formIsValid = false;
        errorMessageEmail.classList.remove("hidden");
    }
    else{
        errorMessageEmail.classList.add("hidden");
    }
    if(!validateUname(uname)){
        formIsValid = false;
        errorMessageUname.classList.remove("hidden");
    } 
    else{
        errorMessageUname.classList.add("hidden");
    }
    if(!validateDob(dob)){
        formIsValid = false;
        errorMessageDob.classList.remove("hidden");
    }
    else{
        errorMessageDob.classList.add("hidden");
    }
    if(!validatepwd(pwd)){
        formIsValid = false;
        errorMessagePwd.classList.remove("hidden");
    } 
    else{
        errorMessagePwd.classList.add("hidden");
    }
    if(cpwd!= pwd || cpwd==""){
        formIsValid = false;
        errorMessageCpwd.classList.remove("hidden");
    }
    else{
        errorMessageCpwd.classList.add("hidden");
    }
    if(!validatePfp(pfp)){
        formIsValid = false;
        errorMessagePfp.classList.remove("hidden");
    }
    else{
        errorMessagePfp.classList.add("hidden");
    }
    if(formIsValid === false){
       event.preventDefault();
    }
    
 }


//form validation for addcontent page
function textAreaHandler(event){
    let field = event.target.value;
    let errorMessage = document.getElementById("error-text-addcontent");

    if(isEmpty(field)){
        errorMessage.classList.remove("hidden");
    }
    else{
        errorMessage.classList.add("hidden");
    }
}

function addcontentValidator(event){
    let textArea = document.getElementById("textArea").value;
    let errorMessage = document.getElementById("error-text-addcontent");
     let formIsValid = true;

    if(isEmpty(textArea)){
        formIsValid = false;
        errorMessage.classList.remove("hidden");
        
    } else{
        formIsValid = true;
        errorMessage.classList.add("hidden");
    }


    if(formIsValid == false){
        event.preventDefault();
    }
}
//form validation for blogDetails page.
function textAreaHandler2(event){
    let field = event.target.value;
    let errorMessage = document.getElementById("error-text-area2");

    if(isEmpty(field)){
        errorMessage.classList.remove("hidden");
    }
    else{
        errorMessage.classList.add("hidden");
    }
}

function blogDetailsValidator(event){
    let textArea = document.getElementById("textArea_2").value;
    let errorMessage = document.getElementById("error-text-area2");
     let formIsValid = true;

    if(isEmpty(textArea)){
        formIsValid = false;
        errorMessage.classList.remove("hidden");

        
    } else{
        errorMessage.classList.add("hidden");
        formIsValid = true;
    }


    if(formIsValid == false){
        event.preventDefault();
    }
}


 // Dynamic character counter function for both addContent and blogDetails pages.
 function counter(event, maxLimit, countId, errorMessageId) {
    const textArea = event.target;
    const count = document.getElementById(countId);
    const errorMessage = document.getElementById(errorMessageId);

    const currentLength = textArea.value.length;

    count.innerHTML = currentLength;

    if (currentLength > maxLimit) {
        count.style.color = "red"; 
        errorMessage.classList.remove("hidden");
    } 
    else {
        count.style.color = "black"; 
        errorMessage.classList.add("hidden");
    }
}

   

   
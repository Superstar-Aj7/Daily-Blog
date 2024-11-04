const textArea2 = document.getElementById("textArea_2");
let blogDetailsForm = document.getElementById("blogdetails-form");
const maxCount = 1000;



textArea2.addEventListener("input", function (event) { counter(event, maxCount, "newCount", "newCount-error-message");});
textArea2.addEventListener("input",textAreaHandler2);
blogDetailsForm.addEventListener("submit",blogDetailsValidator);


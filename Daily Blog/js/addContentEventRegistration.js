const textArea = document.getElementById("textArea");
const addContentForm = document.getElementById("addcontent-form");
const maxCount = 2000;

textArea.addEventListener("input", function (event) { counter(event, maxCount, "count", "count-error-message");});
textArea.addEventListener("input", textAreaHandler);
addContentForm.addEventListener("submit", addcontentValidator);
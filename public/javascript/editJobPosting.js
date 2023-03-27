const jobPostingEditBtn = document.querySelector("#jobPostingEditBtn");
const jobPostingBackBtn = document.querySelector("#jobPostingBackBtn");
const jobPostingFinishBtn = document.querySelector("#jobPostingFinishBtn");
const jobPostingInfo = document.querySelector(".jobPostingInfo");
const wrapper = document.querySelector(".jobListingWrapper");
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const jobId = urlParams.get("ListingId");
const now = new Date();
const offsetMs = now.getTimezoneOffset() * 60 * 1000;
const dateLocal = new Date(now.getTime() - offsetMs);
const str = dateLocal.toISOString().slice(0, 19);
let edited = false;
console.log(jobId);
jobPostingEditBtn.addEventListener("click", editFields);
jobPostingFinishBtn.addEventListener("click", submitFields);
jobPostingBackBtn.addEventListener("click", goBack);
function submitFields() {
  if (edited) {
    let editableFields = document.querySelectorAll(".editableContext");

    let datetimepicker = document.querySelector("#datetimepicker");
    let form = new FormData();
    console.log("edit");
    form.append("description", editableFields[0].value);
    form.append("minSalary", editableFields[1].value);
    form.append("maxSalary", editableFields[2].value);
    form.append(
      "deadline",
      datetimepicker.value
        .replace(/-/g, "/")
        .replace("T", " ")
        .replaceAll("/", "-")
    );
    form.append("id", jobId);
    for (var pair of form.entries()) {
      console.log(pair[0] + " - " + pair[1]);
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./index.php?action=postJobChanges");
    xhr.onload = () => {
      wrapper.innerHTML = "";
      wrapper.innerHTML = xhr.response;
    };
    xhr.send(form);
  } else {
    goBack();
  }
}
function editFields() {
  if (!edited) {
    let editableFields = document.querySelectorAll(".editableContext");
    edited = true;
    editableFields.forEach((element) => {
      elementContent = element.innerText;
      if (element.tagName == "P") {
        editableElement = document.createElement("textarea");
        editableElement.textContent = elementContent;
      } else {
        editableElement = document.createElement("input");
      }
      if (element.id == "datetimepicker") {
        editableElement.setAttribute("type", "datetime-local");
        editableElement.value = str;
        editableElement.id = "datetimepicker";
      } else {
        editableElement.value = elementContent;
      }
      editableElement.classList = "editableContext";
      element.parentElement.replaceChild(editableElement, element);
    });
  }
}
function goBack() {
  window.location.replace("./index.php?action=jobListings");
}

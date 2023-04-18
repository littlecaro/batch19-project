function addNewUserExperience(e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("companyName", companyName.value);
  formData.append("jobTitle", jobTitle.value);
  formData.append("yearsExperience", yearsExperience.value);
  formData.append("userId", userIdExperience.value);

  console.log("company:", companyName.value);
  console.log("job:", jobTitle.value);
  console.log("experience", yearsExperience.value);
  console.log("userID:", userIdExperience.value);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", `http://localhost/sites/batch19-project/index.php?action=addNewUserExperience`);
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      window.location.href = "http://localhost/sites/batch19-project/index.php?action=userProfileView";
      // let response = xhr.responseText;
      // experienceUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}
addExperienceForm.addEventListener("submit", addNewUserExperience);

let formValidation = () => {
  if (input.value === "") {
    msg.innerHTML = "Post cannot be blank";
    console.log("failure");
  } else {
    console.log("successs");
    msg.innerHTML = "";
  }
};

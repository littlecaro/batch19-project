function updateUserExperience(e) {
  e.preventDefault();

  const formData = new FormData();
  // change name on userprofileexperiencecards to Update, not the same names on the userprofileexhcange form
  formData.append("companyName", e.target[0].value);
  formData.append("jobTitle", e.target[1].value);
  formData.append("yearsExperience", e.target[2].value);
  formData.append("userId", e.target[3].value);
  formData.append("jobID", e.target[4].value);

  console.log("company:", e.target[0].value);
  console.log("job:", e.target[1].value);
  console.log("experience:", e.target[2].value);
  console.log("userID:", e.target[3].value);
  console.log("jobID:", e.target[4].value);
  console.log(e); // to console log and find where the targets are
  //weren't sending the values into the database
  //weren't sending the id to update the specific jobcard

  console.log(e.target[0]); // find the target for the values respectively,
  //then add then in the e.target[#].value, above to check they are grabbing the correct values

  let xhr = new XMLHttpRequest();
  xhr.open("POST", `http://localhost/sites/batch19-project/index.php?action=updateUserExperience`);
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      window.location.href = "http://localhost/sites/batch19-project/index.php?action=userProfileView";
      let response = xhr.responseText;
      // experienceUpdateStatus.textContent = response;
      // console.log(response);
    }
  });
  xhr.send(formData);
}
const updateExperienceForms = document.getElementsByClassName("editExperience");
// console.log(updateExperienceForms); // show all the cards
for (let updateExperienceForm of updateExperienceForms) {
  // add a loop for every card you click
  updateExperienceForm.addEventListener("submit", updateUserExperience);
}

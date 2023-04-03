function deleteUserExperience(e) {
  e.preventDefault();

  const formData = new FormData();

  formData.append("jobID", e.target.value);

  console.log("jobID:", e.target.value);
  console.log(e);

  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `http://localhost/sites/batch19-project/index.php?action=deleteUserExperience`
  );
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      // window.location.href =
      //   "http://localhost/sites/batch19-project/index.php?action=userProfileView";
      let response = xhr.responseText;
      experienceUpdateStatus.textContent = response;
      console.log(response);
    }
  });
  xhr.send(formData);
}
const deleteExperiences = document.getElementsByClassName("deleteExpBtn");
console.log(deleteExperiences); // show all the cards
for (let deleteExperience of deleteExperiences) {
  console.log(deleteExperience);
  // for each entry of the array
  // add a loop for every card you click
  deleteExperience.addEventListener("click", deleteUserExperience);
}

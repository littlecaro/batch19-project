function updateUserExperience(e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("jobTitle", jobTitle.value);
  formData.append("yearsExperience", yearsExperience.value);
  formData.append("companyName", companyName.value);
  formData.append("userId", userIdExperience.value);

  console.log("job:", jobTitle.value);
  console.log("experience", yearsExperience.value);
  console.log("company:", companyName.value);
  console.log("userID:", userIdExperience.value);

  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `http://localhost/sites/batch19-project/index.php?action=updateUserExperience`
  );
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      let response = xhr.responseText;
      experienceUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}

experienceForm.addEventListener("submit", updateUserExperience);

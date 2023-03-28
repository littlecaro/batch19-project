function updateUserEducation(e) {
  e.preventDefault();

  // Moved this to HTML
  //   const degreeMap = {
  //     highschool: 0,
  //     associates: 2,
  //     undergraduate: 3,
  //     graduate: 4,
  //     phD: 5,
  //   };

  const formData = new FormData();
  formData.append("degreeLevel", degree.options[degree.selectedIndex].value);
  formData.append("degree", major.value);
  formData.append("userId", userIdEducation.value);

  console.log("major:", major.value);
  console.log("userId", userIdEducation.value);
  console.log("degree:", degree.options[degree.selectedIndex].value);

  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `http://localhost/sites/batch19-project/index.php?action=updateUserEducation`
  );
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      let response = xhr.responseText;
      educationUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}

educationForm.addEventListener("submit", updateUserEducation);

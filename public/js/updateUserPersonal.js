imageUpload.onchange = () => {
  const file = imageUpload.files[0];
  console.log(file);
  if (file) {
    imgPreview.src = URL.createObjectURL(file);
  }
};

if (cityName) {
  const selectedOption = document.querySelector(`option[value=${cityName}]`);
  selectedOption.setAttribute("selected", true);
}
function updateUserPersonal(e) {
  e.preventDefault();
  // console.log(city.options[city.selectedIndex].value);
  // console.log(cityName);
  const formData = new FormData();
  formData.append("id", id.value);
  formData.append("phoneNb", phoneNb.value);
  formData.append("city", city.options[city.selectedIndex].value); // TODO:
  formData.append("salary", salary.value);
  formData.append("oldImage", oldImage.value);
  if (typeof imageUpload.files[0] !== "undefined") {
    formData.append("profilePic", imageUpload.files[0], imageUpload.files[0]["name"]);
  }

  console.log("id", id.value);
  console.log("phoneNb", phoneNb.value);
  console.log("city", city.options[city.selectedIndex].value);
  console.log("salary", salary.value);
  console.log("oldImage", oldImage.value);
  if (typeof imageUpload.files[0] !== "undefined") {
    console.log("profilePic", imageUpload.files[0], imageUpload.files[0]["name"]);
  }

  var inputs = document.querySelectorAll('input[type="radio"]');
  // console.log(inputs);
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    if (input.checked) {
      // alert("Checked input is :" + inputs[i].value);
      formData.append("visa", inputs[i].value);
      break;
    }
    console.log(formData);
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", `http://localhost/sites/batch19-project/index.php?action=updateUserPersonal`);
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      window.location.href = "http://localhost/sites/batch19-project/index.php?action=userProfileView";
      let response = xhr.responseText;
      // console.log(response);
      // personalUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}
personalForm.addEventListener("submit", updateUserPersonal);

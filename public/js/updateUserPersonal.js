if (cityName) {
  const selectedOption = document.querySelector(`option[value=${cityName}]`);
  selectedOption.setAttribute("selected", true);
}
function updateUserPersonal(e) {
  e.preventDefault();
  // console.log(city.options[city.selectedIndex].value);
  // console.log(cityName);
  const formData = new FormData();
  formData.append("phoneNb", phoneNb.value);
  formData.append("city", city.options[city.selectedIndex].value); // TODO:
  formData.append("salary", salary.value);
  formData.append("id", id.value);
  const file = imageUpload.files[0];
  formData.append("imageUpload", file);
  console.log(imageUpload.files[0]);
  var inputs = document.querySelectorAll('input[type="radio"]');
  // console.log(inputs);
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    if (input.checked) {
      // alert("Checked input is :" + inputs[i].value);
      formData.append("visa", inputs[i].value);
      break;
    }
  }

  console.log(formData);
  let xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    `http://localhost/sites/batch19-project/index.php?action=updateUserPersonal`
  );
  xhr.addEventListener("readystatechange", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      window.location.href =
        "http://localhost/sites/batch19-project/index.php?action=userProfileView";
      let response = xhr.responseText;
      console.log(response);
      personalUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}
personalForm.addEventListener("submit", updateUserPersonal);

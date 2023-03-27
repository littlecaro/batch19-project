function updateUserPersonal(e) {
  e.preventDefault();
  console.log(city.options[city.selectedIndex].value);

  const formData = new FormData();
  formData.append("phoneNb", phoneNb.value);
  formData.append("city", city.options[city.selectedIndex].value); // TODO:
  formData.append("salary", salary.value);
  formData.append("id", id.value);
  var inputs = document.querySelectorAll('input[type="radio"]');
  console.log(inputs);
  for (var i = 0; i < inputs.length; i++) {
    var input = inputs[i];
    if (input.checked) {
      alert("Checked input is :" + inputs[i].value);
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
      let response = xhr.responseText;
      console.log(response);
      personalUpdateStatus.textContent = response;
    }
  });
  xhr.send(formData);
}
personalForm.addEventListener("submit", updateUserPersonal);

function myFunction(id) {
  const sections = document.querySelectorAll(".main > section");
  for (let section of sections) {
    section.classList.add("hidden");
  }

  var x = document.getElementById(id);
  x.classList.remove("hidden");
}

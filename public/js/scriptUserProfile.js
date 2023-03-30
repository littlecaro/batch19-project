function myFunction(id) {
  const sections = document.querySelectorAll(".main > section");
  for (let section of sections) {
    section.classList.add("hidden");
  }

  var x = document.getElementById(id);
  x.classList.remove("hidden");
}

// script for profile photo upload
profilePhoto.onchange = () => {
  const file = profilePhoto.files[0];
  console.log(file);
  if (file) {
    imgPreview.src = URL.createObjectURL(file);
  }
};

//script for resume upload
// resume.onchange = () => {
//   const resume1 = resume.files[0];
//   console.log(resume1);
//   if (resume1) {
//     imgPreview.src = URL.createObjectURL(file);
//   }
// };
let hasCalendarLoaded = false;
function showCalendarPage() {
  myFunction("avail");

  if (!hasCalendarLoaded) {
    loadCalendar();
    hasCalendarLoaded = true;
  }
  // loadCalendar();
}

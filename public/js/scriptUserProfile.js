function myFunction(id) {
  const sections = document.querySelectorAll(".main > section");
  for (let section of sections) {
    section.classList.add("hidden");
  }

  var x = document.getElementById(id);
  x.classList.remove("hidden");
}

let hasCalendarLoaded = false;
function showCalendarPage() {
  myFunction("avail");
  if (!hasCalendarLoaded) {
    loadCalendar();
    hasCalendarLoaded = true;
  }
}

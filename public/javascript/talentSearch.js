const searchBtn = document.querySelector("#editSearch");
const editSearchPopup = document.querySelector(".editSearch");
const saveSearchBtn = document.querySelector("#saveBtn");
const tagDivs = document.querySelectorAll(".simple-tags");
const searchTags = document.querySelector(".searchTags");
const cardContainer = document.querySelector(".talentSearchMain");
const cancelBtn = document.querySelector("#cancelBtn");
const cancelSearchBtn = document.querySelector("#cancelSearch");
cancelSearchBtn.addEventListener("click", (e) => {
  location.reload();
});
searchBtn.addEventListener("click", (e) => {
  editSearchPopup.classList.remove("hidden");
});
const searchForm = document.querySelector(".SearchFormInputsWrapper form");
searchForm.addEventListener("submit", (e) => {
  e.preventDefault();
});

function populateTags() {
  if (saveData) {
    let filterYearsMax = saveData["filteredYearsMax"];
    let filterYearsMin = saveData["filteredYearsMin"];
    console.log(filterYearsMin + " " + filterYearsMax);
    slider.noUiSlider.set([filterYearsMin, filterYearsMax]);
  }
}
//TODO: Code is horribly repetitive must fix someday
saveSearchBtn.addEventListener("click", saveSearchValues);
function loadPageSearch() {
  if (saveData) {
    let experienceValues =
      saveData["filterYearsMin"] + "," + saveData["filterYearsMax"];
    let desiredPositions = saveData["filteredDesiredPositions"];
    let languages = saveData["filteredLanguages"];
    let locations = saveData["filteredLocation"];
    let skills = saveData["filteredSkills"];
    let highestDegree = saveData["filteredHighestDegrees"];
    let form = new FormData();
    form.append("experience", experienceValues);
    form.append("desiredPositions", desiredPositions);
    form.append("languages", languages);
    form.append("locations", locations);
    form.append("skills", skills);
    form.append("highestDegree", highestDegree);
    console.log(highestDegree);
    let experienceTag = document.createElement("li");
    let desiredPositionsTag = document.createElement("li");
    let languagesTag = document.createElement("li");
    let locationsTag = document.createElement("li");
    let skillsTag = document.createElement("li");
    let highestDegreeTag = document.createElement("li");
    let tagWrapper = document.createElement("ul");
    let experienceMin = saveData.filteredYearsMin;
    let experienceMax = saveData.filteredYearsMax;

    experienceTag.textContent =
      "Years of Experience: " + experienceMin + " - " + experienceMax;
    desiredPositionsTag.textContent =
      "Location: " + form.get("desiredPositions");
    languagesTag.textContent = "Languages:" + form.get("languages");
    locationsTag.textContent = "Locations:" + form.get("locations");
    skillsTag.textContent = "Skills:" + form.get("skills");
    highestDegreeTag.textContent =
      "Highest Degree:" + form.get("highestDegree");
    tagWrapper.appendChild(experienceTag);
    tagWrapper.appendChild(highestDegreeTag);
    tagWrapper.appendChild(desiredPositionsTag);
    tagWrapper.appendChild(languagesTag);
    tagWrapper.appendChild(locationsTag);
    tagWrapper.appendChild(skillsTag);
    searchTags.innerHTML = "";
    searchTags.appendChild(tagWrapper);
  }
}
// function saveSearchValues() {}

function saveSearchValues() {
  console.log("testing");
  let experienceValues = slider.noUiSlider.get();
  let desiredPositions = tagDivs[0].getAttribute("data-simple-tags");
  let languages = tagDivs[1].getAttribute("data-simple-tags");
  let locations = tagDivs[2].getAttribute("data-simple-tags");
  let saveSearch = document.querySelector(".toggle-checkbox").checked;
  let skills = tagDivs[3].getAttribute("data-simple-tags");
  let highestDegree = tagDivs[4].getAttribute("data-simple-tags");
  let form = new FormData();
  form.append("experience", experienceValues);
  form.append("desiredPositions", desiredPositions);
  form.append("languages", languages);
  form.append("locations", locations);
  form.append("saveSearch", saveSearch);
  form.append("skills", skills);
  form.append("highestDegree", highestDegree);
  console.log(highestDegree);
  editSearchPopup.classList.add("hidden");
  let experienceTag = document.createElement("li");
  let desiredPositionsTag = document.createElement("li");
  let languagesTag = document.createElement("li");
  let locationsTag = document.createElement("li");
  let skillsTag = document.createElement("li");
  let highestDegreeTag = document.createElement("li");
  let tagWrapper = document.createElement("ul");
  let experienceMin = form.get("experience").split(",")[0];
  let experienceMax = form.get("experience").split(",")[1];

  experienceTag.textContent =
    "Years of Experience: " + experienceMin + " - " + experienceMax;
  desiredPositionsTag.textContent = "Location: " + form.get("desiredPositions");
  languagesTag.textContent = "Languages: " + form.get("languages");
  locationsTag.textContent = "Locations: " + form.get("locations");
  skillsTag.textContent = "Skills: " + form.get("skills");
  highestDegreeTag.textContent = "Highest Degree:" + form.get("highestDegree");

  tagWrapper.appendChild(experienceTag);
  tagWrapper.appendChild(highestDegreeTag);
  tagWrapper.appendChild(desiredPositionsTag);
  tagWrapper.appendChild(languagesTag);
  tagWrapper.appendChild(locationsTag);
  tagWrapper.appendChild(skillsTag);
  console.log(languages);
  searchTags.innerHTML = "";

  searchTags.appendChild(tagWrapper);
  console.log(skills);
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `index.php?action=talentSearchSave&filter=true&yearsMin=${experienceMin}&yearsMax=${experienceMax}&languages=${languages}&locations=${locations}&desiredp=${desiredPositions}&skills=${skills}&jobId=${jobId}&highestDegree=${highestDegree}`
  );
  xhr.onload = (e) => {
    searchTags.innerHTML = "";
    searchTags.appendChild(tagWrapper);
    cardContainer.innerHTML = "";
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xhr.responseText, "text/html");
    var tds = xmlDoc.getElementsByClassName("talentSearchMain");
    console.log(tds);

    cardContainer.innerHTML = tds[0].innerHTML;
  };
  xhr.send();
  return form;
}
function updateFormValues() {
  console.log("testing testing");
  console.log(saveData);
  let experienceValues =
    saveData["filterYearsMin"] + "," + saveData["filterYearsMax"];
  let desiredPositions = saveData["filteredDesiredPositions"];
  let languages = saveData["filteredLanguages"];
  let locations = saveData["filteredLocations"];
  let skills = saveData["filteredSkills"];
  let form = new FormData();
  form.append("experience", experienceValues);
  form.append("desiredPositions", desiredPositions);
  form.append("languages", languages);
  form.append("locations", locations);
  form.append("skills", skills);
  form.append("highestDegree", highestDegree);

  let experienceTag = document.createElement("li");
  let desiredPositionsTag = document.createElement("li");
  let languagesTag = document.createElement("li");
  let locationsTag = document.createElement("li");
  let skillsTag = document.createElement("li");
  let highestDegreeTag = document.createElement("li");
  let tagWrapper = document.createElement("ul");
  let experienceMin = saveData.filteredYearsMin;
  let experienceMax = saveData.filteredYearsMax;

  experienceTag.textContent =
    "Years of Experience: " + experienceMin + " - " + experienceMax;
  desiredPositionsTag.textContent = "Location: " + form.get("desiredPositions");
  languagesTag.textContent = "Languages: " + form.get("languages");
  locationsTag.textContent = "Locations: " + form.get("locations");
  skillsTag.textContent = "Skills: " + form.get("skills");
  highestDegreeTag.textContent = "Highest Degree:" + form.get("highestDegree");
  tagWrapper.appendChild(experienceTag);
  tagWrapper.appendChild(desiredPositionsTag);
  tagWrapper.appendChild(languagesTag);
  tagWrapper.appendChild(locationsTag);
  tagWrapper.appendChild(skillsTag);
  tagWrapper.appendChild(highestDegreeTag);
  searchTags.innerHTML = "";
  searchTags.appendChild(tagWrapper);
  editSearchPopup.classList.add("hidden");
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `index.php?action=talentSearchSave&yearsMin=${experienceMin}&yearsMax=${experienceMax}&languages=${languages}&locations=${locations}&desiredp=${desiredPositions}&skills=${skills}&jobId=${jobId}&highestDegree=${highestDegree}`
  );
  xhr.onload = (e) => {
    console.log();
    cardContainer.innerHTML = "";
    var parser = new DOMParser();
    var xmlDoc = parser.parseFromString(xhr.responseText, "text/html");
    var tds = xmlDoc.getElementsByClassName("talentSearchMain");
    console.log(tds);
    cardContainer.innerHTML = tds[0].innerHTML;
  };
  xhr.send(form);
}
cancelBtn.addEventListener("click", () => {
  editSearchPopup.classList.add("hidden");
});
// getFormValues();
// updateFormValues();
// saveSearchValues();
loadPageSearch();
populateTags();

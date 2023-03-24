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
//TODO: Exclude company users from canditates
//TODO: Should we move the code so it is not all in the controller?
saveSearchBtn.addEventListener("click", getFormValues);
function getFormValues() {
  let experienceValues = slider.noUiSlider.get();
  let desiredPositions = tagDivs[0].getAttribute("data-simple-tags");
  let languages = tagDivs[1].getAttribute("data-simple-tags");
  let locations = tagDivs[2].getAttribute("data-simple-tags");
  let saveSearch = document.querySelector(".toggle-checkbox").checked;
  let skills = tagDivs[3].getAttribute("data-simple-tags");
  let form = new FormData();
  form.append("experience", experienceValues);
  form.append("desiredPositions", desiredPositions);
  form.append("languages", languages);
  form.append("locations", locations);
  form.append("saveSearch", saveSearch);
  form.append("skills", skills);
  editSearchPopup.classList.add("hidden");
  let experienceTag = document.createElement("li");
  let desiredPositionsTag = document.createElement("li");
  let languagesTag = document.createElement("li");
  let locationsTag = document.createElement("li");
  let skillsTag = document.createElement("li");
  let tagWrapper = document.createElement("ul");
  let experienceMin = form.get("experience").split(",")[0];
  let experienceMax = form.get("experience").split(",")[1];

  experienceTag.textContent =
    "Years of Experience: " + experienceMin + " - " + experienceMax;
  desiredPositionsTag.textContent = "Location: " + form.get("desiredPositions");
  languagesTag.textContent = "Languages: " + form.get("languages");
  locationsTag.textContent = "Locations: " + form.get("locations");
  skillsTag.textContent = "Skills: " + form.get("skills");
  tagWrapper.appendChild(experienceTag);
  tagWrapper.appendChild(desiredPositionsTag);
  tagWrapper.appendChild(languagesTag);
  tagWrapper.appendChild(locationsTag);
  tagWrapper.appendChild(skillsTag);

  searchTags.appendChild(tagWrapper);
  console.log(skills);
  let xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `index.php?action=talentSearch&filter=true&yearsMin=${experienceMin}&yearsMax=${experienceMax}&languages=${languages}&locations=${locations}&desiredp=${desiredPositions}&skills=${skills}&degrees=`
  );
  xhr.onload = (e) => {
    console.log(xhr.responseText);
    cardContainer.innerHTML = "";
    cardContainer.innerHTML = xhr.response;
  };
  xhr.send();
  return form;
}
cancelBtn.addEventListener("click", () => {
  editSearchPopup.classList.add("hidden");
});

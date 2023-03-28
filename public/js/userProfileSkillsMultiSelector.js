// TODO: Add arrow key and enter selection capability
// TODO: Add number remaining text

function createMultiSelector(data, containerId, limit) {
  console.log("limit:", limit);
  // create references to all the required DOM elements
  const inputElement = document.querySelector(
    `#${containerId}Container > .input-container > input`
  );
  const resultsContainer = document.querySelector(
    `#${containerId}Container .autocomplete-results`
  );
  const selectedItemsContainer = document.querySelector(
    `#${containerId}Container .selected-items-container`
  );
  const hiddenInput = document.querySelector(
    `#${containerId}Container input.hidden`
  );

  // a Set is similar to an array, but cannot contain duplicate values. yay!
  const selectedList = new Set();

  function getResultsList(e) {
    resultsContainer.innerHTML = "";
    if (selectedList.size >= limit) {
      resultsContainer.textContent = "Limit reached: can't add more";
      return;
    }
    const query = e.target.value;

    // filter the data to get an array of items matching the query
    const results = data.filter(
      (element) => element.item.toLowerCase().indexOf(query.toLowerCase()) === 0
    );
    if (query.length > 0 && results.length > 0) {
      // create an entry for each matching item
      for (let result of results) {
        const resultItem = document.createElement("div");
        resultItem.textContent = result.item;
        resultItem.dataset.id = result.id;
        resultItem.tabIndex = "-1"; // make the item focusable
        resultItem.addEventListener("click", selectItem);
        resultsContainer.appendChild(resultItem);
      }
    } else {
      resultsContainer.textContent = "No results";
    }
  }

  function hideResultsList(e) {
    /* prevents the container from being cleared immediately 
		   if a result item was clicked on.
		   This is necessary because 'blur' happens before 'click'
		*/
    if (!resultsContainer.contains(e.relatedTarget)) {
      resultsContainer.innerHTML = "";
    }
  }

  function selectItem(e) {
    if (selectedList.size >= limit) return;
    console.log("size:", selectedList.size);
    console.log("limit:", limit);
    // add an item to the selectedList Set, then destroy the results,
    // clear the container, re-focus the input, then create the
    // display for the selected items
    selectedList.add(`${e.target.textContent}|${e.target.dataset.id}`);
    resultsContainer.innerHTML = "";
    inputElement.value = "";
    inputElement.focus();
    showSelectedItems();
  }

  function showSelectedItems() {
    // turn list into a string, with & between each element
    // put that string into hidden input value to be submitted
    // ex: "javascript|63&java|62";
    // this string is what will be sent to the backend
    hiddenInput.value = Array.from(selectedList).join("&");
    selectedItemsContainer.innerHTML = "";
    selectedList.forEach((item) => {
      // loop through the Set and create the visual elements
      // to see the selected items
      const selectedMarker = document.createElement("div");
      selectedMarker.textContent = item.split("|")[0];
      selectedMarker.dataset.item = item;
      const cancelBtn = document.createElement("button");

      // delete button
      cancelBtn.textContent = "X";
      cancelBtn.addEventListener("click", removeSelectedItem);
      selectedMarker.appendChild(cancelBtn);
      selectedItemsContainer.appendChild(selectedMarker);
    });
  }

  function removeSelectedItem(e) {
    selectedList.delete(e.target.parentElement.dataset.item);
    showSelectedItems();
  }

  inputElement.addEventListener("keyup", getResultsList);
  inputElement.addEventListener("blur", hideResultsList);
}

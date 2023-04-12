const searchInput = document.getElementById("messageSearch");
const contactsDiv = document.querySelector(".messeangerContacts");

//Gets message cards on enter. The message cards include any conversation threads that include the search term
searchInput.addEventListener("keyup", (e) => {
  console.log(e.key);
  if (e.key == "Enter") {
    let searchValue = searchInput.value;
    console.log(searchValue);
    xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost/sites/batch19-project/index.php?action=search&term=" + searchValue);
    xhr.onload = () => {
      // console.log(xhr.response);
      contactsDiv.innerHTML = xhr.response;
      let messageCards = document.querySelectorAll(".messageCard");
      newChatMessenger(messageCards);
    };
    xhr.send(null);
  }
});

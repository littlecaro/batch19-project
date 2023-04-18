// // const threadList = [];
// // A class to represent a message thread
// class MessageThread {
//   constructor(parent, child) {
//     this.parent = parent;
//     this.child = child;
//   }
// }

// /**
//  * Expands a chat box and changes its chevron icon.
//  * @param {HTMLElement} toExpand - The chat box to expand.
//  */

// Function to expand the chatboxes and toggle the chevron icon
function chatBoxExpand(toExpand) {
  // Toggle the 'expand' class to show/hide the chatbox content
  toExpand.classList.toggle("expand");
  //Checks if the chevron exists
  try {
    let innerElem = toExpand.querySelector(".expandableWrapper ");
    innerElem.classList.toggle("expand");
  } catch (error) {
    innerElem = null;
  }
  console.log(toExpand.classList.contains("messageContainer"));
  console.log(toExpand.parentElement);
  if (
    typeof innerElem !== "undefined" &&
    !toExpand.classList.contains("newChatBox") &&
    !toExpand.parentElement.classList.contains("newChatBox")
  ) {
    chevronSwitch(toExpand);
  }
}
// Chevron switch up and down
function chevronSwitch(toExpand) {
  // Toggle the chevron icon to point up/down depending on the chatbox state
  const chevron = toExpand.previousElementSibling.lastElementChild.lastElementChild;
  console.log(chevron);
  if (chevron.classList[1] == "fa-chevron-up") {
    chevron.classList.remove("fa-chevron-up");
    chevron.classList.add("fa-chevron-down");
  } else {
    chevron.classList.remove("fa-chevron-down");
    chevron.classList.add("fa-chevron-up");
  }
}
/**
 * Loads the messages of a thread using an XMLHttpRequest.
 * @param {MessageThread} thread - The thread whose messages to load.
 * @returns {string} - The response from the server.
 */

// function loadMessages(thread) {
//   let xhr = new XMLHttpRequest();
//   var form = new FormData();
//   form.append("conversationId", thread.parent.getAttribute("data-thread"));
//   form.append("userId", userId);
//   var data = {
//     conversationId: thread.parent.getAttribute("data-thread"),
//     userId: userId,
//   };
//   xhr.onload = () => {};
//   xhr.open("POST", "http://localhost/sites/batch19-project/index.php?action=getChatMessages", false);
//   xhr.send(form);
//   return xhr.response;
// }

// // Function to create the messaging profile icon for a chatbox
// function createChatIcons(card) {
//   let messagingProfileIco = document.createElement("div");
//   messagingProfileIco.className = "messagingProfileIco";
//   let messagingProfileImg = document.createElement("img");
//   messagingProfileImg.className = "messagingProfileImg";
//   let userImg = card.firstElementChild.firstElementChild.getAttribute("src");
//   messagingProfileImg.setAttribute("src", userImg);
//   messagingProfileIco.appendChild(messagingProfileImg);
//   return messagingProfileIco;
// }

// // Function to create the header for a chatbox
// function createChatboxHead(card, thread, messagingProfileIco) {
//   let newChatboxHead = document.createElement("div");
//   newChatboxHead.className = "chatboxHead";
//   let newChatUserName = document.createElement("strong");
//   let newChatUserNameContainer = document.createElement("p");
//   newChatUserNameContainer.appendChild(newChatUserName);
//   let userName = card.firstElementChild.nextElementSibling.firstElementChild.textContent;
//   newChatUserName.textContent = userName;
//   newChatboxHead.appendChild(messagingProfileIco);
//   newChatboxHead.appendChild(newChatUserNameContainer);

//   return newChatboxHead;
// }

// // Function to create the title for a chatbox. Currently not in use
// function createChatboxTitle() {
//   let chatBoxTitle = document.createElement("div");
//   chatBoxTitle.classList = "chatBoxTitle";
//   return chatBoxTitle;
// }

// // Function to create the actions for a chatbox (e.g., the close button)

// function createChatboxActions(thread) {
//   let chatBoxActions = document.createElement("div");
//   chatBoxActions.className = "chatBoxActions";
//   let icon1 = document.createElement("i");
//   icon1.className = "fa-solid fa-xmark";
//   icon1.addEventListener("click", () => {
//     thread.child.remove();
//     thread.child = null;
//     console.log("testtt");
//   });
//   chatBoxActions.appendChild(icon1);

//   return chatBoxActions;
// }

// // Function to create the input box
// function createChatboxInput(thread, messageContainer) {
//   let inputmessage = document.createElement("textarea");
//   inputmessage.className = "messageInput";
//   inputmessage.name = "msg";
//   let submitBox = document.createElement("i");
//   submitBox.className = "fa-solid fa-paper-plane";
//   submitBox.type = "submit";
//   submitBox.value = "send";
//   let messageForm = document.createElement("form");
//   messageForm.appendChild(inputmessage);
//   messageForm.appendChild(submitBox);
//   console.log(thread, "this is a first thread");

//   inputmessage.addEventListener("keyup", (e) => {
//     console.log(thread, "this is a thread");
//     console.log(e);
//     if (e.key == "Enter") {
//       submitMessage(e, e.srcElement, thread, messageContainer);
//       inputmessage.value = "";
//     }
//   });
//   messageForm.addEventListener("submit", (e) => {
//     e.preventDefault();
//   });
//   // Submit message event
//   submitBox.addEventListener("click", (e) => {
//     submitMessage(e, inputmessage, thread, messageContainer);
//     inputmessage.value = "";
//   });

//   return messageForm;
// }

// function submitMessage(e, inputmessage, thread, messageContainer) {
//   let xhr = new XMLHttpRequest();
//   var form = new FormData();
//   form.append("message", inputmessage.value);
//   //the current conversation id is added as a conversation thread attribue to the html element
//   form.append("conversationId", thread.parent.getAttribute("data-thread"));

//   xhr.onload = () => {
//     response = loadMessages(thread);
//     messageContainer.innerHTML = response;
//     // console.log(xhr.response);
//   };
//   xhr.open("POST", "http://localhost/sites/batch19-project/index.php?action=submitMessage");
//   xhr.send(form);
//   e.preventDefault();
// }
// //create the container that contains the response of the AJAX request i.e. the conversation cards
// function createChatboxContainer(thread) {
//   let messageContainer = document.createElement("div");
//   messageContainer.className = "messageContainer";
//   let response = loadMessages(thread);
//   messageContainer.innerHTML = response;
//   return messageContainer;
// }

// //Refreshes messages inside a given chatbox
// function refreshMessages(messageContainer, thread) {
//   let prevResponse = "";
//   setInterval(() => {
//     let shouldScroll = Math.abs(messageContainer.scrollHeight - messageContainer.scrollTop - messageContainer.clientHeight) < 1;
//     let response = loadMessages(thread);
//     if (response != prevResponse && prevResponse != "") {
//       const newLocal = ".chatPreviewDate i";
//       console.log(thread.child.querySelector(".expandableWrapper").classList);
//       if (!thread.child.querySelector(".expandableWrapper").classList.contains("expand")) {
//         chatBoxExpand(thread.child);
//         scrollDown(thread.child);
//         readMessage(thread);
//       }
//     }
//     prevResponse = response;
//     messageContainer.innerHTML = "";
//     messageContainer.innerHTML = response;
//     if (shouldScroll) scrollDown(messageContainer);
//   }, 2000);
// }

// //creates the form that includes the user input for sending a message
// function createformMessageContainer(messageContainer, messageForm) {
//   let chatboxElementWrapper = document.createElement("div");
//   chatboxElementWrapper.classList = "expandableWrapper";
//   chatboxElementWrapper.appendChild(messageContainer);
//   chatboxElementWrapper.appendChild(messageForm);
//   return chatboxElementWrapper;
// }

// //appends everything to the new chatbox
// function appendElements(chatboxHead, chatBoxTitle, chatBoxActions, chatboxElementWrapper, newChatbox, parentElem) {
//   chatBoxTitle ? chatboxHead.appendChild(chatBoxTitle) : "";
//   chatBoxActions ? chatboxHead.appendChild(chatBoxActions) : "";
//   chatboxHead ? newChatbox.appendChild(chatboxHead) : "";
//   chatboxElementWrapper ? newChatbox.appendChild(chatboxElementWrapper) : "";
//   console.log(parentElem);
//   console.log(newChatbox);
//   parentElem.prepend(newChatbox);
// }

// function scrollDown(msgsContainer) {
//   msgsContainer.scrollTo({
//     top: msgsContainer.scrollHeight,
//     behavior: "smooth",
//   });
// }
// function readMessage(thread) {
//   var form = new FormData();

//   form.append("conversationId", thread.parent.getAttribute("data-thread"));
//   console.log(form.getAll("conversationId"));
//   xhr = new XMLHttpRequest();
//   xhr.onload = () => {
//     countUnreadMessages();
//   };
//   xhr.open("POST", "http://localhost/sites/batch19-project/index.php?action=readMessage");
//   xhr.send(form);
// }
// // function countUnreadMessages(card) {
// // console.log(card);
// let form = new FormData();
// if (typeof card != "undefined") {
//   let conversationId = card.getAttribute("data-thread");
//   form.append("conversationId", conversationId);
// }
// let xhr = new XMLHttpRequest();
// xhr.onload = () => {
//   if (typeof card !== "") {
//     // console.log(xhr.response);
//     if (xhr.response !== "") {
//       card.querySelector(".chatPreviewDate i").style.display = "block";
//     } else if (xhr.response === "") {
//       card.querySelector(".chatPreviewDate i").style.display = "none";
//     }
//   }
// };
// xhr.open("POST", "http://localhost/sites/batch19-project/index.php?action=partyMessageUnread");
// xhr.send(form);
// // }
// function loadUnreadMessageNum() {
//   xhr = new XMLHttpRequest();
//   xhr.onload = () => {
//     if (xhr.response > 0) {
//       unreadMessageCount.style.display = "block";
//       unreadMessageCount.textContent = xhr.response;
//     } else {
//       unreadMessageCount.style.display = "none";
//     }
//   };
//   xhr.open("POST", "http://localhost/sites/batch19-project/index.php?action=countUnreadMessages");
//   xhr.send();
// }

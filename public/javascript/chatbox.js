//TODO:handle overflowing chat boxes
//TODO:Are event listeners being added constantly?
const chatboxContainer = document.querySelector(".chatboxContainer");
const chatboxHead = document.querySelector(".chatboxHead");
const messageContainer = document.querySelector(".messageContainer");
const chatboxFooter = document.querySelector(".chatboxFooter");
chatboxHead.addEventListener("click", chatBoxExpand);
const messageCards = null ?? document.querySelectorAll(".messageCard");
const threadList = [];
class MessageThread {
  constructor(parent, child) {
    this.parent = parent;
    this.child = child;
  }
}

function chatBoxExpand() {
  messageContainer.classList.toggle("expand");
}
function cardExpand(card) {
  card.classList.toggle("expand");
}
function loadMessages(thread) {
  let xhr = new XMLHttpRequest();
  var form = new FormData();
  form.append("conversationId", thread.parent.getAttribute("data-thread"));
  form.append("userId", userId);
  // console.log("fetching messages");
  var data = {
    conversationId: thread.parent.getAttribute("data-thread"),
    userId: userId,
  }; //TODO:make conversation id dynamic
  xhr.onload = () => {
    // console.log(xhr.responseText);
    // console.log(data);
  };
  xhr.open(
    "POST",
    "http://localhost/sites/batch19-project/index.php?action=getChatMessages",
    false
  );
  // console.log(xhr.response);
  // xhr.setRequestHeader("Content-Type", "application/json");
  // var json = JSON.stringify(data);

  // response = JSON.parse(xhr.response);
  xhr.send(form);
  return xhr.response;
}
function newChat() {}
if (messageCards) {
  messageCards.forEach((card) => {
    let thread = new MessageThread(card, null);
    card.addEventListener("click", (e) => {
      if (thread.child) {
        thread.child.remove();
        thread.child = null;
      } else {
        let newChat = document.createElement("div");
        let newChatBoxhHead = document.createElement("div");
        newChatBoxhHead.className = "chatboxHead";
        let messagingProfileIco = document.createElement("div");
        messagingProfileIco.className = "messagingProfileIco";
        let messagingProfileImg = document.createElement("img");
        messagingProfileImg.className = "messagingProfileImg";
        let chatBoxTitle = document.createElement("div");
        chatBoxTitle.classList = "chatBoxTitle";
        let chatBoxActions = document.createElement("div");
        chatBoxActions.className = "chatBoxActions";
        let icon1 = document.createElement("i");
        icon1.className = "fa-solid fa-xmark";
        let icon2 = document.createElement("i");
        let icon3 = document.createElement("i");
        let inputmessage = document.createElement("input");
        inputmessage.className = "messageInput";
        inputmessage.name = "msg";

        let submitBox = document.createElement("i");
        submitBox.className = "fa-solid fa-paper-plane";
        submitBox.type = "submit";
        submitBox.value = "send";

        let messageContainer = document.createElement("div");
        messageContainer.className = "messageContainer";
        newChat.className = "newChatBox";
        thread.child = newChat;
        threadList.push(thread);
        let response = loadMessages(thread);
        // response = JSON.parse(response);
        newChat.appendChild(newChatBoxhHead);
        newChat.appendChild(messagingProfileIco);
        messagingProfileIco.appendChild(messagingProfileImg);
        newChatBoxhHead.appendChild(messagingProfileIco);
        newChat.appendChild(chatBoxTitle);
        newChat.appendChild(chatBoxActions);
        newChat.appendChild(messageContainer);
        messageContainer.innerHTML = response;
        let messageForm = document.createElement("form");
        chatboxFooter.prepend(newChat);
        newChat.firstElementChild.addEventListener("click", () => {
          // console.log("caaards");
          newChat.lastChild.previousSibling.classList.toggle("expand");
          newChat.lastChild.classList.toggle("expand");
        });
        let userImg =
          card.firstElementChild.firstElementChild.getAttribute("src");
        messagingProfileImg.setAttribute("src", userImg);
        let userName =
          card.firstElementChild.nextElementSibling.firstElementChild
            .textContent;
        let newChatUserName = document.createElement("strong");
        let newChatUserNameContainer = document.createElement("p");
        newChatUserNameContainer.appendChild(newChatUserName);
        let usernameDiv = document.createElement("div");
        newChatBoxhHead.appendChild(newChatUserNameContainer);
        newChatBoxhHead.appendChild(icon1);
        icon1.addEventListener("click", () => {
          thread.child.remove();
          thread.child = null;
        });
        newChatUserName.textContent = userName;
        messageForm.appendChild(inputmessage);
        messageForm.appendChild(submitBox);
        newChat.appendChild(messageForm);

        submitBox.addEventListener("click", (e) => {
          // console.log(response);
          let xhr = new XMLHttpRequest();
          var form = new FormData();
          form.append("message", inputmessage.value);
          form.append(
            "conversationId",
            thread.parent.getAttribute("data-thread")
          );
          form.append("senderId", userId);

          var data = {
            conversationId: thread.parent.getAttribute("data-thread"),
            userId: userId,
          }; //TODO:make conversation id dynamic
          xhr.onload = () => {
            // console.log(xhr.responseText);
            response = loadMessages(thread);

            messageContainer.innerHTML = "";
            messageContainer.innerHTML = response;
          };
          xhr.open(
            "POST",
            "http://localhost/sites/batch19-project/index.php?action=submitMessage"
          );
          // console.log(xhr.response);
          xhr.send(form);
          response = loadMessages(thread);

          e.preventDefault();
        });
      }
    });
  });
}

// //TODO:handle overflowing chat boxes
// //TODO:Are event listeners being added constantly?
// const chatboxContainer = document.querySelector(".chatboxContainer");
// const chatboxHead = document.querySelector(".chatboxHead");
// const messageContainer = document.querySelector(".messageContainer");
// const chatboxFooter = document.querySelector(".chatboxFooter");
// const unreadMessageCount = document.querySelector(".unreadNum");
// const toMessenger = document.querySelector(".fa-solid.fa-up-right-and-down-left-from-center");

// toMessenger.addEventListener("click", () => {
//   window.location.href = "http://localhost/sites/batch19-project/index.php?action=messenger";
// });
// if (chatboxHead) {
//   // console.log(chatboxHead);
//   chatboxHead.addEventListener("click", (e) => {
//     chatBoxExpand(chatboxHead.nextElementSibling);
//   });
// }
// const messageCards = null ?? document.querySelectorAll(".messageCard");

// function newChat() {
//   if (messageCards) {
//     messageCards.forEach((card) => {
//       let thread = new MessageThread(card, null);
//       threadList.push(thread);
//       setInterval(() => {
//         countUnreadMessages(card);
//         console.log("running");
//         console.log(card);
//       }, 1000);

//       card.addEventListener("click", (e) => {
//         if (thread.child) {
//           thread.child.remove();
//           thread.child = null;
//         } else {
//           // Create new chatboxes/chatbox heads
//           let newChat = document.createElement("div");
//           newChat.className = "newChatBox";
//           thread.child = newChat;

//           // Messaging profile icon
//           messagingProfileIco = createChatIcons(card);
//           // Chatbox head
//           let newChatboxHead = createChatboxHead(card, thread, messagingProfileIco);
//           // Chatbox title
//           let chatBoxTitle = createChatboxTitle();
//           // Chatbox actions
//           let chatBoxActions = createChatboxActions(thread);
//           // Create chatbox container
//           let messageContainer = createChatboxContainer(thread);
//           // Create chatbox input part
//           let messageForm = createChatboxInput(thread, messageContainer);
//           // Create chatbox container / form wrapper
//           let chatboxElementWrapper = createformMessageContainer(messageContainer, messageForm);
//           // Append all elements to the newChat container
//           appendElements(newChatboxHead, chatBoxTitle, chatBoxActions, chatboxElementWrapper, newChat, chatboxFooter);
//           readMessage(thread);
//           refreshMessages(messageContainer, thread);
//           // Toggle chatbox expand

//           newChat.firstElementChild.addEventListener("click", () => {
//             console.log("test");
//             chatBoxExpand(chatboxElementWrapper, newChatboxHead);
//             scrollDown(messageContainer);
//             countUnreadMessages();
//             readMessage(newChat);
//           });
//         }
//       });
//     });
//   }
// }
// newChat();
// countUnreadMessages();
// setInterval(() => {
//   loadUnreadMessageNum();
// }, 100);

const messengerCenter = document.querySelector(".messengerCenter");
const messageThreads = null ?? document.querySelectorAll(".messageCard");

function newChatMessenger(messageCards) {
  if (messageCards) {
    messageCards.forEach((card) => {
      let thread = new MessageThread(card, null);
      threadList.push(thread);
      card.addEventListener("click", (e) => {
        // Create new chatboxes/chatbox heads
        let newChat = document.createElement("div");
        newChat.className = "newChatBox";
        thread.child = newChat;
        getCounterpartInfo(thread);

        // Messaging profile icon
        messagingProfileIco = createChatIcons(card);
        // Chatbox head
        let newChatboxHead = createChatboxHead(
          card,
          thread,
          messagingProfileIco
        );
        // Chatbox title
        let chatBoxTitle = createChatboxTitle();
        // Chatbox actions
        let chatBoxActions = undefined;
        // Create chatbox container
        let messageContainer = createChatboxContainer(thread);
        // Create chatbox input part
        let messageForm = createChatboxInput(thread, messageContainer);
        // Create chatbox container / form wrapper
        let chatboxElementWrapper = createformMessageContainer(
          messageContainer,
          messageForm
        );
        // Append all elements to the newChat container
        messengerCenter.innerHTML = "";
        appendElements(
          newChatboxHead,
          chatBoxTitle,
          chatBoxActions,
          chatboxElementWrapper,
          newChat,
          messengerCenter
        );
        // refreshMessages(messengerCenter, thread);
        refreshMessages(messageContainer, thread);
        // Toggle chatbox expand
        console.log(messageContainer, "test");
        chatBoxExpand(chatboxElementWrapper);
        scrollDown(messageContainer);
        readMessage(newChat);
      });
    });
  }
}
newChatMessenger(messageThreads);

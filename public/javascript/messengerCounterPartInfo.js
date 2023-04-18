const messengerRight = document.querySelector(".messengerRight");

function getCounterpartInfo(thread) {
  let form = new FormData();
  form.append("conversationId", thread.parent.getAttribute("data-thread"));

  let xhr = new XMLHttpRequest();
  xhr.onload = () => {
    console.log("starting");
    console.log(xhr.responseText);
    messengerRight.innerHTML = xhr.responseText;
  };
  xhr.open(
    "POST",
    "http://localhost/sites/batch19-project/index.php?action=getCounterpartInfo"
  );
  xhr.send(form);
}

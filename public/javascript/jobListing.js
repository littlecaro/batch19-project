const jobPostingCards = document.querySelectorAll(".jobPostingCard");
jobPostingCards.forEach((card) => {
  console.log(card.getAttribute("data"));

  if (card.getAttribute("data") == 0) {
    card.classList.add("jobInactive");
  }
});

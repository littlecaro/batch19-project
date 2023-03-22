let offset = 0;

const calendar = document.querySelector(".calendar");

const prevWeek = document.querySelector(".prev");
prevWeek.addEventListener("click", () => {
  offset += 7;
  displayCal(offset);
});

const nextWeek = document.querySelector(".next");
nextWeek.addEventListener("click", () => {
  offset -= 7;
  displayCal(offset);
});

const undo = document.querySelector(".undo");
undo.addEventListener("click", () => {
  displayCal(offset);
  let selection = document.querySelector(".selection");
  if (selection) {
    selection.remove();
  }
});

const submit = document.querySelector(".submit");
submit.addEventListener("click", () => {
  displayChoices();
});

function displayCal(x = 0) {
  calendar.innerHTML = "";
  confirmedContainer.innerHTML = "";
  const today = new Date();
  const dayOfWeek = today.getDay();
  for (let i = 6; i <= 20; i++) {
    const tr = document.createElement("tr");
    calendar.appendChild(tr);
    for (j = 1; j <= 7; j++) {
      // setting up the most left column
      if (j == 1) {
        const th = document.createElement("th");
        th.setAttribute("class", "times");
        if (i >= 8) {
          th.textContent = i;
          tr.appendChild(th);
        } else {
          th.textContent = "Table";
          tr.appendChild(th);
        }
      }
      const tableDate = new Date(Date.now() - (dayOfWeek + x - j) * 24 * 60 * 60 * 1000);
      let datestr = `${monthStr(tableDate.getMonth())} ${dayToTh(tableDate.getDate())}`;
      if (i == 6) {
        const th = document.createElement("th");
        th.textContent = `${dayStr(j)}`;
        tr.appendChild(th);
      } else if (i == 7) {
        const td = document.createElement("th");
        td.textContent = datestr;
        tr.appendChild(td);
      } else {
        const td = document.createElement("td");
        let year = tableDate.getFullYear();
        let month = tableDate.getMonth() + 1;
        let day;
        if (month < 10) {
          month = `0${month}`;
        }
        if (tableDate.getDate() < 10) {
          day = `0${tableDate.getDate()}`;
        } else {
          day = tableDate.getDate();
        }
        td.setAttribute("data-php", `${year}-${month}-${day}`);
        td.setAttribute("data-dateStr", datestr);
        if (i < 10) {
          td.setAttribute("data-time", `0${i}:00:00`);
        } else {
          td.setAttribute("data-time", `${i}:00:00`);
        }
        tr.appendChild(td);
      }
    }
  }
  inputEntries(entries);
  displayConfirmed(entries);
  highlight();
}

displayCal();

function dayStr(day) {
  const days = ["", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
  return days[day];
}

function monthStr(month) {
  const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  return months[month];
}

function highlight() {
  let table = document.querySelector("table");
  let tds = document.querySelectorAll("td");
  let isMouseUp = true;
  table.addEventListener("mousedown", function (e) {
    isMouseUp = false;
    table.style.cursor = "grabbing";
    window.addEventListener("mousemove", function (e) {
      if (isMouseUp) {
        return;
      }
      table.style.cursor = "grabbing";
    });
  });
  table.addEventListener("mouseup", function () {
    table.style.cursor = "grab";
    isMouseUp = true;
  });
  for (let td of tds) {
    td.addEventListener("mousemove", function (e) {
      if (!isMouseUp) {
        td.className = "selected";
      }
      // TODO: Be able to unselect.
      // if (td.classList.contains("selected")) {
      //   td.className = "";
      // }
    });
  }
}

function displayChoices() {
  let oldSelection = document.querySelector(".selection");
  if (oldSelection) {
    oldSelection.remove();
  }
  const selection = document.createElement("div");
  selection.setAttribute("class", "selection");
  const h1 = document.createElement("h1");
  h1.textContent = "Please confirm your selection:";
  selection.appendChild(h1);

  const selected = document.querySelectorAll(".selected");
  for (let each of selected) {
    let div = document.createElement("div");
    let date = document.createElement("p");
    date.textContent = `Date: ${each.dataset.datestr}`;
    div.appendChild(date);
    let time = document.createElement("p");
    time.textContent = `Time: ${each.dataset.time.slice(0, 5)}`;
    div.appendChild(time);
    selection.appendChild(div);
  }
  const confirm = document.createElement("button");
  confirm.textContent = "Confirm";
  confirm.addEventListener("click", sendIt);
  selection.appendChild(confirm);
  confirmChoices.appendChild(selection);
}

function sendIt() {
  const selected = document.querySelectorAll(".selected");
  const selectArr = [];
  for (let each of selected) {
    selectArr.push({
      date: `${each.dataset.php}`,
      time: `${each.dataset.time}`,
    });
  }
  const calendar = JSON.stringify(selectArr);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", `./index.php?action=updateCalendar&data=${calendar}`);

  xhr.addEventListener("load", function () {
    location.reload();
  });

  xhr.send(null);
}

function inputEntries(entries) {
  const tds = document.querySelectorAll("td");
  for (let td of tds) {
    let date = td.getAttribute("data-php");
    let time = td.getAttribute("data-time");
    for (let entry of entries) {
      if ((date === entry.date) & (time === entry.time_start)) {
        td.className = "confirmed";
      }
    }
  }
}

function displayConfirmed(entries) {
  let h1 = document.createElement("h1");
  h1.textContent = "Confirmed availability";
  confirmedContainer.appendChild(h1);
  for (let entry of entries) {
    let div = document.createElement("div");
    div.setAttribute("class", "confirmedAvail");
    let date = document.createElement("p");
    let dateArr = dateStrToArr(entry.date);
    // let year = dateArr[0];
    // Parse int to remove leading zero (minus one because array is zero-indexed).
    let month = monthStr(parseInt(dateArr[1] - 1, 10));
    let day = dayToTh(parseInt(dateArr[2], 10));
    // date.textContent = `Date: ${month} ${day}, ${year}`;
    date.textContent = `Date: ${month} ${day}`;
    div.appendChild(date);
    let time = document.createElement("p");
    time.textContent = `Time: ${entry.time_start.slice(0, 5)}`;
    div.appendChild(time);
    let deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete entry";
    deleteBtn.setAttribute("data-date", `${entry.date}`);
    deleteBtn.setAttribute("data-time", `${entry.time_start}`);
    deleteBtn.addEventListener("click", deleteDateEntry);
    div.appendChild(deleteBtn);
    confirmedContainer.appendChild(div);
  }
}

function dateStrToArr(date) {
  return (dateArr = date.split("-"));
}

function dayToTh(day) {
  if (day == 1) {
    return `${day}st`;
  } else if (day == 2) {
    return `${day}nd`;
  } else if (day == 3) {
    return `${day}rd`;
  } else {
    return `${day}th`;
  }
}

function deleteDateEntry(e) {
  // console.log(e.target.dataset.date);
  // console.log(e.target.dataset.time);
  const enteredArr = [];
  enteredArr.push({
    date: `${e.target.dataset.date}`,
    time: `${e.target.dataset.time}`,
  });
  // console.log(enteredArr);
  const entry = JSON.stringify(enteredArr);
  // console.log(entry);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", `./index.php?action=deleteEntry&entry=${entry}`);

  xhr.addEventListener("load", function () {
    location.reload();
  });

  xhr.send(null);
}

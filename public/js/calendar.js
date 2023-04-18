function loadCalendar() {
  const today = new Date();
  let offset = 0;

  const calendar = document.querySelector(".calendar");

  const prevWeek = document.querySelector(".prev");
  prevWeek.addEventListener("click", () => {
    let selectionExists = document.querySelector(".selection");
    if (selectionExists) {
      favDialog.showModal();
    } else {
      offset += 7;
      displayCal(offset);
    }
  });

  const nextWeek = document.querySelector(".next");
  nextWeek.addEventListener("click", () => {
    let selectionExists = document.querySelector(".selection");
    if (selectionExists) {
      favDialog.showModal();
    } else {
      offset -= 7;
      displayCal(offset);
    }
  });

  function displayCal(x = 0) {
    calendar.innerHTML = "";
    confirmedContainer.innerHTML = "";
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
            th.textContent = " ";
            tr.appendChild(th);
          }
        }
        const tableDate = new Date(Date.now() - (dayOfWeek + x - j) * 24 * 60 * 60 * 1000);
        const unix = Date.now() - (dayOfWeek + x - j) * 24 * 60 * 60 * 1000;
        // sometimes the unix will change by a single digit at different times each day depending on when queried(?)
        // used later to organise the selected dates.
        const compare = unix.toString().slice(0, 11);
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
          td.setAttribute("data-unix", unix);
          td.setAttribute("data-compare", compare);
          if (i < 10) {
            td.setAttribute("data-time", `0${i}:00:00`);
          } else {
            td.setAttribute("data-time", `${i}:00:00`);
          }
          if (td.dataset.unix < Date.now()) {
            td.className = "prior";
          } else if (td.dataset.unix == Date.now() && td.dataset.time.slice(0, 2) <= today.getHours()) {
            td.className = "prior";
          } else {
            td.innerHTML = `${td.dataset.time.slice(0, 5)}`;
          }
          tr.appendChild(td);
        }
      }
    }
    inputEntries(entries, receives);
    displayConfirmed(entries);
    displayInterviews(receives);
    highlight();
  }

  function displayInterviews(receives) {
    let oldConfirmed = document.querySelector(".confirmedInt");
    if (oldConfirmed) {
      oldConfirmed.remove();
    }

    const confirmed = document.createElement("div");
    confirmed.setAttribute("class", "confirmedInt");
    confirmedInterviews.appendChild(confirmed);

    if (receives.length == 0) {
      return;
    }
    for (let i = 0; i < receives.length; i++) {
      let dateArr = dateStrToArr(receives[i].date);
      let newDate = true;
      if (i != 0) {
        newDate = new Date(receives[i].date).getTime() > new Date(receives[i - 1].date).getTime() ? true : false;
      }
      if (newDate) {
        const sortDiv = document.createElement("div");
        sortDiv.setAttribute("class", "confirmedAvail");
        sortDiv.setAttribute("data-id", `${new Date(receives[i].date).getTime()}`);
        let titleDiv = document.createElement("div");
        titleDiv.setAttribute("class", "titleDate");
        let titleDateNow = new Date(receives[i].date);
        // let titleUnix = titleDateNow.getTime();
        let titleDay = document.createElement("p");
        titleDay.textContent = `${dayStr(titleDateNow.getDay())}, `;
        titleDiv.appendChild(titleDay);

        //
        let titleDate = document.createElement("p");
        // Parse int to remove leading zero (minus one because array is zero-indexed).
        let month = monthStr(parseInt(dateArr[1] - 1, 10));
        let day = dayToTh(parseInt(dateArr[2], 10));
        titleDate.textContent = `${month} ${day}`;
        titleDiv.appendChild(titleDate);
        sortDiv.appendChild(titleDiv);

        let timeDiv = document.createElement("div");
        timeDiv.setAttribute("class", "timeDiv");

        let job = document.createElement("p");
        job.textContent = `${receives[i].title}, `;
        timeDiv.appendChild(job);

        let company = document.createElement("p");
        company.textContent = `${receives[i].name}, `;
        timeDiv.appendChild(company);

        let time = document.createElement("p");
        time.textContent = `${receives[i].time_start.slice(0, 5)}`;
        timeDiv.appendChild(time);
        sortDiv.appendChild(timeDiv);

        let cancelBtn = document.createElement("button");
        cancelBtn.textContent = "Cancel";
        cancelBtn.classList.add("cancel");
        cancelBtn.setAttribute("data-cancelId", `${receives[i].id}`);
        cancelBtn.addEventListener("click", deleteReservation);
        time.appendChild(cancelBtn);
        confirmed.appendChild(sortDiv);
      } else {
        const sortDiv = document.querySelector(`[data-id=${CSS.escape(new Date(receives[i].date).getTime())}]`);

        let timeDiv = document.createElement("div");
        timeDiv.setAttribute("class", "timeDiv");
        timeDiv.classList.add("timeMid");

        let job = document.createElement("p");
        job.textContent = `${receives[i].title}, `;
        timeDiv.appendChild(job);

        let company = document.createElement("p");
        company.textContent = `${receives[i].name}, `;
        timeDiv.appendChild(company);

        let time = document.createElement("p");
        time.textContent = `${receives[i].time_start.slice(0, 5)}`;
        timeDiv.appendChild(time);

        let cancelBtn = document.createElement("button");
        cancelBtn.textContent = "Cancel";
        cancelBtn.classList.add("cancel");
        cancelBtn.setAttribute("data-cancelId", `${receives[i].id}`);
        cancelBtn.addEventListener("click", deleteReservation);
        time.appendChild(cancelBtn);
        sortDiv.appendChild(timeDiv);
        confirmed.appendChild(sortDiv);
      }
    }
    let cancelBtn = document.createElement("button");
    cancelBtn.textContent = "Cancel all interviews";
    cancelBtn.addEventListener("click", deleteReservation);
    confirmed.appendChild(cancelBtn);
  }

  displayCal();

  function dayStr(day) {
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    return days[day];
  }

  function monthStr(month) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    return months[month];
  }

  let isMouseUp = true;
  function highlight() {
    let table = document.querySelector(".calendar");
    let tds = document.querySelectorAll(".calendar td");
    // is user leaves the table with
    table.addEventListener("mousedown", function (e) {
      isMouseUp = false;
      table.style.cursor = "grabbing";
      window.addEventListener("mousemove", function (e) {
        if (isMouseUp) {
          return;
        }
        table.style.cursor = "grabbing";
      });
      // stop grabbing if user moves outside the table.
      table.addEventListener("mouseleave", function () {
        table.style.cursor = "grab";
        if (!isMouseUp) {
          displayChoices();
        }
        isMouseUp = true;
        return;
      });
    });
    // table.addEventListener("mouseup", function () {
    //   table.style.cursor = "grab";
    //   isMouseUp = true;
    //   displayChoices();
    //   return;
    // });
    for (let td of tds) {
      td.addEventListener("mouseup", function () {
        table.style.cursor = "grab";
        isMouseUp = true;
        displayChoices();
        return;
      });
      td.addEventListener("mousemove", function (e) {
        if (!isMouseUp && !td.classList.contains("confirmed") && !td.classList.contains("interview") && !td.classList.contains("prior")) {
          td.className = "selected";
        }
      });
      td.addEventListener("click", function (e) {
        if (!td.classList.contains("confirmed") && !td.classList.contains("interview") && !td.classList.contains("prior")) {
          td.className = "selected";
          displayChoices();
        }
      });
    }
  }

  function displayChoices() {
    let oldSelection = document.querySelector(".selection");
    if (oldSelection) {
      oldSelection.remove();
    }

    const selected = document.querySelectorAll(".selected");
    // sort selection by date instead of time
    const selectedArr = Array.from(selected);
    let sorted = selectedArr.sort(sorter);
    function sorter(a, b) {
      return a.dataset.compare.localeCompare(b.dataset.compare);
    }
    if (sorted.length != 0) {
      const selection = document.createElement("div");
      selection.setAttribute("class", "selection");
      dynaUpdate.appendChild(selection);

      for (let i = 0; i < sorted.length; i++) {
        let newDate = true;
        if (i != 0) {
          newDate = sorted[i].dataset.compare > sorted[i - 1].dataset.compare ? true : false;
        }
        if (newDate) {
          // console.log(sorted[i].dataset.unix);
          const sortDiv = document.createElement("div");
          sortDiv.setAttribute("class", "sortedEntry");
          sortDiv.setAttribute("data-id", `${sorted[i].dataset.compare}`);
          let titleDiv = document.createElement("div");
          titleDiv.setAttribute("class", "titleDate");
          let titleDateNow = new Date(parseInt(sorted[i].dataset.unix));
          let titleDay = document.createElement("p");
          titleDay.textContent = `${dayStr(titleDateNow.getDay())}, `;
          titleDiv.appendChild(titleDay);

          let titleDate = document.createElement("p");
          titleDate.textContent = `${sorted[i].dataset.datestr}`;
          titleDiv.appendChild(titleDate);
          sortDiv.appendChild(titleDiv);

          let timeDiv = document.createElement("div");
          timeDiv.setAttribute("class", "timeDiv");
          let time = document.createElement("p");
          time.textContent = `${sorted[i].dataset.time.slice(0, 5)}`;
          timeDiv.appendChild(time);
          sortDiv.appendChild(timeDiv);

          let undoBtn = document.createElement("button");
          undoBtn.textContent = "Undo";
          undoBtn.setAttribute("data-php", `${sorted[i].dataset.php}`);
          undoBtn.setAttribute("data-time", `${sorted[i].dataset.time}`);
          undoBtn.addEventListener("click", unselect);
          timeDiv.appendChild(undoBtn);
          selection.appendChild(sortDiv);
        } else {
          const sortDiv = document.querySelector(`[data-id=${CSS.escape(sorted[i].dataset.compare)}]`);
          let timeDiv = document.createElement("div");
          timeDiv.setAttribute("class", "timeDiv");
          let time = document.createElement("p");
          time.textContent = `${sorted[i].dataset.time.slice(0, 5)}`;
          timeDiv.appendChild(time);

          let undoBtn = document.createElement("button");
          undoBtn.textContent = "Undo";
          undoBtn.setAttribute("data-php", `${sorted[i].dataset.php}`);
          undoBtn.setAttribute("data-time", `${sorted[i].dataset.time}`);
          undoBtn.addEventListener("click", unselect);
          timeDiv.appendChild(undoBtn);
          sortDiv.appendChild(timeDiv);
        }
      }
      let div = document.createElement("div");
      div.setAttribute("id", "bottomButtons");
      const undoAll = document.createElement("button");
      undoAll.textContent = "Undo all";
      undoAll.addEventListener("click", () => {
        displayCal(offset);
        let selection = document.querySelector(".selection");
        if (selection) {
          selection.remove();
        }
      });
      div.appendChild(undoAll);
      const confirm = document.createElement("button");
      confirm.textContent = "Confirm";
      confirm.addEventListener("click", sendIt);
      div.appendChild(confirm);
      selection.appendChild(div);
    }
  }

  function unselect(e) {
    let tds = document.querySelectorAll("td");
    for (let td of tds) {
      if (td.dataset.php == e.target.dataset.php && td.dataset.time == e.target.dataset.time && td.classList.contains("selected")) {
        td.classList.remove("selected");
        e.target.parentNode.remove();
      }
    }
    displayChoices();
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
      // displayCal();
      // refresh();
      // loadCalendar();
    });

    xhr.send(null);
  }

  function refresh(reload) {
    window.location = "#avail";
    window.location.reload(true);
  }

  function inputEntries(entries, receives) {
    // console.log(receives);
    const tds = document.querySelectorAll("td");
    for (let td of tds) {
      let date = td.getAttribute("data-php");
      let time = td.getAttribute("data-time");
      for (let entry of entries) {
        if ((date === entry.date) & (time === entry.time_start)) {
          td.className = "confirmed";
        }
      }
      for (let receive of receives) {
        if ((date === receive.date) & (time === receive.time_start)) {
          td.className = "interview";
          td.textContent = receive.name;
        }
      }
    }
  }

  function displayConfirmed(entries) {
    let h1 = document.createElement("h1");
    h1.textContent = "Confirmed availability: ";
    confirmedContainer.appendChild(h1);

    const confirmed = document.createElement("div");
    confirmed.setAttribute("class", "confirmedCont");
    confirmedContainer.appendChild(confirmed);

    if (entries.length == 0) {
      return;
    }
    for (let i = 0; i < entries.length; i++) {
      let dateArr = dateStrToArr(entries[i].date);
      let newDate = true;
      if (i != 0) {
        newDate = new Date(entries[i].date).getTime() > new Date(entries[i - 1].date).getTime() ? true : false;
      }
      if (newDate) {
        const sortDiv = document.createElement("div");
        sortDiv.setAttribute("class", "confirmedAvail");
        sortDiv.setAttribute("data-idA", `${new Date(entries[i].date).getTime()}`);
        let titleDiv = document.createElement("div");
        titleDiv.setAttribute("class", "titleDate");
        let titleDateNow = new Date(entries[i].date);
        // let titleUnix = titleDateNow.getTime();
        let titleDay = document.createElement("p");
        titleDay.textContent = `${dayStr(titleDateNow.getDay())}, `;
        titleDiv.appendChild(titleDay);

        //
        let titleDate = document.createElement("p");
        // Parse int to remove leading zero (minus one because array is zero-indexed).
        let month = monthStr(parseInt(dateArr[1] - 1, 10));
        let day = dayToTh(parseInt(dateArr[2], 10));
        titleDate.textContent = `${month} ${day}`;
        titleDiv.appendChild(titleDate);
        sortDiv.appendChild(titleDiv);

        // let times = document.createElement("div");
        // times.setAttribute("class", "times");
        // times.textContent = "Times: ";
        // sortDiv.appendChild(times);

        let timeDiv = document.createElement("div");
        timeDiv.setAttribute("class", "timeDiv");
        let time = document.createElement("p");
        time.textContent = `${entries[i].time_start.slice(0, 5)}`;
        timeDiv.appendChild(time);
        sortDiv.appendChild(timeDiv);

        let deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Delete";
        deleteBtn.classList.add("delete");
        deleteBtn.setAttribute("data-date", `${entries[i].date}`);
        deleteBtn.setAttribute("data-time", `${entries[i].time_start}`);
        deleteBtn.addEventListener("click", deleteDateEntry);
        timeDiv.appendChild(deleteBtn);
        confirmed.appendChild(sortDiv);
      } else {
        const sortDiv = document.querySelector(`[data-idA=${CSS.escape(new Date(entries[i].date).getTime())}]`);
        let timeDiv = document.createElement("div");
        timeDiv.setAttribute("class", "timeDiv");
        let time = document.createElement("p");
        time.textContent = `${entries[i].time_start.slice(0, 5)}`;
        timeDiv.appendChild(time);

        let deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Delete";
        deleteBtn.classList.add("delete");
        deleteBtn.setAttribute("data-date", `${entries[i].date}`);
        deleteBtn.setAttribute("data-time", `${entries[i].time_start}`);
        deleteBtn.addEventListener("click", deleteDateEntry);
        timeDiv.appendChild(deleteBtn);
        sortDiv.appendChild(timeDiv);
      }
    }
    let deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete all entries";
    deleteBtn.addEventListener("click", deleteAllEntries);
    confirmed.appendChild(deleteBtn);
  }

  function deleteAllEntries() {
    const entries = document.querySelectorAll(".delete");
    let entriesArr = [];
    for (let entry of entries) {
      entriesArr.push({
        date: `${entry.dataset.date}`,
        time: `${entry.dataset.time}`,
      });
    }

    entriesArr = JSON.stringify(entriesArr);
    // console.log(entriesArr);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", `./index.php?action=deleteCalendarEntry&entry=${entriesArr}`);

    xhr.addEventListener("load", function () {
      location.reload();
      // console.log(xhr.responseText);
    });

    xhr.send(null);
  }

  function dateStrToArr(date) {
    return (dateArr = date.split("-"));
  }

  function dayToTh(day) {
    let th = day % 10;
    if (th == 1) {
      return `${day}st`;
    } else if (th == 2) {
      return `${day}nd`;
    } else if (th == 3) {
      return `${day}rd`;
    } else {
      return `${day}th`;
    }
  }

  function deleteDateEntry(e) {
    const enteredArr = [];
    enteredArr.push({
      date: `${e.target.dataset.date}`,
      time: `${e.target.dataset.time}`,
    });

    const entry = JSON.stringify(enteredArr);

    let xhr = new XMLHttpRequest();
    xhr.open("GET", `./index.php?action=deleteCalendarEntry&entry=${entry}`);

    xhr.addEventListener("load", function () {
      location.reload();
      // console.log(xhr.responseText);
    });

    xhr.send(null);
  }

  function deleteReservation(e) {
    let reserveID = e.target.dataset.cancelid;
    if (reserveID == undefined) {
      const cancels = document.querySelectorAll(".cancel");
      reserveID = [];
      for (let cancel of cancels) {
        reserveID.push({
          rID: `${cancel.dataset.cancelid}`,
        });
      }
      reserveID = JSON.stringify(reserveID);
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", `./index.php?action=cancelMeeting&reserveID=${reserveID}`);

    xhr.addEventListener("load", function () {
      location.reload();
      // console.log(xhr.responseText);
    });

    xhr.send(null);
  }
}

// function purgePrior(entries) {
//   console.log(entries);
//   let entriesArr = [];
//   for (let entry of entries) {
//     let entryUnix = parseInt(new Date(entry.date).getTime().toFixed(0));
//     let entryHour = entry.time_start.slice(0, 2);
//     let nowUnix = Date.now();
//     let entryCompare = Math.floor(entryUnix.toString().slice(0, 5));
//     let nowCompare = Math.floor(nowUnix.toString().slice(0, 5));
//     let nowHour = today.getHours();
//     if (entryCompare < nowCompare || (entryCompare == nowCompare && entryHour <= nowHour)) {
//       entriesArr.push({
//         date: `${entry.date}`,
//         time: `${entry.time_start}`,
//       });
//     }
//   }

//   entriesArr = JSON.stringify(entriesArr);
//   console.log(entriesArr);
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", `./index.php?action=deleteCalendarEntry&entry=${entriesArr}`);

//   xhr.addEventListener("load", function () {
//     // location.reload();
//   });

//   xhr.send(null);
// }

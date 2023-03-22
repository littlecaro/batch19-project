//use if statements to check if inputs exist bc this might be used on other pages

// // check if pwd are same
const userPwd = document.querySelector("#pwd");
const userPwd2 = document.querySelector("#pwdconf");

if (userPwd && userPwd2) {
  const validPwd =
    userPwd.value.length >= 4 && userPwd.value.length <= 16 ? true : false;
  const pwdConf =
    userPwd2.value.length >= 4 && userPwd2.value.length <= 16 ? true : false;
}

userPwd.addEventListener("keyup", checkPwd);

function checkPwd() {
  if (userPwd.value == userPwd2.value) {
    console.log("nice it works");
    // userPwd.className = "TODO:";
    // userPwd2.className = "TODO:";
    return true;
  } else {
    console.log("it doesn't work");
    // userPwd.className = "TODO:";
    // userPwd2.className = "TODO:";
    return false;
  }
}

userPwd2.addEventListener("keyup", checkPwd2);

function checkPwd2() {
  if (userPwd.value == userPwd2.value) {
    // userPwd.className = "TODO:";
    // userPwd2.className = "TODO:";
    return true;
  } else {
    // userPwd.className = "TODO:";
    // e.target.className = "TODO:";
    return false;
  }
}

let submit = document.querySelector("input[type='submit']");
submit.addEventListener("click", handleSubmit);

// function to check first name
// call that function on keyup inside the firstname input
// ALSO call that function on submit

if (firstName) {
  const firstName = document.querySelector("#firstName").value;
  const nameRegex = /^[a-z\- ]{2,30}$/i;
  document.querySelector("#firstName").addEventListener("keyup", firstName);
  function fName() {
    const validName2 = nameRegex.test(firstName);
    if (validName2) {
      // document.querySelector("#firstName").className = "TODO:";
      return true;
    } else {
      // document.querySelector("#firstName").className = "TODO:";
      return false;
    }
  }
}

const lastName = document.querySelector("#lastName").value;
if (lastName) {
  document.querySelector("#lastName").addEventListener("keyup", lastName);
  function lName() {
    const validName = nameRegex.test(lastName);
    if (validName) {
      // document.querySelector("#lastName").className = "TODO:";
      return true;
    } else {
      // document.querySelector("#lastName").className = "TODO:";
      return false;
    }
  }
}

const email = document.querySelector("#email").value;
if (email) {
  document.querySelector("#email").addEventListener("keyup", email);
  function checkEmail() {
    const validEmail = emailRegex.test(email);
    if (validEmail) {
      // document.querySelector("#email").className = "TODO:";
      return true;
    } else {
      // document.querySelector("#email").className = "TODO:";
      return false;
    }
  }
}
// // submit
let tooltip = document.querySelectorAll(".tooltip");
function handleSubmit(e) {
  if (lastName() && firstName() && checkEmail() && checkPwd() && checkPwd2()) {
    console.log("send");
  } else {
    // TODO: fix this
    // document.getElementsByClassName("span") = "input.red";
    e.preventDefault();
  }
}

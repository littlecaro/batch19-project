//use if statements to check if inputs exist bc this might be used on other pages

function showSignUp(userType) {
  var company = document.getElementById("company");
  company.style.display = "block";
  console.log(userType);
  const companyInputs = document.querySelectorAll(".company-input");
  if (userType !== "company") {
    for (let companyInput of companyInputs) {
      companyInput.style.display = "none";
    }
  } else {
    for (let companyInput of companyInputs) {
      companyInput.style.display = "table-row";
    }
  }
}
// function showSignUp() {
//   var singleUserSignUp = document.getElementById("singleUserSignUp");
//   if (singleUserSignUp.style.display == "none") {
//     singleUserSignUp.style.display = "block";
//   } else {
//     singleUserSignUp.style.display = "none";
//   }
// }

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
    userPwd.className = "green";
    userPwd2.className = "green";
    return true;
  } else {
    console.log("it doesn't work");
    userPwd.className = "red";
    userPwd2.className = "red";
    return false;
  }
}

userPwd2.addEventListener("keyup", checkPwd2);

function checkPwd2() {
  if (userPwd.value == userPwd2.value) {
    userPwd.className = "green";
    userPwd2.className = "green";
    return true;
  } else {
    userPwd.className = "red";
    userPwd2.target.className = "red";
    return false;
  }
}

let submit = document.querySelector("button[type='submit']");
submit.addEventListener("click", handleSubmit);
// function to check first name
// call that function on keyup inside the firstname input
// ALSO call that function on submit

const nameRegex = /^[a-z\- ]{2,30}$/i;

document.querySelector("#fName").addEventListener("keyup", firstName);
function firstName() {
  const userName2 = document.querySelector("#fName").value;
  const validName2 = nameRegex.test(userName2);
  if (validName2) {
    document.querySelector("#fName").className = "green";
    return true;
  } else {
    document.querySelector("#fName").className = "red";
    return false;
  }
}

document.querySelector("#lName").addEventListener("keyup", lastName);
function lastName() {
  const userName = document.querySelector("#lName").value;
  const validName = nameRegex.test(userName);
  if (validName) {
    document.querySelector("#lName").className = "green";
    console.log("nameworks");
    return true;
  } else {
    document.querySelector("#lName").className = "red";
    console.log("namenotworks");
    return false;
  }
}

const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
document.querySelector("#email").addEventListener("keyup", checkEmail);
function checkEmail() {
  const email = document.querySelector("#email").value;
  const validEmail = emailRegex.test(email);
  if (validEmail) {
    console.log("works");
    document.querySelector("#email").className = "green";
    return true;
  } else {
    document.querySelector("#email").className = "red";
    console.log("NAWTworks");
    return false;
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

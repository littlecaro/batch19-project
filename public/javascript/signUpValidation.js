//use if statements to check if inputs exist bc this might be used on other pages
let whichFormOpen = "";
function showSignUp(userType) {
  // var company = document.getElementById("company");
  // company.style.display = "block";
  // console.log(userType);

  const account = document.getElementById("createAccount");
  if (account.style.maxHeight == 0) {
    if (userType === "company") {
      whichFormOpen = "company";
      account.style.maxHeight = "600px";
    } else {
      whichFormOpen = "user";
      account.style.maxHeight = "500px";
    }
  }

  const companyInputs = document.querySelectorAll(".company-input");
  if (userType !== "company") {
    for (let companyInput of companyInputs) {
      companyInput.style.display = "none";
    }
  } else {
    for (let companyInput of companyInputs) {
      companyInput.style.display = "table-row";
    }
    account.style.maxHeight = "600px";
  }
}

// // check if pwd are same
const userPwd = document.querySelector("#pwd");
const userPwd2 = document.querySelector("#pwdconf");

if (userPwd && userPwd2) {
  const validPwd = userPwd.value.length >= 8 ? true : false;
  const pwdConf = userPwd2.value.length >= 8 ? true : false;
}

userPwd.addEventListener("keyup", checkPwd);

function checkPwd() {
  checkPwd2();
  if (userPwd.value.length >= 8) {
    userPwd.className = "green";
    // userPwd2.className = "green";
    document.querySelector("#pwd~span").className = "";
    document.querySelector("#pwd~span").textContent = "";
    return true;
  } else {
    userPwd.className = "red";
    // userPwd2.className = "red";
    document.querySelector("#pwd~span").className = "invalid";
    document.querySelector("#pwd~span").textContent = "Password must be at least 8 characters.";
    return false;
  }
}

userPwd2.addEventListener("keyup", checkPwd2);

function checkPwd2() {
  if (userPwd.value && userPwd.value == userPwd2.value) {
    userPwd.className = "green";
    userPwd2.className = "green";
    document.querySelector("#pwd~span").className = "";
    document.querySelector("#pwd~span").textContent = "";
    document.querySelector("#pwdconf~span").className = "";
    document.querySelector("#pwdconf~span").textContent = "";
    return true;
  } else {
    // userPwd.className = "red";
    userPwd2.className = "red";
    document.querySelector("#pwdconf~span").className = "invalid";
    document.querySelector("#pwdconf~span").textContent = "Passwords must match.";
    return false;
  }
}

let form = document.querySelector("form");
form.addEventListener("submit", handleSubmit);
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
    document.querySelector("#fName~span").className = "";
    document.querySelector("#fName~span").textContent = "";
    return true;
  } else {
    document.querySelector("#fName").className = "red";
    document.querySelector("#fName~span").className = "invalid";
    document.querySelector("#fName~span").textContent = "First name must be between 2 and 30 letters.";
    return false;
  }
}

document.querySelector("#lName").addEventListener("keyup", lastName);
function lastName() {
  const userName = document.querySelector("#lName").value;
  const validName = nameRegex.test(userName);
  if (validName) {
    document.querySelector("#lName").className = "green";
    document.querySelector("#lName~span").className = "";
    document.querySelector("#lName~span").textContent = "";
    return true;
  } else {
    document.querySelector("#lName").className = "red";
    document.querySelector("#lName~span").className = "invalid";
    document.querySelector("#lName~span").textContent = "Last name must be between 2 and 30 letters.";
    return false;
  }
}

//use name regex
document.querySelector("#companyname").addEventListener("keyup", companyName);

function companyName() {
  const companyName1 = document.querySelector("#companyname").value;
  const validCompany = nameRegex.test(companyName1);
  if (validCompany) {
    document.querySelector("#companyname").className = "green";
    document.querySelector("#companyname~span").className = "";
    document.querySelector("#companyname~span").textContent = "";
    return true;
  } else {
    document.querySelector("#companyname").className = "red";
    document.querySelector("#companyname~span").className = "invalid";
    document.querySelector("#companyname~span").textContent = "Company name must be between 2 and 30 characters.";
    return false;
  }
}

document.querySelector("#companytitle").addEventListener("keyup", companyTitle);

function companyTitle() {
  const companyTitle1 = document.querySelector("#companytitle").value;
  const validCompany = nameRegex.test(companyTitle1);
  if (validCompany) {
    document.querySelector("#companytitle").className = "green";
    document.querySelector("#companytitle~span").className = "";
    document.querySelector("#companytitle~span").textContent = "";
    return true;
  } else {
    document.querySelector("#companytitle").className = "red";
    document.querySelector("#companytitle~span").className = "invalid";
    document.querySelector("#companytitle~span").textContent = "Company title must be between 2 and 30 characters";
    return false;
  }
}

const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
document.querySelector("#email").addEventListener("keyup", checkEmail);
function checkEmail() {
  const email = document.querySelector("#email").value;
  const validEmail = emailRegex.test(email);
  if (validEmail) {
    document.querySelector("#email").className = "green";
    document.querySelector("#email~span").className = "";
    document.querySelector("#email~span").textContent = "";
    return true;
  } else {
    document.querySelector("#email").className = "red";
    document.querySelector("#email~span").className = "invalid";
    document.querySelector("#email~span").textContent = "Email appears to be invalid.";
    return false;
  }
}

// // submit
function handleSubmit(e) {
  const lastNameGood = lastName();
  const firstNameGood = firstName();
  const checkEmailGood = checkEmail();
  const checkPwdGood = checkPwd();
  const checkPwd2Good = checkPwd2();
  const companyCheckGood = companyName();
  const companyTitleGood = companyTitle();

  if (
    whichFormOpen === "company" &&
    lastNameGood &&
    firstNameGood &&
    checkEmailGood &&
    checkPwdGood &&
    checkPwd2Good &&
    companyCheckGood &&
    companyTitleGood
  ) {
    console.log("send");
  } else if (whichFormOpen === "user" && lastNameGood && firstNameGood && checkEmailGood && checkPwdGood && checkPwd2Good) {
    console.log("cats2");
  } else {
    console.log("cats");
    e.preventDefault();
  }
}

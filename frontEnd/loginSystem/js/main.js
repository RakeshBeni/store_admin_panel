function isValidEmail(email) {
  // Regular expression for a simple email validation
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Test the email against the regular expression
  return emailRegex.test(email);
}

function isStrongPassword(password) {
  var digitRegex = /\d/;
  return password.length > 5 && digitRegex.test(password);
}

let emailChecked = false;
let strongPassword = false;
let samepassword = false;

function checkEmail(e) {
  const errorStatus = document.getElementById("invalidEmail");
  emailChecked = isValidEmail(e.value);
  if (!emailChecked) {
    e.classList.add("error");
    errorStatus.classList.remove("d-none");
    document.getElementById('alreadyEmail').classList.add('d-none')
    e.classList.remove("success");
  } else {
    e.classList.remove("error");
    errorStatus.classList.add("d-none");
    e.classList.add("success");

  }
}

function checkStrongPassword(e) {
  const errorStatus = document.getElementById("passerror");
  const re_pass = document.getElementById("re_pass");
  strongPassword = isStrongPassword(e.value);
  if (!strongPassword) {
    errorStatus.classList.remove("d-none");
    e.classList.add("error");
    e.classList.remove("success");
  } else {
    re_pass.removeAttribute("disabled");
    errorStatus.classList.add("d-none");
    e.classList.remove("error");
    e.classList.add("success");
  }
}

document.getElementById("re_pass").addEventListener("keyup", function (e) {
  const errorStatus = document.getElementById("repasserror");
  const pass = document.getElementById("pass").value;
  // console.log('pass' , pass)
  if (e.target.value === pass) {
    samepassword = true;
    errorStatus.classList.add("d-none");
    e.target.classList.remove("error");
    e.target.classList.add("success");
  } else {
    samepassword = false;

    // re_pass.removeAttribute("disabled");
    errorStatus.classList.remove("d-none");
    e.target.classList.add("error");
    e.target.classList.remove("success");
  }
});
let email;

function submitForm(e) {
  document.getElementById("sendOtpbutton").classList.add("d-none");
  document.getElementById("waitbutton").classList.remove("d-none");
  console.log();
  if (emailChecked && strongPassword && samepassword) {
    const name = document.getElementById("name").value;
    email = document.getElementById("email").value;
    const pass = document.getElementById("pass").value;
    const dataToSend = {
      name,
      email,
      pass,
    };

    console.log(dataToSend);

    fetch("./backend/sendOtp.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(dataToSend),
    })
      .then((response) => response.text())
      .then((data) => {
        console.log(data);
        if (data === "Email Send") {
   
          document.getElementById("otpDiv").classList.remove("d-none");
          document.getElementById("waitbutton").classList.add("d-none");
          document.getElementById("applyOtp").classList.remove("d-none");
        }else if(data === "Already Email"){
          document.getElementById("email").classList.remove("success");
          document.getElementById("email").classList.add("error");
          document.getElementById("alreadyEmail").classList.remove("d-none");
          document.getElementById("sendOtpbutton").classList.remove("d-none");
          document.getElementById("waitbutton").classList.add("d-none");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}

function submitOtp(){
  const otp = document.getElementById('OTP').value;

  const dataToSend = {
    email,
    otp
  };

  fetch("./backend/signup.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data);
       if(data === 'loginSuccess'){
        window.location.href = "../index.php";
      }
 
    })
    .catch((error) => {
      console.error("Error:", error);
    });


}

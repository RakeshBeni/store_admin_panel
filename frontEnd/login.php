<?php
include "./connection.php";


session_start();

if (isset($_SESSION['user'])) {
    header('location:index.php');
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = mysqli_query($conn, "SELECT * FROM `customers` WHERE BINARY `email` = '$_POST[username]'");
    $rownum = mysqli_num_rows($sql);

    if($rownum<1){
        echo "<script> alert('Invalid Email')</script>";
    }else{
        $sql1 = mysqli_query($conn, "SELECT * FROM `customers` WHERE BINARY `email` = '$_POST[username]' AND BINARY `password` = '$_POST[password]'");
        $rownum1 = mysqli_num_rows($sql1);
        if($rownum1>0){
            $row = mysqli_fetch_assoc($sql1);
            
            $_SESSION['user'] = "$row[Name]" ;
            $_SESSION['userId'] = "$row[userId]" ;
            header('location:index.php');
        }else{
            echo "<script> alert('Invalid password')</script>";

        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
html,body{
  display: grid;
  height: 100%;
  width: 100%;
  place-items: center;
  background: -webkit-linear-gradient(left, #003366,#004080,#0059b3
, #0073e6);
}
::selection{
  background: #1a75ff;
  color: #fff;
}
.wrapper{
  overflow: hidden;
  max-width: 390px;
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
}
.wrapper .title-text{
  display: flex;
  width: 200%;
}
.wrapper .title{
  width: 50%;
  font-size: 35px;
  font-weight: 600;
  text-align: center;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.wrapper .slide-controls{
  position: relative;
  display: flex;
  height: 50px;
  width: 100%;
  overflow: hidden;
  margin: 30px 0 10px 0;
  justify-content: space-between;
  border: 1px solid lightgrey;
  border-radius: 15px;
}
.slide-controls .slide{
  height: 100%;
  width: 100%;
  color: #fff;
  font-size: 18px;
  font-weight: 500;
  text-align: center;
  line-height: 48px;
  cursor: pointer;
  z-index: 1;
  transition: all 0.6s ease;
}
.slide-controls label.signup{
  color: #000;
}
.slide-controls .slider-tab{
  position: absolute;
  height: 100%;
  width: 50%;
  left: 0;
  z-index: 0;
  border-radius: 15px;
  background: -webkit-linear-gradient(left,#003366,#004080,#0059b3
, #0073e6);
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
input[type="radio"]{
  display: none;
}
#signup:checked ~ .slider-tab{
  left: 50%;
}
#signup:checked ~ label.signup{
  color: #fff;
  cursor: default;
  user-select: none;
}
#signup:checked ~ label.login{
  color: #000;
}
#login:checked ~ label.signup{
  color: #000;
}
#login:checked ~ label.login{
  cursor: default;
  user-select: none;
}
.wrapper .form-container{
  width: 100%;
  overflow: hidden;
}
.form-container .form-inner{
  display: flex;
  width: 200%;
}
.form-container .form-inner form{
  width: 50%;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.form-inner form .field{
  height: 50px;
  width: 100%;
  margin-top: 20px;
}
.form-inner form .field input{
  height: 100%;
  width: 100%;
  outline: none;
  padding-left: 15px;
  border-radius: 15px;
  border: 1px solid lightgrey;
  border-bottom-width: 2px;
  font-size: 17px;
  transition: all 0.3s ease;
}
.form-inner form .field input:focus{
  border-color: #1a75ff;
  /* box-shadow: inset 0 0 3px #fb6aae; */
}
.form-inner form .field input::placeholder{
  color: #999;
  transition: all 0.3s ease;
}
form .field input:focus::placeholder{
  color: #1a75ff;
}
.form-inner form .pass-link{
  margin-top: 5px;
}
.form-inner form .signup-link{
  text-align: center;
  margin-top: 30px;
}
.form-inner form .pass-link a,
.form-inner form .signup-link a{
  color: #1a75ff;
  text-decoration: none;
}
.form-inner form .pass-link a:hover,
.form-inner form .signup-link a:hover{
  text-decoration: underline;
}
form .btn{
  height: 50px;
  width: 100%;
  border-radius: 15px;
  position: relative;
  overflow: hidden;
}
form .btn .btn-layer{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  background: -webkit-linear-gradient(right,#003366,#004080,#0059b3
, #0073e6);
  border-radius: 15px;
  transition: all 0.4s ease;;
}
form .btn:hover .btn-layer{
  left: 0;
}
form .btn input[type="submit"]{
  height: 100%;
  width: 100%;
  z-index: 1;
  position: relative;
  background: none;
  border: none;
  color: #fff;
  padding-left: 0;
  border-radius: 15px;
  font-size: 20px;
  font-weight: 500;
  cursor: pointer;
}

.otp-input, .email-otp-input {
    width: 40px;
    height: 40px;
    text-align: center;
    font-size: 18px;
    margin: 0 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s;
}

.otp-input:focus, .email-otp-input:focus {
    border-color: #007bff;
}
</style>
</head>
<body>
<div class="wrapper">
      <div class="title-text">
        <div class="title login">Login Form</div>
        <div class="title signup">Signup Form</div>
      </div>
      <div class="form-container">
        <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Login</label>
          <label for="signup" class="slide signup">Signup</label>
          <div class="slider-tab"></div>
        </div>
        <div class="form-inner">
          <form action="" class="login" method="post">
            <div class="field">
              <input type="text" name="username" placeholder="Email Address" required>
            </div>
            <div class="field">
              <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="pass-link"><a href="#">Forgot password?</a></div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
            <div class="signup-link">Not a member? <a href="">Signup now</a></div>
          </form>
          <form action="#" class="signup">
            <div class="field">
              <input type="text" placeholder="Email Address" required>
            </div>
            <div class="field">
              <input type="password" placeholder="Password" required>
            </div>
            <div class="field">
              <input type="password" placeholder="Confirm password" required>
            </div>

            

            <div class="email-otp-container" style="margin-top: 20px;">
            <!-- Six input fields for OTP digits -->
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1">
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1" disabled>
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1" disabled>
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1" disabled>
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1" disabled>
            <input type="text" class="email-otp-input" pattern="\d" maxlength="1" disabled>
        </div>


            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Send OTP">
            </div>
          </form>
        </div>
      </div>
    </div>
    
<script>
     const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
        signupBtn.click();
        return false;
      });

      document.addEventListener("DOMContentLoaded", function () {
      var otpInputs = document.querySelectorAll(".otp-input");
      var emailOtpInputs = document.querySelectorAll(".email-otp-input");

      function setupOtpInputListeners(inputs) {
        inputs.forEach(function (input, index) {
          input.addEventListener("paste", function (ev) {
            var clip = ev.clipboardData.getData('text').trim();
            if (!/^\d{6}$/.test(clip)) {
              ev.preventDefault();
              return;
            }

            var characters = clip.split("");
            inputs.forEach(function (otpInput, i) {
              otpInput.value = characters[i] || "";
            });

            enableNextBox(inputs[0], 0);
            inputs[5].removeAttribute("disabled");
            inputs[5].focus();
            updateOTPValue(inputs);
          });

          input.addEventListener("input", function () {
            var currentIndex = Array.from(inputs).indexOf(this);
            var inputValue = this.value.trim();

            if (!/^\d$/.test(inputValue)) {
              this.value = "";
              return;
            }

            if (inputValue && currentIndex < 5) {
              inputs[currentIndex + 1].removeAttribute("disabled");
              inputs[currentIndex + 1].focus();
            }

            if (currentIndex === 4 && inputValue) {
              inputs[5].removeAttribute("disabled");
              inputs[5].focus();
            }

            updateOTPValue(inputs);
          });

          input.addEventListener("keydown", function (ev) {
            var currentIndex = Array.from(inputs).indexOf(this);

            if (!this.value && ev.key === "Backspace" && currentIndex > 0) {
              inputs[currentIndex - 1].focus();
            }
          });
        });
      }

      function enableNextBox(input, currentIndex) {
        var inputValue = input.value;

        if (inputValue === "") {
          return;
        }

        var nextIndex = currentIndex + 1;
        var nextBox = otpInputs[nextIndex] || emailOtpInputs[nextIndex];

        if (nextBox) {
          nextBox.removeAttribute("disabled");
        }
      }

      function updateOTPValue(inputs) {
        var otpValue = "";

        inputs.forEach(function (input) {
          otpValue += input.value;
        });

        if (inputs === otpInputs) {
          document.getElementById("verificationCode").value = otpValue;
        } else if (inputs === emailOtpInputs) {
          document.getElementById("emailverificationCode").value = otpValue;
        }
      }

      setupOtpInputListeners(otpInputs);
      setupOtpInputListeners(emailOtpInputs);

      otpInputs[0].focus(); // Set focus on the first OTP input field
      emailOtpInputs[0].focus(); // Set focus on the first email OTP input field

      otpInputs[5].addEventListener("input", function () {
        updateOTPValue(otpInputs);
      });

      emailOtpInputs[5].addEventListener("input", function () {
        updateOTPValue(emailOtpInputs);
      });
    });
</script>
</body>
</html>
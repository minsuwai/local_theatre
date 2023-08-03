<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login&Register</title>
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

  <!-- css -->
  <link rel="stylesheet" href="css/style.css">

  <!-- icon -->
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

</head>

<body>
  <!-- header section -->
  <?php include "header.php" ?>

  <section id="login_register_form">
    <div class="register_form">
      <span class="formmsg" id="formmsg"></span><br>
      <div class="title">Registration</div>
      <div class="content">
        <form class="formstyle" id="register" method="post" onshow="true" autocomplete="off">
          <span class="gender-title">Gender</span>
          <select name="gender" id="title" class="forminput">
            <option value="Female">Female</option>
            <option value="Male">Male</option>
            <option value="Others">Others</option>
          </select>
          <div class="user-details">
            <div class="input-box">
              <span class="details">Username</span>
              <input type="text" placeholder="Enter your username" class="forminput" type="text" name="uname" id="uname"
                required>
            </div>

            <div class="input-box">
              <span class="details">Email</span>
              <input type="email" placeholder="Enter your email" class="forminput" type="text" name="uemail" id="uemail"
                onkeyup="Checkemail()" required>
              <span id="emailmsg" class="errormsg"></span>
            </div>

            <div class="input-box">
              <span class="details">Password</span>
              <input placeholder="Enter your password" class="forminput" type="password" name="upassword" id="upassword"
                required>
              <span class="password-message" id="passwordMessage">
                Password must contain Capital Letter and special character (@, $, !, &, etc).<br>
                Password length must be greater than 8 characters.
              </span>
              <div id="strength-bar" class="strength">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
              </div>
            </div>
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input type="password" placeholder="Confirm your password" class="forminput" type="password"
                name="cpassword" id="cpassword" onkeyup="matchPassword()" required>
              <span id="cpwmsg" class="errormsg"></span>
            </div>
            <div class="input-box">
              <span class="details">Phone Number</span>
              <input type="text" placeholder="Enter your phone number" class="forminput" type="text" name="ph_no" id="ph_no"
                onkeyup="Checkemail()" required>
              <span id="emailmsg" class="errormsg"></span>
            </div>
            <div class="input-box">
              <span class="details">Birth Date</span>
              <input class="forminput" type="date" name="udob" id="udob" onchange="CalculateAge()">
              <span id="dobmsg" class="errormsg"></span>
            </div>
          </div>
          <div class="input_box checkbox_option">
            <input type="checkbox" name="agree" id="agree">
            <label for="agree">I agree with terms and conditions</label>
          </div>
          <div class="button">
            <input class="formbutton" type="submit" value="Register" name="register" id="register">
          </div>
          <div class="text sign-up-text">
            Already have an account?
            <label for="flip"><a href="login.php">Login</a> now</label>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script src="js/register.js"></script>
  <script src="js/checkpassword.js"></script>
  <script>
    document.onreadystatechange = function () {
      prepareRegister();
    }
  </script>

  <!-- footer section -->
  <?php include "footer.php" ?>
</body>

</html>

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
         
          <div class="gender-details" name="title" id="title" class="forminput">
            <input type="radio" name="gender" id="dot-1" value="Male" class="rgender">
            <input type="radio" name="gender" id="dot-2" value="Female" class="rgender">
            <input type="radio" name="gender" id="dot-3" value="Other" class="rgender">
            <span class="gender-title">Gender</span>
            <div class="category">
              <label for="dot-1">
                <span class="dot one"></span>
                <span class="gender" >Male</span>
              </label>
              <label for="dot-2">
                <span class="dot two"></span>
                <span class="gender">Female</span>
              </label>
              <label for="dot-3">
                <span class="dot three"></span>
                <span class="gender">Prefer not to say</span>
              </label>
            </div>
          </div>
          <button id= "submit">Submit</button>
         
          

           
           
        </form>
      </div>
    </div>
  </section>
<script>
    document.getElementById('submit').onclick= function(){
    var value= document.getElementsByName('gender');
    for (var radio of value){
    if (radio.checked) {    
            // $_SESSION['gender']=radio.value;
            var a=radio.value;
                        }
    }}
    alert(a);
    // var title=$_SESSION['gender'];
    // console.log(title);
    
    
</script>

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
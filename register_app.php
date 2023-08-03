<?php
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $ph_no = mysqli_real_escape_string($conn, $_POST['ph_no']);

    if ($title == '' || $uname == '' || $dob == '' || $email == '' || $password == '' || $ph_no == '') {
        echo "Please fill in all the required fields.";
    } else {
        $utype = 2; // Set the default user type to 2 (User)

        // Map user types to database values
        if ($title == 'admin') {
            $utype = 1;
        } elseif ($title == 'suspended') {
            $utype = 3;
        }

        mysqli_query($conn, "INSERT INTO member (user_name, dob, gender, email, upassword, ph_no, utype, tnc) VALUES ('$uname', '$dob', '$title', '$email', md5('$password'), '$ph_no', $utype, 1)");
        session_start();
        $_SESSION['username'] = $uname;
        $_SESSION['registered'] = true;
        $msg = "Registration successful. Please log in.";
        // Display the login form
        ?>
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
             <style>
                .register_form .title{
                    display: none;
                }
             </style>
        </head>

        <body>



            <!-- <section id="login_register_form"> -->
                <!-- <div class="login_form"> -->
                    <div class="title">Login</div>
                    <div class="content">
                        <?php echo $msg; ?>
                        <form action="login.php" method="post">
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <?php if ($_SESSION['username'] == '') { ?>
                                        <input type="text" placeholder="Enter your username" class="forminput" type="text" name="uname" id="uname" required>
                                    <?php } else { ?>
                                        <input type="text" placeholder="Enter your username" class="forminput" type="text" name="uname" id="uname" value="<?php echo $_SESSION['username'] ?>" required>
                                    <?php } ?>
                                </div>
                                <div class="input-box">
                                    <span class="details">Password</span>
                                    <input placeholder="Enter your password" class="forminput" type="password" name="upassword" id="upassword" required>
                                </div>
                            </div>
                            <div class="button">
                                <input type="submit" value="Login" name="login" class="formbutton">
                            </div>
                            <!-- <div class="text sign-up-text">
                                Don't have an account?
                                <label for="flip"><a href="register.php">Register</a> now</label>
                            </div> -->
                        </form>
                    </div>
                <!-- </div> -->
            <!-- </section> -->


        </body>

        </html>
        <?php
        exit();
    }
}
?>

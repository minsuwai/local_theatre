<?php
//session_start();
// sessionid is regenerated
session_regenerate_id();
$sessionid = session_id();
// include('function.php');

// Check if the user is already logged in
if (isset($_SESSION['uname'])) {
    $uname = $_SESSION['uname'];
    $sql_array = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE user_name='$uname'"));
    $_SESSION['usertype'] = $sql_array['utype'];
    if ($_SESSION['usertype'] == 1) {
        header("Location: admin_dashboard.php");
        exit();
    } elseif ($_SESSION['usertype'] == 2) {
        header("Location: index.php");
        exit();
    } else {
        header("Location: suspense.php");
        exit();
    }
}
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

</head>

<body>
    <!-- header section -->
    <?php include "header.php" ?>

    <?php
    $msg = '';
    if (isset($_POST['login'])) {
        $username = $_POST['uname'];
        $password = $_POST['upassword'];
        if ($username == '' || $password == '') {
            $msg = "Please fill in your username and password.";
        } else {
            $sql = mysqli_query($conn, "SELECT * FROM member WHERE user_name='$username' AND upassword='$password'");
            $num_row = mysqli_num_rows($sql);
            if ($num_row > 0) {
                mysqli_query($conn, "UPDATE member SET session_str='$sessionid' WHERE user_name='$username'");
                $_SESSION['uname'] = $username;
                $uname = $_SESSION['uname'];
                $sql_array = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM member WHERE user_name='$uname'"));
                $_SESSION['usertype'] = $sql_array['utype'];
                if ($_SESSION['usertype'] == 1) {
                    header("Location: admin_dashboard.php");
                    exit();
                } elseif ($_SESSION['usertype'] == 2) {
                    header("Location: index.php");
                    exit();
                } else {
                    header("Location: suspense.php");
                    exit();
                }
            } else {
                $msg = "Wrong username or password.";
            }
        }
    }
    ?>

    <section id="login_register_form">
        <div class="login_form">
            <div class="title">Login</div>
            <div class="content">
                <?php echo $msg; ?>
                <form action="login.php" method="post">
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Username</span>
                            <input type="text" placeholder="Enter your username" class="forminput" name="uname" id="uname" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Password</span>
                            <input placeholder="Enter your password" class="forminput" type="password" name="upassword" id="upassword" required>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Login" name="login" class="formbutton">
                    </div>
                    <div class="text sign-up-text">
                        Don't have an account?
                        <label for="flip"><a href="register.php">Register</a> now</label>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- footer section -->
    <?php include "footer.php" ?>
</body>

</html>

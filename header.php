<?php
// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
  die(mysqli_connect_error());
}

// Start session
// session_start();

// Check if the user is a suspended user
$isSuspended = false;
if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 3) {
  $isSuspended = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- css -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
  <style>
    .suspended-bar {
      background-color: red;
      color: white;
      padding: 10px;
      text-align: center;
      animation: running-notification 20s linear infinite;
      white-space: nowrap;
      overflow: hidden;
      position: absolute;
      top: 75px;
      /* Update this line to top: 0 */
      width: 90%;
      /* left: 0; */
    }

    @keyframes running-notification {
      /* 0% {
        transform: translateX(100%);
      } */

      100% {
        transform: translateX(-100%);
      }
    }



    @media (max-width: 768px) {
      .suspended-bar {
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
      }
    }
  </style>
</head>

<body>
  <header>


    <div class="logo">
      <a href="index.php">Local <span>Theatre</span></a>
    </div>
    <nav class="nav" id="nav_menu">
      <i class="fa-solid fa-xmark" id="header_close"></i>
      <ul class="nav_list">
      <li class="nav_item">
          <!-- Add the search form to the header -->
          <form action="search.php" class="navbar_form" method="post">
            <input type="text" name="search" id="navbar_search_input" placeholder="I am looking for..." class="navbar_form_search">
            <button type="submit" class="navbar_form_btn">
              <i class="fa fa-search"></i>
            </button>
          </form>
        </li>
        <li class="nav_item"><a href="index.php" class="nav_link">Home</a></li>
        <li class="nav_item"><a href="scene.php" class="nav_link">Scene</a></li>
        <li class="nav_item"><a href="contact_us.php" class="nav_link">Contact</a></li>

        <?php
        // Check if the user is logged in
        if (isset($_SESSION['uname'])) {
          $user_name = $_SESSION['uname'];

          // Check if the user is an admin
          $query = "SELECT * FROM member WHERE user_name = '$user_name' AND utype = '1'";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            // User is an admin
            ?>
            <li class="nav_item">
              <a href="#" class="nav_link">Welcome
                <?php echo ucfirst($user_name); ?><i class="fa-solid fa-chevron-down"></i>
              </a>
              <ul class="dropdown">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          <?php } else { ?>
            <li class="nav_item">
              <a href="#" class="nav_link">Welcome
                <?php echo $user_name; ?><i class="fa-solid fa-chevron-down"></i>
              </a>
              <ul class="dropdown">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          <?php } ?>
        <?php } else { ?>
          <li class="nav_item"><a href="login.php" class="nav_link">Sign in <i
                class="fa-solid fa-right-to-bracket"></i></a></li>
        <?php } ?>
      </ul>
    </nav>
    <i class="fa-solid fa-bars" id="header_toggle"></i>

  </header>
  <!-- Add the suspended bar if the user is suspended -->
  <?php if ($isSuspended): ?>
    <div class="suspended-bar">You are a suspended user. Contact the admin.</div>
  <?php endif; ?>

  <script>
    const navMenu = document.getElementById('nav_menu'),
      toggleMenu = document.getElementById('header_toggle'),
      closeMenu = document.getElementById('header_close');

    toggleMenu.addEventListener('click', () => {
      navMenu.classList.toggle('show');
    });

    closeMenu.addEventListener('click', () => {
      navMenu.classList.remove('show');
    });

    /* Toggle dropdown menu on click */
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach((dropdown) => {
      const link = dropdown.previousElementSibling;
      link.addEventListener('click', () => {
        dropdown.classList.toggle('show');
      });
    });

    /* Hide dropdown menu when clicking outside */
    window.addEventListener('click', (event) => {
      dropdowns.forEach((dropdown) => {
        if (!dropdown.contains(event.target)) {
          dropdown.classList.remove('show');
        }
      });
    });

  </script>
</body>

</html>
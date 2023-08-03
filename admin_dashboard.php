<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

// Function to retrieve the total count of comments
function getTotalCommentCount($conn)
{
    $query = "SELECT COUNT(*) AS total_comment_count FROM comments";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Query execution failed
        die("Error fetching comment count: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total_comment_count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
</head>
<body>
    <!-- header section -->
    <?php include "header.php" ?>

    <!-- Main Section -->
    <section id="admin_dash">
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>
        <div class="row">
            <div class="sidebar">
                <ul>
                    <li><a href="admin_dashboard.php" class="sidebar-link">Dashboard</a></li>
                    <li><a href="add_article.php" class="sidebar-link">Add Article</a></li>
                    <li><a href="user_manage.php" class="sidebar-link">Users Manage</a></li>
                    <li><a href="post_manage.php" class="sidebar-link">Post Manage</a></li>
                    <li><a href="#" class="sidebar-link">Settings</a></li>
                </ul>
            </div>
            <div class="main">
                <h2>Dashboard</h2>
                <p>Welcome to the admin dashboard</p>
                <div class="cards reveal">
                    <div class="card">
                        <h3>Active Views</h3>
                        <p>125,436</p>
                    </div>
                    <div class="card">
                        <h3>Likes</h3>
                        <p>98,765</p>
                    </div>
                    <div class="card">
                        <h3>Comments</h3>
                        <p><?php echo getTotalCommentCount($conn); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section -->
    <?php include "footer.php" ?>

    <script>
        const links = document.querySelectorAll('.sidebar a');

        links.forEach(link => {
          link.addEventListener('click', () => {
            links.forEach(otherLink => otherLink.classList.remove('active'));
            link.classList.add('active');
          });
        });

        const currentUrl = window.location.href;

        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(sidebarLink => {
          if (sidebarLink.href === currentUrl) {
            sidebarLink.classList.add('active');
          }
        });

		$(document).ready(function () {
            $('.reveal').css('opacity', 0);
            $('.reveal').waypoint(function () {
                $('.reveal').addClass('fadeInUp');
            }, { offset: 'bottom-in-view' });
        });
    </script>
</body>
</html>

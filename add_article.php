<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Article</title>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
</head>

<body>
    <?php
    // Step 1: Establish a database connection
    $conn = mysqli_connect("localhost", "root", "", "local_theatre2");
    if (!$conn) {
        die(mysqli_connect_error());
    }

    // Step 2: Process the form submission
$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $title = $_POST['title'];
    $categories = $_POST['categories'];
    $releaseYear = $_POST['release_year'];
    $description = $_POST['comment'];

    // File upload handling
    $file = $_FILES['file-upload'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileError = $file['error'];

    if ($fileError === UPLOAD_ERR_OK) {
        // Move the uploaded file to a permanent location
        $targetDir = 'uploads/';
        $targetPath = $targetDir . $fileName;
        move_uploaded_file($fileTmpName, $targetPath);

        // Determine if it's a new article or editing an existing one
        $postID = isset($_POST['post_id']) ? $_POST['post_id'] : null;
        if ($postID) {
            // Editing an existing article
            $query = "UPDATE blog SET b_title = '" . mysqli_real_escape_string($conn, $title) . "', b_category = '" . mysqli_real_escape_string($conn, $categories) . "', b_releaseyear = '" . mysqli_real_escape_string($conn, $releaseYear) . "', b_desc = '" . mysqli_real_escape_string($conn, $description) . "', b_image = '$targetPath' WHERE b_id = '$postID'";
            $successMessage = 'Post edited successfully.';
        } else {
            // Adding a new article
            $query = "INSERT INTO blog (b_title, b_category, b_releaseyear, b_desc, b_image, c_time) VALUES ('" . mysqli_real_escape_string($conn, $title) . "','" . mysqli_real_escape_string($conn, $categories) . "', '" . mysqli_real_escape_string($conn, $releaseYear) . "', '" . mysqli_real_escape_string($conn, $description) . "', '$targetPath', NOW())";
            $successMessage = 'Post added successfully.';
        }

        if (mysqli_query($conn, $query)) {
            // Post operation successful
            $successMessage = 'Post added successfully.';
        } else {
            // Error occurred while adding/editing the post
            $errorMessage = 'Error: ' . mysqli_error($conn);
        }
    } else {
        // Error occurred during file upload
        $errorMessage = 'Error uploading file. Error code: ' . $fileError;
    }
}
    ?>


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
                <h2>Add Article</h2>

                <?php if (!empty($successMessage)) { ?>
                    <div class="success-message">
                        <?php echo $successMessage; ?>
                    </div>
                <?php } ?>

                <?php if (!empty($errorMessage)) { ?>
                    <div class="error-message">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php } ?>
                <?php
                // ...
                
                // Retrieve the post ID from the query parameter
                if (isset($_GET['edit'])) {
                    $postID = $_GET['edit'];

                    // Fetch the post data based on the post ID
                    $query = "SELECT * FROM blog WHERE b_id = '$postID'";
                    $result = mysqli_query($conn, $query);
                    $postData = mysqli_fetch_assoc($result);
                }

                // ...
                ?>

                <!-- Form fields for adding/editing an article -->
                <form class="content-form reveal" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="post_id"
                        value="<?php echo isset($postData) ? $postData['b_id'] : ''; ?>">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter Title..." required
                        value="<?php echo isset($postData) ? $postData['b_title'] : ''; ?>">
                    <label for="categories">Categories</label>
                    <input type="text" id="categories" name="categories" placeholder="Enter Categories..." required
                        value="<?php echo isset($postData) ? $postData['b_category'] : ''; ?>">
                    <label for="release_year">Release Year</label>
                    <input type="text" id="release_year" name="release_year" placeholder="Enter Release Year" required
                        value="<?php echo isset($postData) ? $postData['b_releaseyear'] : ''; ?>">
                    <label for="comment">Description</label>
                    <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Enter Description..."
                        required><?php echo isset($postData) ? $postData['b_desc'] : ''; ?></textarea>
                    <label for="file-upload">Image Upload</label>
                    <input type="file" id="file-upload" name="file-upload" required>
                    <button type="submit">Add Content</button>
                </form>

            </div>
        </div>
    </section>

    <!-- footer section -->
    <?php include "footer.php" ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        // Reveal animation
        $(document).ready(function () {
            $('.content-form').css('opacity', 0);
            $('.content-form').waypoint(function () {
                $('.content-form').addClass('fadeInUp');
            }, { offset: 'bottom-in-view' });
        });

        // Mobile navigation
        const headerOpen = document.getElementById('header_open');
        const headerClose = document.getElementById('header_close');
        const navMenu = document.getElementById('nav_menu');

        headerOpen.addEventListener('click', () => {
            navMenu.classList.add('active');
        });

        headerClose.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });
    </script>
</body>

</html>
<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}


// Get the b_id from the query parameter
if (isset($_GET['b_id'])) {
    $b_id = $_GET['b_id'];

    // Fetch the data for the specified b_id
    $sql = "SELECT * FROM blog WHERE b_id = $b_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Handle the case when no data is found for the specified b_id
        // For example, display an error message or redirect to another page
        die("No data found");
    }
} else {
    // Handle the case when b_id is not provided in the query parameter
    // For example, display an error message or redirect to another page
    die("Invalid request");
}

// Check if the user is suspended
$isSuspended = false;
if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 3) {
    $isSuspended = true;
}

// Check if the user is not logged in
$isNotLoggedIn = !isset($_SESSION['uname']);

// Handle comment submission
if (isset($_POST['comment'])) {
    if ($isNotLoggedIn) {
        // Handle the case when the user is not logged in
        die("You need to log in to comment.");
    } elseif ($isSuspended) {
        // Handle the case when the user is suspended
        die("Contact the admin to comment.");
    } else {
        $c_text = $_POST['comment'];
        $c_time = date('Y-m-d');
        $c_poster = '';

        // Retrieve the commenter's name from the "member" table
        if (isset($_SESSION['uname'])) {
            $member_id = $_SESSION['uname'];
            $c_poster = $member_id;
        }

        // Insert the comment into the database
        $insertQuery = "INSERT INTO comments (c_text, c_time, c_poster, mainarticle) VALUES ('$c_text', '$c_time', '$c_poster', $b_id)";
        mysqli_query($conn, $insertQuery);
    }
}

// Fetch existing comments for the article
$commentsQuery = "SELECT * FROM comments WHERE mainarticle = $b_id";
$commentsResult = mysqli_query($conn, $commentsQuery);
$comments = mysqli_fetch_all($commentsResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scene</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- icon -->
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

    <style>
        .right {
            float: right;
            width: 75%;
            padding-left: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 20px;
        }

        .detail img {
            width: 100%;
            height: auto;
        }

        .right .text {
            margin-left: 20px;
        }

        .right .title {
            font-weight: bold;
        }

        .comment-button {
            margin-top: 20px;
        }

        .comment-box {
            display: none;
            margin-top: 20px;
        }

        .comment-box textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            resize: none;
        }

        .comment-box .submit-button {
            margin-top: 10px;
        }

        .comments-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
            margin-top: 20px;
            margin-left: 0;
            color: black;
        }

        .comments-container h3 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .comment {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
        }

        .comment-author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-text {
            font-size: 14px;
        }

        /* Optional styles */
        /* .comment:nth-child(even) {
            background-color: white;
        } */

        .comment:last-child {
            margin-bottom: 0;
        }

        .delete-button {
            margin-top: 10px;
            /* Add some spacing between c_time and delete-button */
        }


        @media (max-width: 767px) {
            .right {
                grid-template-columns: 1fr;
                width: 100%;
                padding: 0;
            }

            .detail .column {
                margin-bottom: 20px;
            }

            .comments-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>


    <!-- Contents section -->
    <section id="content">
        <h1 class="text-center section-heading-moviescard">Detail Of Movies</h1>

        <div class="row">
            <div class="leftcolumn ">

                <div class="card">
                    <h2>About Me</h2>
                    <div class="fakeimg" style="height:100px;">
                        <img src="images/vikins.jpg" alt="">
                    </div>
                    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                </div>

                <div class="card">
                    <h3>Popular Post</h3>
                    <div class="fakeimg">
                        <img src="images/spider-man-no-way-home.jpg" alt="">
                    </div><br>
                    <div class="fakeimg">
                        <img src="images/sci-fi.jpg" alt="">
                    </div><br>
                    <div class="fakeimg">
                        <img src="images/planet.jpg" alt="">
                    </div>
                </div>
                <div class="card">
                    <h3>Follow Me</h3>
                    <p>Some text..</p>
                </div>
            </div>

            <div class="right detail">
                <!-- Right column content -->
                <div class="column img">
                    <img src="<?php echo $row['b_image']; ?>" alt="" class="poster_img">
                </div>
                <div class="column text">
                    <h2>
                        <?php echo $row['b_title']; ?>
                    </h2>
                    <p>
                        <?php echo $row['b_desc']; ?>
                    </p>
                    <br>
                    <div>
                        <?php if ($isSuspended): ?>
                            <p style="color: red;">Contact the admin to comment.</p>
                        <?php elseif ($isNotLoggedIn): ?>
                            <p style="color: red;">You need to <a href="login.php">log in</a> or <a
                                    href="register.php">register</a> to comment.</p>
                        <?php else: ?>
                            <button class="comment-button" onclick="toggleCommentBox()">Comment</button>
                            <div class="comment-box" id="commentBox">
                                <form method="POST" action="">
                                    <textarea name="comment" placeholder="Enter your comment"></textarea>
                                    <button type="submit" class="submit-button">Submit</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="comments-container">
                    <h3>Comments</h3>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment" data-comment-id="<?php echo $comment['c_id']; ?>">
                            <div class="comment-author">
                                <?php echo ucfirst($comment['c_poster']); ?>
                            </div>
                            <div class="comment-text">
                                <?php echo $comment['c_text']; ?>
                            </div>
                            <div class="comment-info">
                                <div class="comment-time">
                                    <?php echo $comment['c_time']; ?>
                                </div>
                                <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 1): ?>
                                    <!-- Display the delete button only for admin users -->
                                    <button class="delete-button"
                                        onclick="confirmDelete(<?php echo $comment['c_id']; ?>)">Delete</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>




            </div>
        </div>
    </section>

    <?php include "footer.php" ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="js/zoom.js"></script>
    <script>
        const revealItems = document.querySelectorAll('.reveal_item');
        let lastScrollTop = 0;

        function revealItem() {
            const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

            revealItems.forEach(item => {
                const top = item.getBoundingClientRect().top;
                const isRevealed = item.classList.contains('reveal_item--visible');

                if (top + 30 < window.innerHeight && top > 0) {
                    if (!isRevealed || currentScrollTop < lastScrollTop) {
                        item.classList.add('reveal_item--visible');
                    }
                } else {
                    if (isRevealed) {
                        // item.classList.remove('reveal_item--visible');
                    }
                }
            });

            lastScrollTop = currentScrollTop;
        }

        window.addEventListener('scroll', revealItem);

        const rightcolumn = document.querySelectorAll('.carousel_block');
        const pagination = document.querySelector('.pagination');
        const prev = pagination.querySelector('.prev');
        const pages = pagination.querySelectorAll('.page');
        const next = pagination.querySelector('.next');

        const cardsPerPage = 9;
        const totalPages = Math.ceil(rightcolumn.length / cardsPerPage);
        let current = 0;

        function showPage(page) {
            const start = page * cardsPerPage;
            const end = start + cardsPerPage;
            let anyCardsDisplayed = false;
            rightcolumn.forEach((carousel_block, index) => {
                if (index >= start && index < end) {
                    carousel_block.style.display = 'block';
                    anyCardsDisplayed = true;
                } else {
                    carousel_block.style.display = 'none';
                }
            });
            if (anyCardsDisplayed) {
                pagination.style.position = 'static';
            } else {
                pagination.style.bottom = '15px';
            }
            pages[current].classList.remove('active');
            pages[page].classList.add('active');
            current = page;
        }

        function showNext() {
            if (current < totalPages - 1) {
                showPage(current + 1);
            }
        }

        function showPrev() {
            if (current > 0) {
                showPage(current - 1);
            }
        }

        // Initially display only the first page of cards
        showPage(0);

        prev.addEventListener('click', showPrev);
        next.addEventListener('click', showNext);

        pages.forEach((page, index) => {
            page.addEventListener('click', () => {
                showPage(index);
            });
        });

        const fadeElems = document.querySelectorAll('.fade-in');

        function checkFade() {
            fadeElems.forEach(fadeElem => {
                const fadePos = fadeElem.getBoundingClientRect().top;
                const windowHeight = window.innerHeight / 1.5;

                if (fadePos < windowHeight) {
                    fadeElem.classList.add('fade-in--visible');
                } else {
                    fadeElem.classList.remove('fade-in--visible');
                }
            });
        }

        window.addEventListener('scroll', checkFade);

        function toggleCommentBox() {
            const commentBox = document.getElementById('commentBox');
            if (commentBox.style.display === 'none') {
                commentBox.style.display = 'block';
            } else {
                commentBox.style.display = 'none';
            }
        }

        function confirmDelete(commentId) {
            const result = confirm("Are you sure you want to delete this comment?");
            if (result) {
                // User clicked "Ok," send the AJAX request to delete the comment
                deleteComment(commentId);
            }
        }

        function deleteComment(commentId) {
            // Use AJAX to send the request to delete the comment
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // The comment was deleted successfully, remove it from the DOM
                    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                    if (commentElement) {
                        commentElement.remove();
                    }
                }
            };
            xhttp.open("POST", "delete_comment.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(`comment_id=${commentId}`);
        }
    </script>
</body>

</html>
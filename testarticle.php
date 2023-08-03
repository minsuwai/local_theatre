<?php
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
            /* margin-left: 20px; */
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
        <h1 class="text-center section-heading-moviescard reveal_item">All Movies</h1>

        <div class="row">
            <div class="leftcolumn ">

                <div class="card">
                    <h2>About Me</h2>
                    <div class="fakeimg" style="height:100px;">Image</div>
                    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                </div>

                <div class="card">
                    <h3>Popular Post</h3>
                    <div class="fakeimg">Image</div><br>
                    <div class="fakeimg">Image</div><br>
                    <div class="fakeimg">Image</div>
                </div>
                <div class="card">
                    <h3>Follow Me</h3>
                    <p>Some text..</p>
                </div>
            </div>

            <div class="right detail">
                <!-- Right column content -->
                <div class="column img">
                    <img src="<?php echo $row['b_image']; ?>" alt="">
                </div>
                <div class="column text">
                    <h2>
                        <?php echo $row['b_title']; ?>
                    </h2>
                    <p>
                        <?php echo $row['b_desc']; ?>
                    </p>

                    <div>
                        <button class="comment-button" onclick="toggleCommentBox()">Comment</button>
                        <div class="comment-box" id="commentBox">
                            <textarea placeholder="Enter your comment"></textarea>
                            <button class="submit-button">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="comments-container">
                    <h3>Comments</h3>

                    <div class="comment">
                        <div class="comment-author">John Doe</div>
                        <div class="comment-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                    </div>

                    <div class="comment">
                        <div class="comment-author">Jane Smith</div>
                        <div class="comment-text">Praesent gravida lectus nec pharetra tempus.</div>
                    </div>

                    <div class="comment">
                        <div class="comment-author">Jane Smith</div>
                        <div class="comment-text">Praesent gravida lectus nec pharetra tempus.</div>
                    </div>

                    <!-- Additional comments can be added here -->

                </div>



            </div>
        </div>
    </section>

    <?php include "footer.php" ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
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
                // pagination.style.position = 'absolute';
                pagination.style.bottom = '15px';
                // pagination.style.left = '50%';
                // pagination.style.transform = 'translateX(-50%)';
                // pagination.style.display = 'flex';
                // pagination.style.justify-content = 'center';
                // pagination.style.align-items = 'center';
                // pagination.style.margin-top = '15px';
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

        //         // Select the leftcolumn div
        // const leftcolumn = document.getElementById('leftcolumn');

        // // Listen for scroll events
        // window.addEventListener('scroll', () => {
        //   // Calculate the position of the leftcolumn div relative to the viewport
        //   const leftcolumnPosition = leftcolumn.getBoundingClientRect().top;

        //   // If the leftcolumn div is in the viewport, fade it in
        //   if (leftcolumnPosition < window.innerHeight) {
        //     leftcolumn.style.left = '0';
        //     leftcolumn.style.opacity = 1;
        //   }
        // });
        const fadeElems = document.querySelectorAll('.fade-in');

        function checkFade() {
            fadeElems.forEach(fadeElem => {
                const elemTop = fadeElem.getBoundingClientRect().top;
                const elemBottom = fadeElem.getBoundingClientRect().bottom;
                const windowHeight = window.innerHeight;

                if (elemTop < windowHeight && elemBottom >= 0) {
                    fadeElem.classList.add('visible');
                } else {
                    fadeElem.classList.remove('visible');
                }
            });
        }

        window.addEventListener('load', checkFade);
        window.addEventListener('scroll', checkFade);
        window.addEventListener('resize', checkFade);


        function toggleCommentBox() {
            const commentBox = document.getElementById('commentBox');
            commentBox.style.display = commentBox.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>
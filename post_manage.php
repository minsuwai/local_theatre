<?php
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM blog");

$c_time = date('Y-m-d');
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
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM blog ORDER BY b_id DESC");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="card carousel_block">
                                <h2>
                                    <?php echo $row['b_title'] ?>
                                </h2>
                                <h5>
                                    <?php echo $row['b_category'] ?>
                                </h5>
                                <div class="fakeimg">
                                    <a href="article_detail.php?b_id=<?php echo $row['b_id']; ?>">
                                        <img src="<?php echo $row['b_image'] ?>" alt="">
                                    </a>
                                </div>
                                <h4>Description</h4>
                                <p>
                                    <?php echo $row['b_desc'] ?>
                                </p>
                                <hr class="dotted-line">
                                <div class="post_meta">
                                    <span class="cat">Posted by <a href="#">Admin</a></span> |
                                    <span class="cat">Date:
                                        <?php echo $c_time; ?>
                                    </span> |
                                    <a href="article_detail.php?b_id=<?php echo $row['b_id']; ?>">
                                        <a href="">Comments</a>
                                    </a>
                                </div>
                                <div class="card-buttons">
                                    <a href="add_article.php?edit=<?php echo $row['b_id']; ?>" class="edit-button"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <button class="delete-button" data-postid="<?php echo $row['b_id']; ?>"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>

                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="pagination">
                        <a href="#admin_dash" class="prev">Previous</a>
                        <a href="#admin_dash" class="page active">1</a>
                        <a href="#admin_dash" class="page">2</a>
                        <a href="#admin_dash" class="page">3</a>

                        <a href="#admin_dash" class="next">Next</a>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- footer section -->
    <?php include "footer.php" ?>
    <script src="js/delete_post.js"></script>
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
                        item.classList.remove('reveal_item--visible');
                    }
                }
            });

            lastScrollTop = currentScrollTop;
        }

        window.addEventListener('scroll', revealItem);

        const cards = document.querySelectorAll('.card');
        const pagination = document.querySelector('.pagination');
        const prev = pagination.querySelector('.prev');
        const pages = pagination.querySelectorAll('.page');
        const next = pagination.querySelector('.next');

        const cardsPerPage = 9;
        const totalPages = Math.ceil(cards.length / cardsPerPage);
        let current = 0;

        function showPage(page) {
            const start = page * cardsPerPage;
            const end = start + cardsPerPage;
            let anyCardsDisplayed = false;
            cards.forEach((card, index) => {
                if (index >= start && index < end) {
                    card.style.display = 'block';
                    anyCardsDisplayed = true;
                } else {
                    card.style.display = 'none';
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

        $(document).ready(function () {
            $('.reveal').css('opacity', 0);
            $('.reveal').waypoint(function () {
                $('.reveal').addClass('fadeInUp');
            }, { offset: 'bottom-in-view' });
        });

// $(document).ready(function() {
//   $('.reveal').hide().fadeIn(1000);
// });



    </script>
</body>

</html>
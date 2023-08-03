<?php
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}
// Assuming you have already verified the login credentials and fetched the user data from the database
// $user['utype'] should contain the user type value (1, 2, or 3)
// $_SESSION['usertype'] = $user['utype'];


session_start(); // Start the session if it's not already started

// Check if the user is logged in and the 'usertype' session variable is set
if (!isset($_SESSION['usertype'])) {
    // Redirect users who are not logged in to the login page or home page
    header('Location: login.php'); // Replace 'login.php' with your login page URL
    exit;
}

// Now, check if the user is suspended (user type 3)
if ($_SESSION['usertype'] === '3') {
    // Redirect suspended users to a page notifying them about their suspension
    header('Location: suspended_page.php');
    exit;
}

$c_time = date('Y-m-d');
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

</head>

<style>
    .row {
        color: black;
    }
</style>

<body>
    <?php include "header.php" ?>

    <!-- tranding section -->
    <section id="tranding">
        <div class="container">
            <h3 class="text-center section-subheading">- Popular Delivery -</h3>
            <h1 class="text-center section-heading-moviescard">Tranding Movies</h1>
        </div>
        <div class="container">
            <div class="swiper tranding-slider" data-aos="fade-up" data-aos-delay="300">
                <div class="swiper-wrapper">
                    <!-- Slide-start -->
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM blog");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="swiper-slide tranding-slide">
                                <div class="tranding-slide-img">
                                    <a href="article_detail.php?b_id=<?php echo $row['b_id']; ?>">
                                        <img src="<?php echo $row['b_image'] ?>" alt="Tranding">
                                    </a>
                                </div>
                                <div class="tranding-slide-content">
                                    <!-- <h1 class="food-price">$20</h1> -->
                                    <div class="tranding-slide-content-bottom">
                                        <h2 class="food-name">
                                            <?php echo $row['b_title'] ?>
                                        </h2>
                                        <h3 class="food-rating">
                                            <span>4.5</span>
                                            <div class="rating">
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                                <ion-icon name="star"></ion-icon>
                                            </div>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>

                    <!-- Slide-end -->

                </div>

                <div class="tranding-slider-control">
                    <div class="swiper-button-prev slider-arrow">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </div>
                    <div class="swiper-button-next slider-arrow">
                        <ion-icon name="arrow-forward-outline"></ion-icon>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- search section -->
    <!-- <section id="search_section">
        <div class="navbar_actions">
            <form action="#" class="navbar_form">
                <input type="text" name="search" id="" placeholder="I am looking for..." class="navbar_form_search">
                <button class="navbar_form_btn">
                    <ion-icon name="search-outline"></ion-icon>
                </button>
            </form>
        </div>

    </section> -->



    <!-- main section -->
    <!-- <section id="main">
        <h1 class="text-center section-heading-moviescard reveal_item">Upcoming Movies</h1>
        <div class="container">
            <div class="content reveal">
                <div class="main_image reveal_item">
                    <img src="images/action.jpg" alt="">
                </div>
                <div class="info reveal_item">
                    <h4 class="info_title">Description</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime distinctio tenetur molestiae
                        cupiditate voluptates sequi at quaerat veniam eaque unde asperiores aut, non reprehenderit
                        possimus alias cum quidem libero error.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="content reveal">
                <div class="main_image reveal_item">
                    <img src="images/action.jpg" alt="">
                </div>
                <div class="info reveal_item">
                    <h4 class="info_title">Description</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime distinctio tenetur molestiae
                        cupiditate voluptates sequi at quaerat veniam eaque unde asperiores aut, non reprehenderit
                        possimus alias cum quidem libero error.
                    </p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="content reveal">
                <div class="main_image reveal_item">
                    <img src="images/action.jpg" alt="">
                </div>
                <div class="info reveal_item">
                    <h4 class="info_title">Description</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime distinctio tenetur molestiae
                        cupiditate voluptates sequi at quaerat veniam eaque unde asperiores aut, non reprehenderit
                        possimus alias cum quidem libero error.
                    </p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Contents section -->
    <section id="content">
        <h1 class="text-center section-heading-moviescard reveal_item">All Movies</h1>

        <div class="row">
            <div class="leftcolumn ">
                <div class="card fade-in">
                    <h2>About Me</h2>
                    <div class="fakeimg" style="height:100px;">
                        <img src="images/vikins.jpg" alt="">
                    </div>
                    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                </div>
                <div class="card fade-in">
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
                <div class="card fade-in">
                    <h3>Follow Me</h3>
                    <p>Some text..</p>
                </div>
            </div>
            <!-- <div class="infinite-carousel"> -->
            <!-- <div id="carousel" class="carousel-wrapper"> -->
            <div class="rightcolumn carousel-items reveal">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM blog ORDER BY b_id DESC ");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>


                        <div class="card carousel_block reveal_item">
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
                                Comments</a>
                                
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>

                <div class="pagination">
                    <a href="#content" class="prev">Previous</a>
                    <a href="#content" class="page active">1</a>
                    <a href="#content" class="page">2</a>
                    <a href="#content" class="page">3</a>

                    <a href="#content" class="next">Next</a>
                </div>
                <!-- <div class="nav">
        <button id="prev" class="carousel-button-left btn">prev</button>
        <button id="next" class="carousel-button-right btn">next</button>
    </div> -->

            </div>
            <!-- </div> -->
            <!-- </div> -->


        </div>
    </section>

    <?php include "footer.php" ?>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 'auto',
            autoplay: {
                delay: 3000, // set delay between slides in milliseconds
            },
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 100,
                modifier: 2.5,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }


        });

        //         var swiper = new Swiper('.trending-slider', {
        //     autoplay: {
        //       delay: 5000, // set delay between slides in milliseconds
        //     },
        //     // other options go here
        //   });

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

    </script>
</body>

</html>
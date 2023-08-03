<?php
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}
?>

<?php
// Check if the cookie has been set
$cookieName = "user_cookie_consent";
$cookieValue = "accepted";
$expirationTime = time() + (86400 * 30); // 30 days in seconds

if (!isset($_COOKIE[$cookieName])) {
    // Set the cookie if it hasn't been set before
    setcookie($cookieName, $cookieValue, $expirationTime, "/");
} else {
    // Retrieve the cookie value
    $cookieValue = $_COOKIE[$cookieName];
}

// Check if the user has accepted all cookies
$acceptAllCookies = ($cookieValue === "accepted");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Theatre</title>

    <!-- css -->
    <link rel="stylesheet" href="css/style.css" />

    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

    <style>
        .reveal_item {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .reveal_item.reveal_item--visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cookie-consent-banner {
            position: fixed;
            bottom: 10%;
            left: 70%;
            transform: translate(-50%, 50%);
            width: 30%;
            padding: 10px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
            text-align: center;
            justify-content: center;
        }

        .cookie-consent-banner__text {
            font-size: 14px;
            margin-bottom: 10px;
            color: black;
        }

        .cookie-consent-banner__button {
            padding: 6px 12px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        @media screen and (max-width: 768px) {
            .cookie-consent-banner {
                bottom: 30%;
            }

            .wrapper .dynamic_txts li {
                font-size: 20px;
            }

            .banner{
                width: 100% !important;
                /* height: auto !important; */
                border: none !important;
                border-radius: none !important;
                overflow: none !important;
                border: 0px solid #fffff !important;
                box-shadow: none !important;
                /* position: relative; */
            }

            .banner video{
                margin-top:-170px !important ;
                /* object-fit: cover!important; */
                /* height: 300px !important; */
            }

            .dynamic_txts{
                display: none !important;
            }

            
        }
    </style>
    
</head>

<body>

    <?php include "header.php" ?>

    <!-- Main Section -->
    <main>
        <!-- Banner Section -->
        <section class="banner">
            <video loop src="video/john wick.webm" autoplay muted class="banner_video" >
                Your browser does not support the video tag.
            </video>
            <!-- <img src="images/action.jpg" alt=""> -->

            <div class="wrapper video-overlay">
                <!-- <div class="static_txt">
                    This is 
                </div> -->
                <ul class="dynamic_txts">
                    <li><span>LOCAL THEATRE</span></li>
                    <li><span>Get Ready For An</span></li>
                    <li><span>Unforgettable Cinematic Experience</span></li>
                    <li><span>that will leave you</span></li>
                    <li><span>on the edge of your seat</span></li>
                </ul>
            </div>
        </section>
    </main>
    <!-- End of Main Section -->

    <!-- Movie Section -->
    <section class="movies">
        <!-- filter bar -->
        <div class="filter_bar">
            <div class="filter_dropdowns">
                <select name="genre" id="" class="genre">
                    <option value="all genres">All genres</option>
                    <option value="action">Action</option>
                    <option value="adventure">Adventure</option>
                    <option value="animal">Animal</option>
                    <option value="animation">Animation</option>
                    <option value="biography">Biography</option>
                </select>

                <select name="year" id="" class="year">
                    <option value="all genres">All the years</option>
                    <option value="2022">2022</option>
                    <option value="2020-2021">2020-2021</option>
                    <option value="2010-2019">2010-2019</option>
                    <option value="2000-2009">2000-2009</option>
                    <option value="1980-1999">1980-1999</option>
                </select>
            </div>

            <div class="filter_radios">
                <input type="radio" name="grade" id="featured" checked>
                <label for="featured">Featured</label>

                <input type="radio" name="grade" id="popular">
                <label for="popular">Popular</label>

                <input type="radio" name="grade" id="newest">
                <label for="newest">Newest</label>

                <div class="checked_radio_bg"></div>
            </div>
        </div>

        <div class="movies_grid reveal">
            <?php
            $sql = "SELECT * FROM blog ORDER BY b_id DESC LIMIT 24 ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $index = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="movie_card reveal_item">
                        <div class="card_head">
                            <a href="article_detail.php?b_id=<?php echo $row['b_id']; ?>">
                                <!-- Add a wrapper div for the image with a class "zoom-container" -->
                                <div class="zoom-container">
                                    <img src="<?php echo $row['b_image'] ?>" alt="" class="card_img zoom-image" style="object-fit: cover;">
                                </div>
                                <div class="card_overlay">
                                    <div class="bookmark">
                                        <i class="fa-regular fa-bookmark"></i>
                                    </div>
                                    <div class="rating">
                                        <i class="fa-regular fa-star"></i>
                                        <span>6.4</span>
                                    </div>
                                    <div class="play">
                                        <i class="fa-regular fa-circle-play"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card_body">
                            <h3 class="card_title">
                                <?php echo $row['b_title'] ?>
                            </h3>
                            <div class="card_info">
                                <span class="genre">
                                    <?php echo $row['b_category'] ?>
                                </span>
                                <span class="year">
                                    <?php echo $row['b_releaseyear'] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $index++;
                }
            }
            ?>
        </div>
        <!-- load more button -->
        <button class="load_more reveal_item">LOAD MORE</button>
    </section>

    <!-- category section -->
    <section class="category" id="category">
        <h2 class="section_heading_category">Category</h2>
        <div class="category_grid">
            <div class="category_card">
                <img src="./images/action.jpg" alt="" class="card_img">
                <div class="name">Action</div>
                <div class="total">100</div>
            </div>
            <div class="category_card">
                <img src="./images/comedy.jpg" alt="" class="card_img">
                <div class="name">Comedy</div>
                <div class="total">100</div>
            </div>
            <div class="category_card">
                <img src="./images/horror.jpg" alt="" class="card_img">
                <div class="name">Horror</div>
                <div class="total">100</div>
            </div>
            <div class="category_card">
                <img src="./images/adventure.jpg" alt="" class="card_img">
                <div class="name">Adventure</div>
                <div class="total">100</div>
            </div>
            <div class="category_card">
                <img src="./images/sci-fi.jpg" alt="" class="card_img">
                <div class="name">Sci-Fi</div>
                <div class="total">100</div>
            </div>
            <div class="category_card">
                <img src="./images/action.jpg" alt="" class="card_img">
                <div class="name">Action</div>
                <div class="total">100</div>
            </div>
            <!-- Rest of the category cards... -->
        </div>
    </section>

    <!-- footer section  -->
    <?php include "footer.php" ?>

    <!-- Cookie consent banner -->
    <?php if (!$acceptAllCookies) { ?>
        <div class="cookie-consent-banner">
            <div class="cookie-consent-banner__text">
                This website uses cookies to enhance your experience. By accepting all cookies, you agree to our use of
                cookies.
            </div>
            <button class="cookie-consent-banner__button" onclick="acceptAllCookies()">Accept All Cookies</button>
        </div>
    <?php } ?>
    <!-- <script src="js/zoom.js"></script> -->
    <script>
        

        // animation
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

        // Function to set the "Accept All Cookies" cookie
        function acceptAllCookies() {
            // Update the cookie value
            document.cookie = "user_cookie_consent=accepted; expires=<?php echo date('D, d M Y H:i:s', $expirationTime); ?> GMT; path=/";

            // Remove the cookie consent banner
            var cookieConsentBanner = document.querySelector(".cookie-consent-banner");
            if (cookieConsentBanner) {
                cookieConsentBanner.parentNode.removeChild(cookieConsentBanner);
            }
        }
    </script>
</body>

</html>
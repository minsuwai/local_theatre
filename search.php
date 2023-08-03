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
        }
    </style>
</head>

<body>

    <?php include "header.php" ?>

    <!-- Main Section -->
    
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

       <!-- search album -->
       <?php include "search_view.php" ?>
           <!-- End of search album -->
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
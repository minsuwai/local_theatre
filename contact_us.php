<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Theatre</title>

    <!-- css -->
    <!-- <link rel="stylesheet" href="css/contactus.css" /> -->
    <link rel="stylesheet" href="css/style.css" />

    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

</head>


<body>
    <!-- header section -->
    <?php include "header.php" ?>

    <!-- main section -->
    <section id="contactus">
        <!-- <img src="images/movie_bg.jpg" alt=""> -->
        <div class="container">

            <div class="form">
            <!-- <div class="map" class="contactus_column">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1014.6229020214677!2d96.13336676062788!3d16.802644288988386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1678336076392!5m2!1sen!2smm" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen></iframe>
            
      </div> -->
                <div class="contact-info">
                    <h3 class="title">Let's get in touch</h3>
                    <p class="text">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe
                        dolorum adipisci recusandae praesentium dicta!
                    </p>

                    <div class="info">
                        <div class="information">

                            <p>92 Cherry Drive Uniondale, NY 11553</p>
                        </div>
                        <div class="information">

                            <p>lorem@ipsum.com</p>
                        </div>
                        <div class="information">

                            <p>123-456-789</p>
                        </div>
                    </div>

                    <div class="social-media">
                        <p>Connect with us :</p>
                        <div class="social-icons">
                            <a href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div><br>
                        <div class="credit">Made with <span style="color:tomato">❤</span> by <a
                                href="https://www.learningrobo.com/">Min Su Wai</a></div>
                    </div>
                </div>

                <div class="contact-form">
                    <span class="circle one"></span>
                    <span class="circle two"></span>

                    <form action="index.html" autocomplete="off">
                        <h3 class="title">Contact us</h3>
                        <div class="input-container">
                            <input type="text" name="name" class="input" />
                            <label for="">Username</label>
                            <span>Username</span>
                        </div>
                        <div class="input-container">
                            <input type="email" name="email" class="input" />
                            <label for="">Email</label>
                            <span>Email</span>
                        </div>
                        <div class="input-container">
                            <input type="tel" name="phone" class="input" />
                            <label for="">Phone</label>
                            <span>Phone</span>
                        </div>
                        <div class="input-container textarea">
                            <textarea name="message" class="input"></textarea>
                            <label for="">Message</label>
                            <span>Message</span>
                        </div>
                        <input type="submit" value="Send" class="btn" />
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- footer section  -->
    <?php include "footer.php" ?>

    <script>

        const inputs = document.querySelectorAll(".input");

        function focusFunc() {
            let parent = this.parentNode;
            parent.classList.add("focus");
        }

        function blurFunc() {
            let parent = this.parentNode;
            if (this.value == "") {
                parent.classList.remove("focus");
            }
        }

        inputs.forEach((input) => {
            input.addEventListener("focus", focusFunc);
            input.addEventListener("blur", blurFunc);
        });


    </script>
</body>

</html>
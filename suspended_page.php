<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspended User | Local Theatre</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">

    <!-- Custom Styles for Suspended Page -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 30px;
            color: #ff3300;
        }

        h5 {
            text-align: center;
            color: #666;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .back-btn {
            display: block;
            width: 120px;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #ff3300;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #e60000;
        }
    </style>

</head>

<body>

    <!-- Header Section -->
    <?php include "header.php" ?>

    <!-- Suspended User Content -->
    <div class="container">
        <h1>Account Suspended</h1>
        <h5>You are a suspended user and cannot access certain features at the moment.</h5>
        <h5>If you believe this is an error or have any concerns, please contact our support team for further assistance.</h5>
        <!-- <a href="contact.php" class="back-btn">Contact Support</a> -->
    </div>

    <!-- Footer Section -->
    <?php include "footer.php" ?>

</body>

</html>

<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

// Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['uname'])) {
    // Redirect to the login page or handle this case as per your requirement
    header("Location: login.php");
    exit();
}

// Get the user's username from the session
$username = $_SESSION['uname'];

// Fetch user data from the database
$sql = "SELECT user_name, dob, gender, email, ph_no, utype FROM member WHERE user_name = '$username'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    // Handle the case when no data is found for the specified username
    die("User not found");
}

// Fetch user data as an associative array
$userData = mysqli_fetch_assoc($result);

// Map user types to their corresponding names
$userTypes = [
    1 => 'Admin',
    2 => 'User',
    3 => 'Suspended'
];

// Handle user deletion
if (isset($_POST['delete_user'])) {
    // Get the user ID from the user's data
    $userId = $_SESSION['user_id'];

    // Delete the user from the database
    $deleteQuery = "DELETE FROM member WHERE member_id = $userId";
    mysqli_query($conn, $deleteQuery);

    // Perform any additional clean-up or logout operations here if needed
    // For example, you can unset or destroy the session to log out the user
    session_unset();
    session_destroy();

    // Redirect the user to the login page or any other appropriate page after deletion
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
</head>

<style>
    .profile-container{
        margin: 5% auto;
        width: 70%;
        border: solid black 2px;
        padding: 30px;
        /* text-align: center; */
        /* align-items: center; */
    }

    table{
        font-family: Arial, Helvetica, sans-serif;
        /* background-color:#f9f9f9 ; */
        color: #6c757d;
        border-collapse: collapse;
        width: 30%;
    }
    tr{
        height:40px;
        vertical-align : middle!important;
        line-height: normal !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width:8em;
        min-width:8em;
        word-wrap: break-word;
        
    }
</style>
<body>
    <?php include "header.php"; ?>

    <div class="profile-container">
        <h1>Profile Page</h1>
        <table>
            <tr>
                <td>Name:</td>
                <td><?php echo $userData['user_name']; ?></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><?php echo $userData['dob']; ?></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><?php echo $userData['gender']; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $userData['email']; ?></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td><?php echo $userData['ph_no']; ?></td>
            </tr>
            <tr>
                <td>User Type:</td>
                <td><?php echo $userTypes[$userData['utype']]; ?></td>
            </tr>
        </table>

        <!-- <form method="POST" action="">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <button type="submit" name="delete_user">Delete User</button>
        </form> -->
    </div>

    <?php include "footer.php"; ?>
</body>

</html>

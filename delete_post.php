<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Write the SQL query to delete the post from the database
    $deleteQuery = "DELETE FROM blog WHERE b_id = '$postId'";

    if (mysqli_query($conn, $deleteQuery)) {
        // Post deleted successfully
        mysqli_close($conn);
        header("Location: post_manage.php");
        exit();
    } else {
        // Error occurred while deleting the post
        $errorMessage = "Error deleting post: " . mysqli_error($conn);
    }
} else {
    // Invalid post ID
    $errorMessage = "Invalid post ID.";
}

// Close the database connection
mysqli_close($conn);
?>

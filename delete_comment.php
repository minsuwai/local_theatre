<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

// Check if the comment_id is provided in the POST request
if (isset($_POST['comment_id'])) {
    $commentId = $_POST['comment_id'];

    // Delete the comment from the database
    $deleteQuery = "DELETE FROM comments WHERE c_id = $commentId";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "success"; // Return a success message
    } else {
        echo "failure"; // Return a failure message
    }
}
?>

<?php
// update_user_type.php

// update_user_type.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the member ID and user type are provided
    if (isset($_POST['memberId']) && isset($_POST['userType'])) {
        $memberId = $_POST['memberId'];
        $userType = $_POST['userType'];

        // Map the user type string to corresponding values
        $userTypeValues = [
            'admin' => 1,
            'user' => 2,
            'suspended' => 3
        ];

        // Check if the user type exists in the mapping array
        if (isset($userTypeValues[$userType])) {
            $userTypeValue = $userTypeValues[$userType];

            // Update the user type in the database
            $conn = mysqli_connect("localhost", "root", "", "local_theatre2");
            if (!$conn) {
                die(mysqli_connect_error());
            }

            // Prepare the query with a parameter
            $query = "UPDATE member SET utype = ? WHERE member_id = ?";
            $stmt = mysqli_prepare($conn, $query);

            // Bind the parameter values
            mysqli_stmt_bind_param($stmt, "ii", $userTypeValue, $memberId);

            // Execute the prepared statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "User type updated successfully.";
            } else {
                echo "Failed to update user type.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            echo "Invalid user type.";
        }
    } else {
        echo "Invalid request. Member ID and user type are required.";
    }
} else {
    echo "Invalid request method.";
}
?>
<?php
$conn = mysqli_connect("localhost", "root", "", "local_theatre2");
if (!$conn) {
    die(mysqli_connect_error());
}

$query = "SELECT * FROM member";
$result = mysqli_query($conn, $query);

// Fetch all rows from the result set
$members = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

// Delete user if delete button is clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $memberId = $_POST['delete'];

        // Delete the user from the database
        $deleteQuery = "DELETE FROM member WHERE member_id = $memberId";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "User deleted successfully.";
        } else {
            echo "Failed to delete user.";
        }
    }
}

// Define an associative array to map user type numbers to their text representations
$userTypeTexts = array(
    1 => "Admin",
    2 => "User",
    3 => "Suspended"
);

mysqli_close($conn);
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

    <style>
        /* CSS for the table */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* CSS for the edit modal */

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        h2 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select {
            margin-bottom: 10px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
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
                <div class="table-container reveal">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
    if (!empty($members)) {
        foreach ($members as $member) {
            echo "<tr>";
            echo "<td>" . $member['member_id'] . "</td>";
            echo "<td>" . $member['user_name'] . "</td>";
            echo "<td>" . $member['email'] . "</td>";
            echo "<td data-memberid='" . $member['member_id'] . "' class='user-type-cell'>" . $userTypeTexts[$member['utype']] . "</td>";
            echo "<td><button onclick=\"editUserType(" . $member['member_id'] . ")\">Edit</button></td>";
            echo "<td>
                    <form method='POST' action=''>
                        <button type='submit' name='delete' value='" . $member['member_id'] . "' onclick=\"return confirm('Are you sure you want to delete this user?')\">Delete</button>
                    </form>
                </td>";
            echo "</tr>";
        }
    } else {
        echo "No members found.";
    }
    ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal for editing user type -->
            <!-- Edit Modal -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Edit User Type</h2>
                    <label for="userType">User Type:</label>
                    <select id="userType">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    <button onclick="updateUserType()">Save</button>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section -->
    <?php include "footer.php" ?>

    <script>
        // Get the modal element
        var modal = document.getElementById('editModal');

        // Get the <span> element that closes the modal
        var closeBtn = document.getElementsByClassName('close')[0];

        // Function to open the modal and set the selected user type
        function editUserType(memberId) {
            modal.style.display = 'block';
            var userType = document.getElementById('userType');
            var currentType = document.querySelector('td.user-type-cell[data-memberid="' + memberId + '"]').innerText;
            userType.value = currentType;
            modal.setAttribute('data-memberid', memberId);
        }

        // Function to close the modal
        closeBtn.onclick = function() {
            closeModal();
        }

        // Function to update the user type
        function updateUserType() {
            var memberId = modal.getAttribute('data-memberid');
            var selectedType = document.getElementById('userType').value;
            alert('New user type: ' + selectedType);

            // Send an AJAX request to update the user type
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Update the user type in the table cell
                        var userTypeCell = document.querySelector('td.user-type-cell[data-memberid="' + memberId + '"]');
                        if (userTypeCell) {
                            userTypeCell.innerText = selectedType;
                        } else {
                            alert('Failed to find the user type cell.');
                        }
                        closeModal();
                    } else {
                        alert('Failed to update user type.');
                    }
                }
            };
            xhr.open('POST', 'update_user_type.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('memberId=' + memberId + '&userType=' + selectedType);
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = 'none';
        }
    </script>
</body>

</html>

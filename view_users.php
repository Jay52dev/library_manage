<?php
session_start();
include 'conn.php';

// Admin access check
if (!isset($_SESSION['role'])) {
    header("Location: index.html");
    exit();
} elseif ($_SESSION['role'] == 'student') {
    header("Location: unauthorized.html");
    exit();
}


// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM students WHERE id = $delete_id AND role = 'student'";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Student deleted successfully'); window.location.href='view_users.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting student');</script>";
    }
}

// Fetch students
$sql = "SELECT id, username, email, phone, dob, gender FROM students WHERE role = 'student'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Registered Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            margin-top: 50px;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            float: right;
            cursor: pointer;
            margin-top: 20px;
        }
        .delete-btn, .profile-btn {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
        }
        .delete-btn {
            background-color: #e74c3c;
        }
        .profile-btn {
            background-color: #3498db;
            margin-left: 10px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .profile-btn:hover {
            background-color: #2c80b4;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Students</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['dob']}</td>
                        <td>{$row['gender']}</td>
                        <td>
                            <a href='view_users.php?delete_id={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                            <a href='view_profile.php?id={$row['id']}' class='profile-btn'>View Profile</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No student users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <form method="post" action="login.html">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

</body>
</html>

<?php mysqli_close($conn); ?>

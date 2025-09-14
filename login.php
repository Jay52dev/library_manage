<?php
session_start();
include 'conn.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials along with the role
    $sql = "SELECT * FROM students WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Store the logged-in user ID, username, and role in session
        $_SESSION['user_id'] = $row['id']; // Store the logged-in user ID
        $_SESSION['username'] = $user; // Store the username
        $_SESSION['role'] = $row['role']; // Store the role (student/admin)
        
        // Redirect based on role
        if ($row['role'] == 'student') {
            header("Location: dashboard.html"); // Redirect to student dashboard
        } elseif ($row['role'] == 'admin') {
            header("Location: admin_dashboard.html"); // Redirect to admin dashboard
        }
        exit();
    } else {
        echo "<script>alert('Invalid Username or Password'); window.location.href='index.html';</script>";
    }
}

mysqli_close($conn);
?>

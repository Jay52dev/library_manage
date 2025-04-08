<?php
session_start();
include 'conn.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM students WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Store the logged-in user ID and username in session
        $_SESSION['user_id'] = $row['id']; // Store the logged-in user ID
        $_SESSION['username'] = $user; // Store the username
        header("Location: dashboard.html"); // Redirect to dashboard or home page
        exit();
    } else {
        echo "<script>alert('Invalid Username or Password'); window.location.href='index.html';</script>";
    }
}

mysqli_close($conn);
?>
<?php
session_start();
include 'conn.php'; // Assumes $conn connects to the library_db

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID from the session

// Fetch user details from the database
$sql = "SELECT id,username, email, phone, dob, gender, role FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);  // Prepare the SQL statement
mysqli_stmt_bind_param($stmt, "i", $user_id);  // Bind the user_id parameter
mysqli_stmt_execute($stmt);  // Execute the query

$result = mysqli_stmt_get_result($stmt);  // Get the result of the query

// Check if the result is found
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);  // Fetch the user details

    // If the user is an admin, ensure they are not accessing the student profile
    if ($user['role'] == 'admin') {
        // Prevent access to student profiles or redirect to the admin dashboard
        echo json_encode(["error" => "Admin role users cannot access student profile"]);
        exit;
    }
    
    // Return the student details if the user is a student
    echo json_encode($user);  // Return the user data as JSON
} else {
    echo json_encode(["error" => "User not found"]);  // If no user found
}

mysqli_stmt_close($stmt);  // Close the prepared statement
mysqli_close($conn);  // Close the database connection
?>

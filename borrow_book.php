<?php
include 'conn.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $bookTitle = $_GET['title'];  // Get the book title from the form

    // Insert the borrow request into the database (if needed)
    // Example: Assuming you have a table `borrowed_books` to track the borrow requests
    $user_id = $_SESSION['user_id']; // Assuming session is started with user data
    $sql = "INSERT INTO borrowed_books (user_id, book_title) VALUES ('$user_id', '$bookTitle')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to dashboard.html after a successful borrow action
        header("Location: dashboard.html"); // Replace with your redirect target page
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<?php
// Add Database connection
include 'conn.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST["title"]) ? trim($_POST["title"]) : "";
    $author = isset($_POST["author"]) ? trim($_POST["author"]) : "";
    $category = isset($_POST["category"]) ? trim($_POST["category"]) : "";

    // Handle file upload (saving in the default folder)
    $coverImage = basename($_FILES["cover_image"]["name"]);

    if (!empty($_FILES["cover_image"]["tmp_name"])) {
        move_uploaded_file($_FILES["cover_image"]["tmp_name"], $coverImage);
    } else {
        $coverImage = ""; // Default empty if no file uploaded
    }

    // ✅ Insert into the database
    $sql = "INSERT INTO books (title, author, category, cover_image) VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $title, $author, $category, $coverImage);
        $execute = mysqli_stmt_execute($stmt);

        if ($execute) {
            echo "<script>alert('Book added successfully!'); window.location.href='admin_dashboard.html';</script>";
        } else {
            echo "<script>alert('Error adding book: " . mysqli_stmt_error($stmt) . "');</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
    }
}

// Close connection
mysqli_close($conn);
?>
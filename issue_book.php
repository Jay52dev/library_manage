<?php
session_start();
include 'conn.php'; // Connect to library_db

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to borrow a book.";
    exit();
}

$student_id = $_SESSION['user_id']; // Assuming user_id is the student's ID from 'students' table

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_name = $_POST['book_name'];
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];

    // Change 'user_id' to 'student_id' to match your table
    $stmt = $conn->prepare("INSERT INTO issue_books (student_id, book_name, issue_date, return_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $student_id, $book_name, $issue_date, $return_date);

    if ($stmt->execute()) {
        echo "<script>alert('Book issued successfully!'); window.location.href='issue_book.html';</script>";
    } else {
        echo "Error issuing book: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

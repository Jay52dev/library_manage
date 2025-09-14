<?php
session_start();
header('Content-Type: application/json');

// Connect to MySQL (procedural)
$conn = mysqli_connect("localhost", "root", "", "library_db");

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Failed to connect to the database.']);
    exit();
}

// Check login
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Please log in to view issued books.']);
    exit();
}

$username = $_SESSION['username'];

// Get student ID from the `students` table
$sql_id = "SELECT id FROM students WHERE username = '$username'";
$result_id = mysqli_query($conn, $sql_id);

if (mysqli_num_rows($result_id) == 0) {
    echo json_encode(['error' => 'Student not found.']);
    exit();
}

$row = mysqli_fetch_assoc($result_id);
$student_id = $row['id'];

// DELETE expired books
$delete_sql = "DELETE FROM issue_books WHERE student_id = $student_id AND return_date < CURDATE()";
mysqli_query($conn, $delete_sql);

// FETCH active issued books
$sql_books = "SELECT book_name, issue_date, return_date FROM issue_books WHERE student_id = $student_id";
$result_books = mysqli_query($conn, $sql_books);

$issued_books = [];

while ($book = mysqli_fetch_assoc($result_books)) {
    $issued_books[] = $book;
}

// Output as JSON
echo json_encode($issued_books);

// Close connection
mysqli_close($conn);
?>

<?php
session_start();
include 'conn.php';
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["error" => "User not logged in"]));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $book_name = $_POST['book_name'];
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];

    $sql = "INSERT INTO issue_books (username, book_name, issue_date, return_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $username, $book_name, $issue_date, $return_date);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "redirect" => "issue_book.html"]);
        } else {
            echo json_encode(["error" => "Failed to issue book"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Database error"]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
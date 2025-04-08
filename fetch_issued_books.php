<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT book_name, issue_date, return_date FROM issue_books WHERE username = (SELECT username FROM students WHERE id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$issued_books = [];
while ($row = $result->fetch_assoc()) {
    $issued_books[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($issued_books);
?>
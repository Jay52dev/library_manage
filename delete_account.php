<?php
session_start();
header('Content-Type: application/json');
include 'conn.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$username = $_SESSION['username'];

// Delete the account from 'students' table
$stmt = $conn->prepare("DELETE FROM students WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    session_unset();
    session_destroy();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete account']);
}

$stmt->close();
$conn->close();
?>

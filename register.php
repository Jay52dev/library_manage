<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    
    if (empty($_POST['pass'])) {
        die("<script>alert('pass field cannot be empty!'); window.location.href='registration.html';</script>");
    }

    $pass = $_POST['pass']; // ⚠️ pass is stored as plain text (NOT RECOMMENDED)

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM students WHERE email = ?");
    if (!$check_email) {
        die("Prepare failed: " . $conn->error);
    }
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();  

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already registered. Please use another email!'); window.location.href='registration.html';</script>";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO students (username, email, phone, dob, gender, password) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssss", $username, $email, $phone, $dob, $gender, $pass);
        if ($stmt->execute()) {
            session_start();
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_name'] = $username;
            header("Location: dashboard.html");
            exit();
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_email->close();
    $conn->close();
}
?>
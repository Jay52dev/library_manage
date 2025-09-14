<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $role = $_POST['role']; // Get role from form (student or admin)

    if (empty($_POST['pass'])) {
        die("<script>alert('Password field cannot be empty!'); window.location.href='registration.html';</script>");
    }

    $pass = $_POST['pass']; // Consider hashing the password for security

    // Check if email already exists
    $check_email = mysqli_prepare($conn, "SELECT id FROM students WHERE email = ?");
    if (!$check_email) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($check_email, "s", $email);
    mysqli_stmt_execute($check_email);
    mysqli_stmt_store_result($check_email);

    if (mysqli_stmt_num_rows($check_email) > 0) {
        echo "<script>alert('Email already registered. Please use another email!'); window.location.href='registration.html';</script>";
    } else {
        // Insert new user, including the role
        $stmt = mysqli_prepare($conn, "INSERT INTO students (username, email, phone, dob, gender, role, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $phone, $dob, $gender, $role, $pass);
        if (mysqli_stmt_execute($stmt)) {
            session_start();
            $_SESSION['user_id'] = mysqli_insert_id($conn); // Store the user ID in the session
            $_SESSION['username'] = $username; // Store the username in session
            $_SESSION['role'] = $role; // Store the role (student or admin)

            // Redirect based on the role
            if ($role == 'student') {
                header("Location: dashboard.html"); // Redirect to student dashboard
            } elseif ($role == 'admin') {
                header("Location: admin_dashboard.html"); // Redirect to admin dashboard
            }
            exit();
        } else {
            echo "Error inserting data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($check_email);
    mysqli_close($conn);
}
?>

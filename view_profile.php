<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Unauthorized Access'); window.location.href='index.html';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('No student selected'); window.location.href='view_users.php';</script>";
    exit();
}

$student_id = $_GET['id'];

// Fetch student details
$student_query = "SELECT * FROM students WHERE id = $student_id";
$student_result = mysqli_query($conn, $student_query);
$student = mysqli_fetch_assoc($student_result);

// Count issued books
$count_query = "SELECT COUNT(*) as total_issued FROM issue_books WHERE student_id = $student_id";
$count_result = mysqli_query($conn, $count_query);
$count = mysqli_fetch_assoc($count_result);
$total_issued = $count['total_issued'];

// Fetch issued book details
$book_query = "SELECT book_name, issue_date, return_date FROM issue_books WHERE student_id = $student_id";
$book_result = mysqli_query($conn, $book_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            padding: 20px;
        }

        .profile-container {
            background: white;
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #007bff;
            text-align: center;
        }

        .info, .book-table {
            margin-top: 20px;
        }

        .info p {
            font-size: 18px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .back-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            display: block;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Student Profile</h2>

    <div class="info">
        <p><strong>ID:</strong> <?= $student['id'] ?></p>
        <p><strong>Username:</strong> <?= $student['username'] ?></p>
        <p><strong>Email:</strong> <?= $student['email'] ?></p>
        <p><strong>Phone:</strong> <?= $student['phone'] ?></p>
        <p><strong>Date of Birth:</strong> <?= $student['dob'] ?></p>
        <p><strong>Gender:</strong> <?= $student['gender'] ?></p>
        <p><strong>Total Books Issued:</strong> <?= $total_issued ?></p>
    </div>

    <?php if (mysqli_num_rows($book_result) > 0): ?>
    <div class="book-table">
        <h3>Issued Books</h3>
        <table>
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = mysqli_fetch_assoc($book_result)): ?>
                <tr>
                    <td><?= $book['book_name'] ?></td>
                    <td><?= $book['issue_date'] ?></td>
                    <td><?= $book['return_date'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>No books issued.</p>
    <?php endif; ?>

    <a href="view_users.php" class="back-btn">Back to User List</a>
</div>

</body>
</html>

<?php mysqli_close($conn); ?>

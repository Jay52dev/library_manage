<?php
include 'conn.php'; // Include DB connection

// Handle logout
if (isset($_GET['logout'])) {
    header("Location: admin_dashboard.html");
    exit();
}

// Handle book deletion
if (isset($_GET['delete'])) {
    $bookId = intval($_GET['delete']);
    
    // Optional: Delete the cover image file if needed
    $getImageQuery = "SELECT cover_image FROM books WHERE id = $bookId";
    $imageResult = $conn->query($getImageQuery);
    if ($imageResult && $imageResult->num_rows > 0) {
        $row = $imageResult->fetch_assoc();
        if (!empty($row['cover_image']) && file_exists($row['cover_image'])) {
            unlink($row['cover_image']); // Delete image file
        }
    }

    $deleteSql = "DELETE FROM books WHERE id = $bookId";
    $conn->query($deleteSql);
    header("Location: manage_books.php");
    exit();
}

// Fetch books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #1b54a6;
        }
        .book-table {
            width: 95%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .back-btn, .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            margin: 20px 10px;
            background-color: #1b54a6;
            color: white;
            border-radius: 5px;
        }
        .logout-btn {
            background-color: #d9534f;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
        .back-btn:hover {
            background-color: #163d7a;
        }
        .book-cover {
            width: 60px;
            height: 90px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <h1>Manage Books</h1>

    <table class="book-table">
        <tr>
            <th>Sr No.</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            $serial = 1;
            while ($book = $result->fetch_assoc()) {
                $cover = !empty($book['cover_image']) && file_exists($book['cover_image']) 
                         ? $book['cover_image'] 
                         : 'default_cover.jpg'; // default image
                echo "<tr>
                        <td>" . $serial++ . "</td>
                        <td><img src='" . htmlspecialchars($cover) . "' alt='Cover' class='book-cover'></td>
                        <td>" . htmlspecialchars($book['title'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($book['author'] ?? 'N/A') . "</td>
                        <td>" . htmlspecialchars($book['category'] ?? 'N/A') . "</td>
                        <td>
                            <a href='manage_books.php?delete=" . $book['id'] . "' onclick='return confirm(\"Are you sure you want to delete this book?\");'>
                                <button class='delete-btn'>Delete</button>
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No books available.</td></tr>";
        }
        ?>
    </table>

    <div style="text-align: center;">
        <a href="admin_dashboard.html" class="back-btn">Back to Dashboard</a>
        <a href="?logout=true" class="logout-btn">Logout</a>
    </div>

</body>
</html>

<?php $conn->close(); ?>

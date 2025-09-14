<?php
include 'conn.php'; // Include the database connection

// Fetch books from the database
$sql = "SELECT title, author, category, cover_image FROM books";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>z
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Navbar */
        .navbar {
            width: 100%;
            background-color: #1b54a6;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .website-name {
            color: white;
            font-size: 22px;
            font-weight: bold;
            margin-left: 10px;
        }

        /* Hamburger Menu */
        .menu {
            position: relative;
            display: inline-block;
        }
        
        .menu-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        
        .menu-btn:hover {
            transform: rotate(90deg);
        }
        
        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            min-width: 180px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease-in-out;
        }
        
        .dropdown a {
            display: block;
            color: #333;
            text-decoration: none;
            padding: 12px 16px;
            font-size: 16px;
            transition: background 0.3s ease-in-out;
        }
        
        .dropdown a:hover {
            background-color: #f1f1f1;
            padding-left: 20px;
        }
        
        .menu:hover .dropdown {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Book List */
        .container {
            flex: 1; /* Pushes the footer to the bottom */
            padding: 100px 20px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .book-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .book {
            background: #fff;
            padding: 15px;
            margin: 15px;
            width: 30%;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-radius: 5px;
        }
        
        .book img {
            width: 100px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: auto;
        }

        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #ff9800;
        }

        /* Social Icons */
        .social-icons a {
            color: white;
            font-size: 24px;
            margin: 0 10px;
            transition: transform 0.3s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
            color: #ff9800;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo-container">
        <img src="logo.jpg" alt="Library Logo" class="logo">
        <span class="website-name">Library Management</span>
    </div>
    <div class="menu">
        <button class="menu-btn"><i class="fas fa-bars"></i></button>
        <div class="dropdown">
            <a href="dashboard.html">Home</a>
            <a href="profile.php">Profile</a>
            <a href="issue_book.html">Issue Book</a>
            <a href="issued_books.html">Issued Book</a>
            <a href="books.php">Recently Added Books</a>
            <a href="contact.html">Contact Us</a>
            <a href="about.html">About</a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="book-list">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='book'>";
                echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Book Cover'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p><b>Author:</b> " . htmlspecialchars($row['author']) . "</p>";
                echo "<p><b>Category:</b> " . htmlspecialchars($row['category']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No books available.</p>";
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>"Unlock a world of knowledge with every page you turn!"</p>
    <div class="social-icons">
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
    </div>
    <div class="footer-links">
        <a href="privacy_policy.html">Privacy Policy</a> |
        <a href="terms_conditions.html">Terms & Conditions</a> |
        <a href="contact.html">Contact Us</a>
    </div>
    <p>&copy; 2025 Library Management System | Designed for book lovers</p>
</footer>

</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
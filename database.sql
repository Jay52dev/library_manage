-- Create the database
CREATE DATABASE library_db;

-- Use the database
USE library_db;

-- Create the students table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    password VARCHAR(255) NOT NULL
);

--for issue books--
CREATE TABLE issue_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    book_name VARCHAR(255) NOT NULL,
    issue_date DATE NOT NULL,
    return_date DATE NOT NULL
);
--for creating the books table
CREATE TABLE books (
  id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  author varchar(255) NOT NULL,
  category varchar(100) NOT NULL,
  cover_image varchar(255) NOT NULL
);

-- for creating the contact table 
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

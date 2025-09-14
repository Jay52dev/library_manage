<?php
// Database Connection (Procedural)
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$database = "library_db"; //databse name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn) {
    echo "";
}
else{
     die("Connection failed: " . mysqli_connect_error());

}
?>
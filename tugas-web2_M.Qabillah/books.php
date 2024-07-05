<?php
// Connect to database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Return books as JSON
header('Content-Type: application/json');
echo json_encode($books);

$conn->close();
?>

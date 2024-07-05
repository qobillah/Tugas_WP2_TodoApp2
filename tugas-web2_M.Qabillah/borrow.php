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

// Handle borrowing form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['bookId'];
    $borrowerName = $_POST['borrowerName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert borrower data into database
    $sql = "INSERT INTO borrowers (name, email, phone, book_id) VALUES ('$borrowerName', '$email', '$phone', '$bookId')";
    
    if ($conn->query($sql) === TRUE) {
        // Update book status to 'borrowed'
        $updateSql = "UPDATE books SET status = 'borrowed' WHERE id = '$bookId'";
        if ($conn->query($updateSql) === TRUE) {
            echo json_encode(array('message' => 'Book borrowed successfully.'));
        } else {
            echo json_encode(array('message' => 'Error updating book status: ' . $conn->error));
        }
    } else {
        echo json_encode(array('message' => 'Error borrowing book: ' . $conn->error));
    }
}

$conn->close();
?>

<?php
$hostname = "127.0.0.0";
$username = "root";
$password = "Tanmay@27122011";
$port = "2712";
$database = "testing";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Handle Signup
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Insert the user into the database
        $stmt = $conn->prepare("INSERT INTO credentials (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } elseif (isset($_POST['login'])) {
        // Handle Login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username and password match
        $stmt = $conn->prepare("SELECT * FROM credentials WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Login successful!";
        } else {
            echo "Invalid username or password!";
        }
    }
}

$conn->close();
?>

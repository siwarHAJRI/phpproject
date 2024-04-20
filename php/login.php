<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = "";     // default password for XAMPP
$database = "Movie"; // Change this to your database name

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Construct SQL SELECT query to retrieve the password for the given username
    $stmt = $conn->prepare("SELECT password FROM users WHERE name = :username");

    // Bind parameters
    $stmt->bindParam(':username', $username);

    // Execute SQL query
    $stmt->execute();

    // Fetch the password from the database
    $storedPassword = $stmt->fetchColumn();

    // Check if a password was found and verify it
    if ($storedPassword && $password==$storedPassword) {
        // Redirect the user to another page (e.g., dashboard)
        session_start();
        $_SESSION['username'] = $username;
        header("Location: ../html/index.php");
        exit();
    } else {
        // Redirect the user back to the login page with an error message
        header("Location: ../html/login.html?error=invalid_credentialsusername= $username password= $password");
        exit();
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection (optional for PDO)
$conn = null;
?>
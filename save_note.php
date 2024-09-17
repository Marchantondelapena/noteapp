<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the note text from the POST parameters
    $noteText = $_POST["note_text"];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "notepad";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to insert the note into the database
    $sql = "INSERT INTO note (note_text) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $noteText);
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Send a response back to the client indicating success
    echo "Note saved successfully!";
} else {
    // Send a response back to the client indicating an error
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method!";
}
?>

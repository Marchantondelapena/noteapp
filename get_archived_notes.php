<?php
// Start the session
session_start();

// Check if the user is logged in and if the session variable is set
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or perform other actions
    header("Location: homepage.php"); // Replace 'login.php' with your actual login page
    exit(); // Stop further execution of the script
}

// Include database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notepad";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modified SQL query to fetch archived notes of the current user
$user_id = $_SESSION['user_id']; // Get the user ID from the session
$sql = "SELECT archived_id, note_title, note_content, archived_at FROM archived WHERE user_id = $user_id"; // Include archived_id in the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='archived-notes-grid'>"; // Start of grid container
    while($row = $result->fetch_assoc()) {
        $archived_id = $row["archived_id"]; // Now "archived_id" should be present in the fetched row
        $note_title = $row["note_title"];
        $note_content = $row["note_content"];
        $archived_at = $row["archived_at"]; // Retrieve archived_at
        echo "<div class='archived-note'>"; // Start of each archived note
        echo "<h2>" . $note_title . "</h2>";                        
        echo "<p>" . $note_content . "</p>";
        echo "<p class='note-date'>Archived at: " . $archived_at . "</p>"; // Display archived_at
        echo "<form action='delete_archived_note.php' method='POST'>"; // Form for deleting archived note
        echo "<input type='hidden' name='archived_id' value='$archived_id'>"; // Hidden input to send archived_id
        echo "<button type='submit' class='delete-button'>Delete</button>"; // Delete button
        echo "</form>";
        echo "</div>"; // End of each archived note
    }
    echo "</div>"; // End of grid container
} else {
    echo "No archived notes found.";
}

$conn->close();
?>

<style>
    .archived-notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive grid */
        grid-gap: 20px;
        margin-top: 20px;
    }

  

    .archived-note h2 {
        margin-top: 0;
        color: #333;
    }

    .archived-note p {
        color: #666;
    }

    .note-date {
        font-style: italic;
        color: #888;
        margin-top: 10px;
    }

    /* Style for the delete button */
    .delete-button {
        background-color: #ff5b5b;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .delete-button:hover {
        background-color: #e02424;
    }

    .archived-note {
   
    width: 339px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}
</style>

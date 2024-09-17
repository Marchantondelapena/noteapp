<?php
// Assuming you're using PDO for database operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note_id'])) {
    try {
        // Connect to the database
        $pdo = new PDO('notepad', 'username', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the delete query
        $stmt = $pdo->prepare("DELETE FROM note WHERE id = ?");
        $stmt->execute([$_POST['note_id']]);

        // Send success response
        echo "Note deleted successfully";
    } catch (PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Send error response if note_id is not provided or request method is not POST
    echo "Error: Invalid request";
}
?>

<?php
// Assuming you're using PDO for database operations
try {
    // Connect to the database
    $pdo = new PDO('notepad', 'username', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch notes from the database
    $stmt = $pdo->query("SELECT * FROM note");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the notes as JSON
    header('Content-Type: application/json');
    echo json_encode($notes);
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
?>

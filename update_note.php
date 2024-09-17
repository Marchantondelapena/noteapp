<?php
// Include config.php to establish database connection
include "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id']) && isset($_POST['note_content'])) {
    // Get note ID and updated note content from the POST data
    $note_id = $_POST['note_id'];
    $note_content = $_POST['note_content'];

    // Prepare SQL statement to update the note
    $sql_update_note = "UPDATE note SET note_content = ?, updated_at = NOW() WHERE id = ?";
    $stmt_update_note = $conn->prepare($sql_update_note);
    $stmt_update_note->bind_param("si", $note_content, $note_id);

    // Execute the update statement
    if ($stmt_update_note->execute()) {
        // Note updated successfully
        echo "Note updated successfully!";
    } else {
        // Error updating note
        echo "Error: " . $stmt_update_note->error;
    }

    $stmt_update_note->close();
} else {
    // If note ID or updated content is not provided in the POST data
    echo "Note ID or updated content not provided!";
}
?>

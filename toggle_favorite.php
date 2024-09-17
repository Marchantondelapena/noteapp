<?php
include "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_POST['note_id'])) {
    $user_id = $_SESSION['user_id'];
    $note_id = $_POST['note_id'];

    // Fetch the note from the 'notes' table
    $sql_get_note = "SELECT note_title, note_content FROM notes WHERE note_id = ? AND user_id = ?";
    $stmt_get_note = $conn->prepare($sql_get_note);
    $stmt_get_note->bind_param("ii", $note_id, $user_id);
    $stmt_get_note->execute();
    $stmt_get_note->store_result(); // Store the result for later use
    $stmt_get_note->bind_result($note_title, $note_content);
    
    if ($stmt_get_note->num_rows == 1) {
        // Fetch the note data
        $stmt_get_note->fetch();

        // Check if the note already exists in favorites
        $sql_check_favorite = "SELECT * FROM favorites WHERE user_id = ? AND note_id = ?";
        $stmt_check_favorite = $conn->prepare($sql_check_favorite);
        $stmt_check_favorite->bind_param("ii", $user_id, $note_id);
        $stmt_check_favorite->execute();
        $result_check_favorite = $stmt_check_favorite->get_result();

        if ($result_check_favorite->num_rows == 0) {
            // If the note is not already in favorites, insert it
            $sql_add_to_favorites = "INSERT INTO favorites (user_id, note_id, note_title, note_content, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt_add_to_favorites = $conn->prepare($sql_add_to_favorites);
            $stmt_add_to_favorites->bind_param("iiss", $user_id, $note_id, $note_title, $note_content);

            if ($stmt_add_to_favorites->execute()) {
                echo json_encode(array("status" => "success", "message" => "Note added to favorites.", "title" => $note_title, "content" => $note_content));
            } else {
                echo json_encode(array("status" => "error", "message" => "Error adding note to favorites: " . $stmt_add_to_favorites->error));
            }

            $stmt_add_to_favorites->close();
        } else {
            // If the note already exists in favorites, remove it
            $sql_remove_from_favorites = "DELETE FROM favorites WHERE user_id = ? AND note_id = ?";
            $stmt_remove_from_favorites = $conn->prepare($sql_remove_from_favorites);
            $stmt_remove_from_favorites->bind_param("ii", $user_id, $note_id);

            if ($stmt_remove_from_favorites->execute()) {
                echo json_encode(array("status" => "success", "message" => "Note removed from favorites."));
            } else {
                echo json_encode(array("status" => "error", "message" => "Error removing note from favorites: " . $stmt_remove_from_favorites->error));
            }

            $stmt_remove_from_favorites->close();
        }

        $stmt_check_favorite->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Note not found or you don't have permission to access it."));
    }

    $stmt_get_note->close();
} else {
    echo json_encode(array("status" => "error", "message" => "Error: Invalid request."));
}
?>

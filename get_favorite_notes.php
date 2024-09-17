<?php
// Start session and include database connection
session_start();
include "config.php";

// Fetch favorited notes for the current user
$user_id = $_SESSION['user_id'];
$sql_select_favorites = "SELECT n.* FROM favorites f INNER JOIN notes n ON f.note_id = n.note_id WHERE f.user_id = ?";
$stmt_select_favorites = $conn->prepare($sql_select_favorites);
$stmt_select_favorites->bind_param("i", $user_id);
$stmt_select_favorites->execute();
$result_favorites = $stmt_select_favorites->get_result();

// Display favorited notes
while ($row_favorite = $result_favorites->fetch_assoc()) {
    echo "<div class='note'>";
    // Display note details (title, content, etc.)
    // You can customize the display as per your UI design
    echo "</div>";
}

// Close statement and database connection
$stmt_select_favorites->close();
$conn->close();
?>

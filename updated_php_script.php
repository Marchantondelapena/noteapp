<?php
// Include config.php to establish database connection
include "config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['note_content'])) {
        $note_content = $_POST['note_content'];
        $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session

        $sql_insert_note = "INSERT INTO note (user_id, note_content, created_at) VALUES (?, ?, NOW())";
        $stmt_insert_note = $conn->prepare($sql_insert_note);
        $stmt_insert_note->bind_param("is", $user_id, $note_content);

        if ($stmt_insert_note->execute()) {
            // Note inserted successfully
            echo "Note added successfully!";
        } else {
            // Error inserting note
            echo "Error: " . $stmt_insert_note->error;
        }

        $stmt_insert_note->close();
    }
} else {
    // Fetch notes from the database for the current user
    $user_id = $_SESSION['user_id'];
    $sql_fetch_notes = "SELECT * FROM note WHERE user_id = ?";
    $stmt_fetch_notes = $conn->prepare($sql_fetch_notes);
    $stmt_fetch_notes->bind_param("i", $user_id);
    $stmt_fetch_notes->execute();
    $result = $stmt_fetch_notes->get_result();

    $notes = array();
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }

    
// <div class="container">
// <div class="box-container">
//   <div class="box">
//     <h2>B1</h2>
//     <img src="image/ac.jpg" alt="">
//     <p>er</p>
//   </div>

//   <div class="box">
//     <h2>B2</h2>
//     <img src="image/ac.jpg" alt="">
//     <p>edr</p>
//   </div>

//   <div class="box">
//     <h2>b3</h2>
//     <img src="image/ac.jpg" alt="">
//     <p>edr</p>
//   </div>
// </div>


//     </div>
    echo json_encode($notes);

    $stmt_fetch_notes->close();
}
?>

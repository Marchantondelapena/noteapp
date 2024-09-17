<?php
include "config.php"; // Include config.php to establish database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add Note
    if (isset($_POST['noteContent'], $_POST['noteTitle'])) {
        $note_content = $_POST['noteContent'];
        $note_title = $_POST['noteTitle'];
        $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session

        $sql_insert_note = "INSERT INTO notes (user_id, note_title, note_content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt_insert_note = $conn->prepare($sql_insert_note);
        $stmt_insert_note->bind_param("iss", $user_id, $note_title, $note_content);

        if ($stmt_insert_note->execute()) {
            header("Location: dash.php");
            exit();
        } else {
            echo "Error: " . $stmt_insert_note->error;
        }

        $stmt_insert_note->close();
    }

    // Delete Note
    if (isset($_POST['delete_note'], $_POST['delete_note_id'])) {
        $note_id = $_POST['delete_note_id'];
        $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session

        // Retrieve the note to be deleted
        $sql_select_note = "SELECT * FROM notes WHERE note_id = ? AND user_id = ?";
        $stmt_select_note = $conn->prepare($sql_select_note);
        $stmt_select_note->bind_param("ii", $note_id, $user_id);
        $stmt_select_note->execute();
        $result_note = $stmt_select_note->get_result();

        if ($result_note->num_rows > 0) {
            $row_note = $result_note->fetch_assoc();
            $note_title = $row_note['note_title'];
            $note_content = $row_note['note_content'];

            // Check if the note already exists in archived_notes table
            $sql_check_duplicate = "SELECT * FROM archived WHERE user_id = ? AND note_title = ?";
            $stmt_check_duplicate = $conn->prepare($sql_check_duplicate);
            $stmt_check_duplicate->bind_param("is", $user_id, $note_title);
            $stmt_check_duplicate->execute();
            $result_duplicate = $stmt_check_duplicate->get_result();

            if ($result_duplicate->num_rows > 0) {
                // Update the existing record with new content
                $sql_update_note = "UPDATE archived SET note_content = ? WHERE user_id = ? AND note_title = ?";
                $stmt_update_note = $conn->prepare($sql_update_note);
                $stmt_update_note->bind_param("sis", $note_content, $user_id, $note_title);
                if ($stmt_update_note->execute()) {
                    // Note updated successfully
                    $stmt_update_note->close();
                } else {
                    echo "Error updating note: " . $stmt_update_note->error;
                }
            } else {
                // Insert the note into archived_notes table
                $sql_archive_note = "INSERT INTO archived (user_id, note_title, note_content) VALUES (?, ?, ?)";
                $stmt_archive_note = $conn->prepare($sql_archive_note);
                $stmt_archive_note->bind_param("iss", $user_id, $note_title, $note_content);
                if ($stmt_archive_note->execute()) {
                    // Note archived successfully
                    $stmt_archive_note->close();
                } else {
                    echo "Error archiving note: " . $stmt_archive_note->error;
                }
            }

            // Delete the note from the notes table
            $sql_delete_note = "DELETE FROM notes WHERE note_id = ? AND user_id = ?";
            $stmt_delete_note = $conn->prepare($sql_delete_note);
            $stmt_delete_note->bind_param("ii", $note_id, $user_id);
            if ($stmt_delete_note->execute()) {
                // Note deleted successfully
                header("Location: dash.php");
                exit();
            } else {
                echo "Error deleting note: " . $stmt_delete_note->error;
            }
            $stmt_delete_note->close();
        } else {
            echo "Note not found.";
        }
        $stmt_select_note->close();
    }

 // Archive Note
if (isset($_POST['archive_note'], $_POST['archive_note_id'])) {
    $note_id = $_POST['archive_note_id'];
    $user_id = $_SESSION['user_id'];

    // Retrieve the note to be archived
    $sql_select_note = "SELECT * FROM notes WHERE note_id = ? AND user_id = ?";
    $stmt_select_note = $conn->prepare($sql_select_note);
    $stmt_select_note->bind_param("ii", $note_id, $user_id);
    $stmt_select_note->execute();
    $result_note = $stmt_select_note->get_result();

    if ($result_note->num_rows > 0) {
        $row_note = $result_note->fetch_assoc();
        $note_title = $row_note['note_title'];
        $note_content = $row_note['note_content'];

        // Insert the note into archived_notes table without checking for duplicates
        $sql_archive_note = "INSERT INTO archived (user_id, note_title, note_content) VALUES (?, ?, ?)";
        $stmt_archive_note = $conn->prepare($sql_archive_note);
        $stmt_archive_note->bind_param("iss", $user_id, $note_title, $note_content);
        if ($stmt_archive_note->execute()) {
            // Note archived successfully
            header("Location: dash.php");
            exit();
        } else {
            echo "Error archiving note: " . $stmt_archive_note->error;
        }
        $stmt_archive_note->close();
    } else {
        echo "Note not found.";
    }
    $stmt_select_note->close();
}

    // Update Note
    if (isset($_POST['update_note'], $_POST['note_id'], $_POST['edited_note_content'], $_POST['edited_note_title'])) {
        $note_id = $_POST['note_id'];
        $edited_note_content = $_POST['edited_note_content'];
        $edited_note_title = $_POST['edited_note_title'];
        $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session

        $sql_update_note = "UPDATE notes SET note_title = ?, note_content = ? WHERE note_id = ? AND user_id = ?";
        $stmt_update_note = $conn->prepare($sql_update_note);
        $stmt_update_note->bind_param("ssii", $edited_note_title, $edited_note_content, $note_id, $user_id);

        if ($stmt_update_note->execute()) {
            header("Location: dash.php");
            exit();
        } else {
            echo "Error: " . $stmt_update_note->error;
        }

        $stmt_update_note->close();
    }

    // Add to favorites
    if (isset($_POST['add_to_favorites'], $_POST['note_id'])) {
        $note_id = $_POST['note_id'];
        $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session

        $sql_add_to_favorites = "INSERT INTO favorites (user_id, note_id, created_at) VALUES (?, ?, NOW())";
        $stmt_add_to_favorites = $conn->prepare($sql_add_to_favorites);
        $stmt_add_to_favorites->bind_param("ii", $user_id, $note_id);

        if ($stmt_add_to_favorites->execute()) {
            // Success message or redirect if needed
        } else {
            // Error handling
        }

        $stmt_add_to_favorites->close();
    }
}

// Retrieve notes
$sql_select_notes = "SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC";
$stmt_select_notes = $conn->prepare($sql_select_notes);
$stmt_select_notes->bind_param("i", $_SESSION['user_id']);
$stmt_select_notes->execute();
$result_notes = $stmt_select_notes->get_result();

// Close the statement after fetching notes
$stmt_select_notes->close();
$colors = array("#45ffbc", "#e3ffa8", "#bdbbb7");

// Check if session variable for color index exists
if (!isset($_SESSION['color_index'])) {
    // Initialize color index if not set
    $_SESSION['color_index'] = 0;
} else {
    // Increment color index and wrap around if it exceeds the number of colors
    $_SESSION['color_index'] = ($_SESSION['color_index'] + 1) % count($colors);
}

// Get the color for the current index
$currentColor = $colors[$_SESSION['color_index']];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devizce-width, initial-scale=1.0">
    <title>Notepad Dashboard</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
  
<div class="container">


<div class="sidebar">
 
    <h1 class="logo-title">
        <span>NoteIt!</span>
    </h1>

    <div class="user-profile">
        <h1><?php echo $_SESSION['username']; ?></h1>
        <span>
            <img src="imgs/ac.jpg" />
        </span>
    </div>
  <!-- Add an ID to the sidebar navigation -->
<nav id="sidebar-navigation" class="navigation">
    <!-- Your sidebar links here -->
    <a href="#" onclick="showNotes()">
        <i class="ph-browsers"></i>
        <span>Dashboard</span>
    </a>
    <a href="#" onclick="showFavorites()">
        <i class="ph-swap"></i>
        <span>Favorites</span>
    </a>
    <a href="#" id="archiveButton" onclick="fetchArchivedNotes()">
        <i class="ph-file-text"></i>
        <span>Archives</span>
    </a>
    <a href="homepage.php">
        <i class="ph-globe"></i>
        <span>Logout</span>
    </a>
</nav>

</div>



    

    
    <iv class="main-content">
    <div class="header">
        <h1>All Notes</h1>
  
        <div class="search-wrapper">
    <input id="searchInput" class="search-input" type="text" placeholder="Search">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewBox="0 0 24 24">
        <defs></defs>
        <circle cx="11" cy="11" r="8"></circle>
        <path d="M21 21l-4.35-4.35"></path>
    </svg>
</div>
<svg class="add-btn" title="Add New Project" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="toggleNoteInputForm()">
    <circle cx="12" cy="12" r="10"></circle>
    <line x1="12" y1="8" x2="12" y2="16"></line>
    <line x1="8" y1="12" x2="16" y2="12"></line>
</svg>
<div class="add-notes-label">
    <p>Add Notes</p>
</div>

<div id="favoritesContent" class="main-content" style="display: none;">
    <!-- Favorites content will be displayed here -->
</div>



                </div>
    <div class="notes-grid">
    <?php
// Assuming you have established the database connection and stored the user ID in the session
$sql_select_notes = "SELECT * FROM notes WHERE user_id = ? ORDER BY created_at DESC";
$stmt_select_notes = $conn->prepare($sql_select_notes);
$stmt_select_notes->bind_param("i", $_SESSION['user_id']);
$stmt_select_notes->execute();
$result_notes = $stmt_select_notes->get_result();

while ($row_notes = $result_notes->fetch_assoc()) {
    $note_id = $row_notes['note_id'];
    $note_title = $row_notes['note_title'];
    $note_content = $row_notes['note_content'];
    $created_at = $row_notes['created_at'];
    ?>

    

<div class="note">
    <div class="note-header">
               <svg id="heartIcon_<?php echo $note_id; ?>" xmlns="http://www.w3.org/2000/svg" class="heart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" onclick="toggleFavorite(<?php echo $note_id; ?>)">
    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
</svg>

        <h2><?php echo $note_title; ?></h2>
        <div class="dropdown">
            <button class="dropbtn" onclick="toggleDropdown('dropdown_<?php echo $note_id; ?>')">&#8942;</button>
            <div class="dropdown-content" id="dropdown_<?php echo $note_id; ?>">
                <a href="#" onclick="openEditPopup('<?php echo $note_id; ?>', '<?php echo $note_title; ?>', '<?php echo $note_content; ?>')">Edit</a>
                <a href="#" onclick="openViewPopup('<?php echo $note_title; ?>', '<?php echo $note_content; ?>')">View</a>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="delete_note_id" value="<?php echo $note_id; ?>">
                    <button type="submit" name="delete_note">Delete</button>
                </form>
            </div> 
        </div>
    </div>
    <p><?php echo $note_content; ?></p>
    <div class="note-date">
        Date: <?php echo $created_at; ?>
    </div>
</div>

<?php
}

// Close the statement after the while loop
$stmt_select_notes->close();
    ?>
</div>
<div id="favoritesContent" class="main-content" style="display: none;">
    <!-- Favorites content will be displayed here -->
</div>

<div id="noteDisplay">
    <!-- Notes are displayed here -->
</div>

<div id="archivedNoteDisplay">
    <!-- Archived notes will be displayed here -->
</div>










<!-- Update note form -->
<div id="popup" class="popup" style="display: none;">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="note card">
        <input type="hidden" name="note_id" id="popup_note_id">
        <input type="text" name="edited_note_title" id="popup_note_title" class="note-input" placeholder="Enter updated note title">
        <textarea name="edited_note_content" id="popup_note_content" class="note-textarea note-input" placeholder="Enter your updated note here" oninput="autoResizeTextarea(this)"></textarea>
        <div class="buttonContainer">
            <button type="submit" name="update_note" class="acceptButton" id="popup_button">Update Note</button>
            <button type="button" onclick="closeEditPopup()" class="acceptButton">Cancel</button>
        </div>
    </form>
</div>


 <!-- View note popup -->
 <div id="viewNotePopup" class="popup" style="display: none;">
        <div class="note card">
            <p id="viewNoteContent"></p>
            <button type="button" onclick="closeViewPopup()" class="acceptButton">Close</button>
        </div>
    </div>

    <div id="noteInputForm" class="popup" style="display: none;">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="note card">
        <div class="note-header">
        <input type="text" name="noteTitle" id="noteTitle" class="note-input" placeholder="Enter note title">
        </div>
        <div class="note-content">
            <textarea name="noteContent" id="noteContent" class="note-textarea" placeholder="Enter your note here" oninput="autoResizeTextarea(this)"></textarea>
            <div class="buttonContainer">
                <button type="submit" class="acceptButton">Add Note</button>
                <button type="button" onclick="toggleNoteInputForm()" class="acceptButton">Cancel</button>
            </div>
        </div>
    </form>
</div>



<script>
// JavaScript function to toggle favorite status
function toggleFavorite(note_id) {
    fetch('toggle_favorite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            note_id: note_id
        })
    })
    .then(response => {
        if (response.ok) {
            // Change heart icon color and move note to favorites section
            var heartIcon = document.getElementById('heartIcon_' + note_id);
            heartIcon.classList.toggle('favorite'); // Add a class to change the heart color

            // Remove the note from the main notes section
            var noteElement = document.getElementById('note_' + note_id);
            noteElement.parentNode.removeChild(noteElement);
        } else {
            // Error handling
        }
    })
    .catch(error => console.error('Error toggling favorite:', error));
}

function toggleDropdown(dropdownId) {
    var dropdown = document.getElementById(dropdownId);
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
}



function fetchFavoriteNotes() {
    // Make an AJAX request to fetch favorite notes
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_favorite_notes.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var favoritesContent = document.getElementById('favoritesContent');
            if (xhr.responseText.trim() === "") {
                // If response is empty, display a message with white text
                favoritesContent.innerHTML = '<p class="no-favorites" style="color: white;">No favorite notes added.</p>';
            } else {
                // Update the favorites content with the fetched favorite notes
                favoritesContent.innerHTML = xhr.responseText;
            }
        }
    };
    xhr.send();
}
// Event listener for the "Favorites" button
document.getElementById('favoritesButton').addEventListener('click', function(event) {
    // Prevent the default behavior of the anchor tag
    event.preventDefault();
    
    // Show the favorites content and fetch favorite notes when the button is clicked
    document.querySelector('.main-content').style.display = 'none'; // Adjusted to target elements with the class 'main-content'
    document.getElementById('favoritesContent').style.display = 'block';

    // Fetch favorite notes using AJAX
    fetchFavoriteNotes();
});



    // function confirmDelete(note_id) {
    //     if (confirm("Are you sure you want to delete?")) {

    //         document.getElementById('delete_note_id').value = note_id;
    //         document.getElementById('deleteForm').submit();
    //     }
    // }

// JavaScript for handling sidebar navigation
document.addEventListener("DOMContentLoaded", function() {
    const sidebarNavigation = document.getElementById('sidebar-navigation');

    // Attach click event listener to the sidebar links
    sidebarNavigation.addEventListener('click', function(event) {
        const target = event.target;
        if (target.tagName === 'A') {
            event.preventDefault();
            const page = target.getAttribute('href');

            // Fetch and display the corresponding content based on the clicked link
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    // Update the main content area with the fetched content
                    document.querySelector('.main-content').innerHTML = data;
                })
                .catch(error => console.error('Error fetching content:', error));
        }
    });
});



    
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.width = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
        textarea.style.width = textarea.scrollWidth + 'px';
    }

    function closeEditPopup() {
        var popup = document.getElementById('popup');
        popup.style.display = 'none';
    }

    function openEditPopup(note_id, note_title, note_content) {
    var popup = document.getElementById('popup');
    var popup_note_id = document.getElementById('popup_note_id');
    var popup_note_title = document.getElementById('popup_note_title');
    var popup_note_content = document.getElementById('popup_note_content');
    var popup_button = document.getElementById('popup_button');

    popup_note_id.value = note_id;
    popup_note_title.value = note_title; // Set note title to the input field
    popup_note_content.value = note_content;

    popup_button.innerText = "Save";

    popup.style.display = 'block';
}



    function closeViewPopup() {
        var viewPopup = document.getElementById('viewNotePopup');
        viewPopup.style.display = 'none';
    }

    function openViewPopup(note_title, note_content) {
    var viewPopup = document.getElementById('viewNotePopup');
    var viewNoteContent = document.getElementById('viewNoteContent');

    viewNoteContent.innerHTML = '<h2>' + note_title + '</h2>' + note_content;
    viewPopup.style.display = 'block';
}

function toggleNoteInputForm() {
    var noteInputForm = document.getElementById('noteInputForm');
    if (noteInputForm.style.display === 'none' || noteInputForm.style.display === '') {
        noteInputForm.style.display = 'block';
    } else {
        noteInputForm.style.display = 'none';
    }
}


// Function to fetch archived notes using AJAX
function fetchArchivedNotes() {
    // Make an AJAX request to the server-side script
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_archived_notes.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Update the HTML with the archived notes received from the server
            document.getElementById('archivedNoteDisplay').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Event listener for the "Archive" button
document.getElementById('archiveButton').addEventListener('click', function(event) {
    // Prevent the default behavior of the anchor tag
    event.preventDefault();
    
    // Fetch archived notes when the button is clicked
    fetchArchivedNotes();
});


function showFavorites() {
    // Hide the main content and show the favorites content
    document.querySelector('.main-content').style.display = 'none'; // Adjusted to target elements with the class 'main-content'
    document.getElementById('favoritesContent').style.display = 'block';

    // Fetch favorite notes using AJAX
    fetchFavoriteNotes();
}

function showNotes() {
    // Make an AJAX request to fetch the user's notes
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_user_notes.php', true); // Adjust the URL to your PHP script that fetches user's notes
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Update the HTML with the fetched user's notes
            document.querySelector('.notes-grid').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}





function searchNotes() {
        var searchInput = document.getElementById('searchInput');
        var filter = searchInput.value.toUpperCase();
        var notes = document.querySelectorAll('.note');

        notes.forEach(function(note) {
            var title = note.querySelector('h2').textContent.toUpperCase();
            var content = note.querySelector('p').textContent.toUpperCase();
            if (title.includes(filter) || content.includes(filter)) {
                note.style.display = '';
            } else {
                note.style.display = 'none';
            }
        });
    }

    function searchNotes() {
        var searchInput = document.getElementById('searchInput');
        var filter = searchInput.value.toUpperCase();
        var notes = document.querySelectorAll('.note');

        notes.forEach(function(note) {
            var title = note.querySelector('h2');
            var content = note.querySelector('p');
            var titleText = title.textContent.toUpperCase();
            var contentText = content.textContent.toUpperCase();

            if (titleText.includes(filter) || contentText.includes(filter)) {
                // Highlight matching text in title
                title.innerHTML = highlightText(titleText, filter);
                // Highlight matching text in content
                content.innerHTML = highlightText(contentText, filter);
                note.style.display = '';
            } else {
                note.style.display = 'none';
            }
        });
    }

    // Function to highlight matching text
    function highlightText(text, filter) {
        var highlightedText = text.replace(new RegExp(filter, 'gi'), function(match) {
            return '<span class="highlight">' + match + '</span>';
        });
        return highlightedText;
    }

    // Attach event listener to the search input
    document.getElementById('searchInput').addEventListener('input', searchNotes);


</script>
</body>
</html>
 
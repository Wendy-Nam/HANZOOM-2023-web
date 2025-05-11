<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    // Retrieve other fields similarly

    // SQL Update Query
    $sql = "UPDATE user SET name = '$name' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Profile updated successfully";
        // Redirect back to the profile page or somewhere else
    } else {
        $message = "Error updating profile: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include CSS and JavaScript for modal -->
    <link rel="stylesheet" href="modal.css">
    <script src="modal.js"></script>
</head>
<body>

<?php
// Display the message in a modal
if (isset($message)) {
    echo '<div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>' . $message . '</p>
            </div>
          </div>';
}
?>

<script>
// JavaScript to show and hide the modal
var modal = document.getElementById('myModal');
var span = document.getElementsByClassName('close')[0];

// Show the modal
modal.style.display = 'block';

// Close the modal after 3 seconds (adjust as needed)
setTimeout(function() {
    modal.style.display = 'none';
}, 3000); // 3000 milliseconds (3 seconds)
</script>

</body>
</html>

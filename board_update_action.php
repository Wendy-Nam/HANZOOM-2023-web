<?php
// Storing and displaying values received from the board_update_form.php page

// Create a MySQL connection object
$conn = mysqli_connect("localhost", "root", "1234", "kau");

// Check if the connection object was created successfully
if ($conn) {
    echo "Connection successful<br>";
} else {
    die("Connection failed: " . mysqli_connect_error());
}

$board_no = $_POST["id"];
$board_title = $_POST["board_title"];
$board_content = $_POST["board_content"];
$board_password = $_POST["password"]; // Adding the password parameter

echo "Post ID: " . $board_no . "<br>";
echo "Post Title: " . $board_title . "<br>";
echo "Post Content: " . $board_content . "<br>";

// Verifying the password first
$verify_sql = "SELECT * FROM post WHERE id = ? AND password = ?";
$stmt_verify = mysqli_prepare($conn, $verify_sql);
mysqli_stmt_bind_param($stmt_verify, "is", $board_no, $board_password);
mysqli_stmt_execute($stmt_verify);
$result_verify = mysqli_stmt_get_result($stmt_verify);

if (mysqli_num_rows($result_verify) > 0) {
    // Password is correct, proceed with the update
    $sql = "UPDATE post SET title=?, text=? WHERE id=?";

    // Create a prepared statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssi", $board_title, $board_content, $board_no);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Update successful";
        header("Location: board_detail.php?id=$board_no");
        exit(); // Use exit to stop code execution after redirection
    } else {
        // Update failed
        $error_message = "Update failed: " . mysqli_error($conn); // Store the error message in a variable

        // Redirect back to the update form page with an alert message
        header("Location: board_update_form.php?id=$board_no&error_message=" . urlencode($error_message));
        exit();
    }
} else {
    // Password is incorrect
    $error_message = "The password is incorrect."; // Error message for incorrect password

    // Redirect back to the update form page with an alert message
    header("Location: board_update_form.php?id=$board_no&error_message=" . urlencode($error_message));
    exit();
}

// Close the statement
mysqli_stmt_close($stmt_verify);

// Close the connection
mysqli_close($conn);
?>

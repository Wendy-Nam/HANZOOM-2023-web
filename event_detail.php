<?php
// Create a MySQL connection object
$conn = mysqli_connect("localhost", "root", "1234", "kau");
mysqli_set_charset($conn, "utf8");

// Confirm the creation of the connection object
if (!$conn) {
    die("Connection failed: " . mysqli_error());
}

// Extract event details based on the provided event_id
$event_id = $_GET["event_id"];
$sql = "SELECT event_id, image, dtype, text, place, duration, url, detail, detail2 FROM event WHERE event_id = '$event_id'";
$result = mysqli_query($conn, $sql);

// Initialize the $content variable
$content = "";

// Check if the query was successful
if ($result && $row = mysqli_fetch_assoc($result)) {
    // Start capturing HTML output into the $content variable
    ob_start();
?>
    <table class="table table-bordered">
        <tr>
            <td style="width: 30%;"><strong><i class="fas fa-calendar-alt event-icon"></i> <span class="event-title text-base ml-1">Name</span></strong></td>
            <td class="text-sm"><?php echo $row["text"]; ?></td>
        </tr>
        <tr>
            <td><strong><i class="fas fa-clock event-icon"></i><span class="event-title text-sm ml-1">Duration</span></strong></td>
            <td class="text-sm"><?php echo $row["duration"]; ?></td>
        </tr>
        <tr>
            <td><strong><span class="event-title">Visit Event Platform</span></strong></td>
            <td><?php echo '<a href="' . $row['url'] . '" target="_blank" class="text-orange-500 underline">Visit Event</a>'; ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <img class="event-image mx-auto" src="<?php echo $row["detail"]; ?>" alt="Event Image">
            </td>
        </tr>
    </table>
		<a class="btn bg-gray-50 hover:bg-gray-100 btn-outline border-2 border-gray-200 hover:border-gray-250 ml-8 sm:ml-12" href="/events.php">
			<svg width="24px" height="24px">
				<use xlink:href="#back_arrow" /><span>Back</span>
			</svg>
		</a>
<?php
    // End capturing HTML output and store it in the $content variable
    $content = ob_get_clean();
}

// Close the MySQL connection
mysqli_close($conn);
?>

<!-- Output the captured HTML content -->
<?php
include('main.php');
?>

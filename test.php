<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>KAU Event List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Event List</h1>
        <?php 
        $conn = mysqli_connect(
            'localhost',
            'root',
            '1234',
            'kau'
        );
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM event";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            echo '<div class="overflow-x-auto">';
            echo '<table class="min-w-full table-auto bg-white shadow-md rounded my-6">';
            echo '<thead>';
            echo '<tr>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Event ID</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Image</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Type</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Text</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Place</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Duration</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">URL</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Detail</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Detail 2</th>';
            echo '<th class="py-2 px-3 bg-gray-200 font-semibold uppercase text-sm text-gray-600">Status</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="py-3 px-4">' . $row['event_id'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['image'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['dtype'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['text'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['place'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['duration'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['url'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['detail'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['detail2'] . '</td>';
                echo '<td class="py-3 px-4">' . $row['status'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="text-gray-600 text-lg">No events found in the database.</div>';
        }

        mysqli_close($conn);
        ?>
    </div>
</body>
</html>

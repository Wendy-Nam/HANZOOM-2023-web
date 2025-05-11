<?php
// load_more.php
include 'board_format.php';
$conn = mysqli_connect("localhost", "root", "1234", "kau");
mysqli_set_charset($conn, "utf8");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$limit = 4; // Number of posts per page
$offset = ($page - 1) * $limit;

$sql = "SELECT p.id, p.title, p.text, p.reg_date, COUNT(pl.post_id) AS like_count, f.file_name
        FROM post p
        LEFT JOIN post_like pl ON p.id = pl.post_id
        LEFT JOIN file f ON p.id = f.post_id
        WHERE category_id = $category_id
        GROUP BY p.id, p.title, p.text, p.reg_date, f.file_name
        ORDER BY p.id ASC 
        LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        // 게시글 전체 내용을 포함하여 출력
        echo "<div class='border-b-2 border-gray-200 flex justify-between items-center'>";
        echo "<div class='bg-white p-2'>";
        echo "<a href='/board_detail.php?id=" . $row["id"] . "'>";
        echo "<h2 class='text-xl font-semibold' data-translate>" . $row["title"] . "</h2>";
        echo "</a>";
        echo "<p class='text-gray-700 mt-1' data-translate>" . shortenText($row["text"]) . "</p>"; // 전체 텍스트 출력
        echo "<div class='flex justify-start mt-3 space-x-2'>";
        echo "<p class='text-gray-500 mb-2'>";
        if ($row["like_count"] > 0) {
            echo "<i class='fas fa-thumbs-up mr-1 text-orange-400'></i><span class='text-orange-400'>" . $row["like_count"] . "</span>";
        }
        echo "</p>";
        echo "<p class='text-gray-500 mb-1'>" . getTimeAgo($row["reg_date"]) . "</p>";
        echo "</div>";
        echo "</div>";
        if ($row["file_name"]) {
            echo "<img class='rounded-lg m-2 mobile-hidden' src='" . $row["file_name"] . "' alt='' width='150rem' height='auto'>";
        } else {
            echo "<img class='rounded-lg m-2 mobile-hidden' src='./images/board_default.png' alt='' width='150rem' height='auto'>";
        }
        echo "</div>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

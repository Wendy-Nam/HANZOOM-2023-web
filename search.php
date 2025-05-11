<?php
// search.php
include('board_format.php');
session_start();
ob_start(); // Output buffering 시작
// DB 연결 코드 등을 추가하세요.
$conn = mysqli_connect("localhost", "root", "1234", "kau");
mysqli_set_charset($conn, "utf8");
// 사용자가 입력한 검색어
$searchTerm = $_GET['q'];

// 검색 쿼리
$sql = "SELECT * FROM post WHERE title LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing the search query: " . mysqli_error($conn));
}

// 검색 결과를 표시
while ($row = mysqli_fetch_assoc($result)) {
    // 여기에서 각 검색 결과를 게시판 형태로 표시
    displaySearchResult($row);
}

// DB 연결을 닫습니다.
mysqli_close($conn);
$content = ob_get_clean(); // Output을 $content에 저장
include("main.php");

// displaySearchResult 함수를 정의합니다.
function displaySearchResult($row) {
    // displayBoardList 함수와 유사한 방식으로 검색 결과를 표시
    echo "<div class='border-b-2 border-gray-200 flex justify-between items-center'>";
    echo "<div class='bg-white p-2'>";
    echo "<a href='/board_detail.php?id={$row["id"]}'>";
    echo "<h2 class='text-xl font-semibold' data-translate>{$row["title"]}</h2>";
    echo "</a>";
    echo "<p class='text-gray-700 mt-1' data-translate>" . shortenText($row["text"]) . "</p>";
    echo "<div class='flex justify-start mt-3 space-x-2'>";

    echo "<style>";
    echo "@media only screen and (max-width: 650px) {";
    echo ".mobile-hidden {";
    echo "display: none;";
    echo "}";
    echo "}";
    echo "</style>";
}
?>


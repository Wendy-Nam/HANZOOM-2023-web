<?php
header('Content-Type: html; charset=UTF-8');
include('board_format.php');
session_start();
ob_start(); // Output buffering 시작
?>

<?php
$category_id = 1; // 카테고리 ID 설정 (예시: 1)
$category_name = "Dashboard"; // 게시판 이름 설정

// 함수 호출 시 카테고리 ID와 이름을 전달
displayBoardList($category_id, $category_name);

$content = ob_get_clean(); // Output을 $content에 저장
include("main.php");
?>
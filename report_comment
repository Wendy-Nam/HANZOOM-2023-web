<?php
session_start();
ob_start();

$conn = mysqli_connect("localhost", "root", "1234", "kau");
if (!$conn) {
    die("Connection Failed: " . mysqli_error());
}

// 현재 로그인한 사용자의 ID를 가져옵니다.
$reporterId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

if ($reporterId === null) {
    // 로그인되지 않은 사용자는 신고를 할 수 없습니다.
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

// POST 데이터에서 댓글 ID와 신고 이유를 가져옵니다.
$commentId = isset($_POST["comment_id"]) ? (int)$_POST["comment_id"] : null;
$reportReason = isset($_POST["report_reason"]) ? mysqli_real_escape_string($conn, $_POST["report_reason"]) : null;

if ($commentId === null || $reportReason === null) {
    // 필수 데이터가 제공되지 않으면 오류를 반환합니다.
    echo json_encode(["error" => "Missing data"]);
    exit();
}

// 삽입 쿼리를 실행합니다.
$insertReportSql = "INSERT INTO report (reporter_id, comment_id, reason, status) VALUES ('$reporterId', '$commentId', '$reportReason', 'pending')";
$insertReportResult = mysqli_query($conn, $insertReportSql);

if ($insertReportResult) {
    // 성공적으로 삽입되었을 경우
    echo json_encode(["success" => true]);
} else {
    // 삽입에 실패한 경우
    echo json_encode(["error" => "Failed to insert report"]);
}

mysqli_close($conn);
?>

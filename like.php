<?php
$conn = mysqli_connect("localhost", "root", "1234", "kau");
header('Content-Type: application/json');

if (!$conn) {
    die("연결 실패 : " . mysqli_error());
}

session_start();

$action = $_POST['action'];
$postId = $_POST['post_id'];
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if ($action === 'get') { // 추가: 좋아요 상태를 가져오는 액션 처리
    $likeQuery = "SELECT * FROM post_like WHERE user_id = $userId AND post_id = $postId";
    $likeResult = mysqli_query($conn, $likeQuery);
    $liked = mysqli_num_rows($likeResult) > 0;

    $response = array('liked' => $liked);
    echo json_encode($response);
} elseif ($action === 'toggle') {
    // 좋아요 토글 처리
    $likeQuery = "SELECT * FROM post_like WHERE user_id = $userId AND post_id = $postId";
    $likeResult = mysqli_query($conn, $likeQuery);
    $liked = mysqli_num_rows($likeResult) > 0;

    if ($liked) {
        $deleteQuery = "DELETE FROM post_like WHERE user_id = $userId AND post_id = $postId";
        mysqli_query($conn, $deleteQuery);
    } else {
        $insertQuery = "INSERT INTO post_like (user_id, post_id) VALUES ($userId, $postId)";
        mysqli_query($conn, $insertQuery);
    }

    $response = array('liked' => !$liked);
    echo json_encode($response);
}
?>

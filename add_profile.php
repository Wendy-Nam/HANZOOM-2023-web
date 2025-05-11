<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_additional_info'])) {
    $sns_address = $_POST['sns_address'];
    $stay_duration = $_POST['stay_duration'];
    $stay_purpose = $_POST['stay_purpose'];
    $gender = $_POST['gender'];
    $user_id = $_SESSION['id']; // 현재 세션에서 사용자 ID를 가져옴

    // SQL Update Query
    $sql = "UPDATE user SET sns_address = '$sns_address', stay_duration = '$stay_duration', stay_purpose = '$stay_purpose', gender = '$gender' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Additional info added successfully";
    } else {
        echo "Error adding additional info: " . mysqli_error($conn);
    }

    // 세션 또는 기타 필요한 처리 수행
} else {
    echo "Invalid request"; // 유효하지 않은 요청 처리
}

mysqli_close($conn);
?>

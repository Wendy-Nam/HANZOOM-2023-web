<?php
    // MySQL 서버와 연결
    $conn = mysqli_connect("localhost", "root", "1234", "kau");

    // 연결 상태 확인
    if(!$conn) {
        die("연결 실패 : " . mysqli_connect_error());
    }

    // 글 번호와 비밀번호 받아오기
    $id = $_POST["id"];
    $password = $_POST["password"];
    
    // SQL 쿼리 생성
    $sql = "SELECT * FROM post WHERE id = $id AND password = '$password'";
    
    // 쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // 일치하는 글이 존재하는 경우 삭제 수행
        $delete_sql = "DELETE FROM post WHERE id = $id";
        $delete_result = mysqli_query($conn, $delete_sql);
        
        if ($delete_result) {
            // 삭제 성공 시
            header("Location: user_info.php");
            exit();
        } else {
            // 삭제 실패 시 오류 메시지 전달
            header("Location: board_detail.php?id=$id&error=DeleteFailed");
            exit();
        }
    } else {
        // 일치하는 글이 없는 경우 오류 메시지 전달
        header("Location: board_detail.php?id=$id&error=NoMatch");
        exit();
    }

    // 연결 종료
    mysqli_close($conn);
?>

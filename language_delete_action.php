<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>language_delete.php</title>
</head>
<body>
    <h1>Language Delete </h1>
    <?php
        //board_delete_form.php 페이지에서 넘어온 글 번호값 저장 및 출력
        
        
        //mysql 커넥션 객체 생성
        $conn = mysqli_connect("localhost", "root", "1234", "kau");

        //커넥션 객체 생성 여부 확인
        if($conn) {
            echo "연결 성공<br>";
        } else {
            die("연결 실패 : " .mysqli_connect_error());
        }

        $id = $_POST["id"];
        $password = $_POST["password"];
        echo "id : " . $id . "<br>";
        echo "password : " . $password . "<br>";
        // board 테이블에서 입력된 글 번호와 글 비밀번호가 일치하는 행 삭제 쿼리
        $sql = "DELETE FROM post WHERE password = $password AND id = $id";
        
        // Create a prepared statement
        $stmt = mysqli_prepare($conn, $sql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "si", $password, $id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "삭제 성공"; 
            header("Location: living.php");
            exit(); // 리다이렉션 이후에는 코드 실행을 중지하기 위해 exit 사용
        } else {
            echo "삭제 실패: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
        
        mysqli_close($conn);
        // 헤더 함수를 이용하여 리스트 페이지로 리다이렉션
    ?>
</body>
</html>

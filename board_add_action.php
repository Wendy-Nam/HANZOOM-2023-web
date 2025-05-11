<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>board_add_action.php</title>
</head>
<body>
    <h1>board_add_action.php</h1>
    <?php
    try {
        require 'vendor/autoload.php'; // 경로를 실제 autoload.php 파일 경로로 변경
    } catch (Exception $e) {
        echo "Autoload 오류: " . $e->getMessage();
        exit;
    }
    echo 1;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    echo 1;
    use Aws\S3\S3Client;
    use Ramsey\Uuid\Uuid;
    use Aws\S3\Exception\S3Exception;
    echo 2;
    try {
        try {
            // AWS S3 클라이언트 초기화
            $s3Client = new Aws\S3\S3Client([
                'version' => 'latest',
                'region' => 'ap-northeast-2',
                'credentials' => [
                    'key'    => '', // 여러분의 AWS 액세스 키로 대체
                    'secret' => '', // 여러분의 AWS 시크릿 키로 대체
                ],
            ]);
            echo 4; // 이 코드가 실행되지 않으면 예외가 발생한 것일 수 있음
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage();
            echo "<br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
            echo 5;
        }


        // 세션에서 사용자 ID 가져오기
        if (isset($_SESSION["user_id"])) {
            $author_id = $_SESSION["user_id"];
            echo 6;
        } else {
            echo "로그인이 필요합니다.";
            exit;
        }

        // 폼 데이터 가져오기
        $password = $_POST["password"];
        $title = $_POST["Title"];
        $text = $_POST["content"];
        $reg_date = $_POST["boardDate"];
        $category_id = $_POST["category_id"];

        // 데이터베이스 연결
        $conn = mysqli_connect("localhost", "root", "1234", "kau");

        if (!$conn) {
            die("데이터베이스 연결에 실패했습니다: " . mysqli_connect_error());
        }
        
        $title = mysqli_real_escape_string($conn, $title);
        $text = mysqli_real_escape_string($conn, $text);
        
        $text=htmlspecialchars( $text, ENT_NOQUOTES, 'UTF-8');
        


        // 게시물 삽입 쿼리
        $sqlInsertPost = "INSERT INTO post (title, password, text, author_id, reg_date, category_id, comments_enabled) VALUES ('$title', '$password', '$text', '$author_id', '$reg_date', '$category_id', '1')";
        $resultInsertPost = mysqli_query($conn, $sqlInsertPost);

        if ($resultInsertPost) {
            // 삽입된 게시물의 ID 가져오기
            $postId = mysqli_insert_id($conn);

            // 이미지 업로드 관련 설정
            if (isset($_FILES['image'])) {
                echo 7;
                $file = $_FILES['image'];

                // S3에 저장될 폴더 경로 설정
                $folderPath = '/';

                // 파일명 생성
                $tempFileName = str_replace('-', '', Uuid::uuid4()->toString());
                echo 9;
                $fileExtension = strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION));
                $s3FilePath = $tempFileName . '.' . $fileExtension;

                // S3에 파일 업로드
                try {
                    echo 11;
                    $file_handler = fopen($file['tmp_name'], 'r');
                    $s3Client->putObject([
                        'Bucket' => 'websw',
                        'Key'    => $folderPath . $s3FilePath,
                        'Body'   => $file_handler,
                        'ACL'    => 'public-read',
                    ]);

                    // 업로드된 파일의 URL
                    $url = $s3Client->getObjectUrl('websw', $folderPath . $s3FilePath);
                    echo 12;
                    // 데이터베이스에 파일 정보 삽입
                    $sqlInsertFile = "INSERT INTO file (post_id, file_name) VALUES ('$postId', '$url')";
                    $resultInsertFile = mysqli_query($conn, $sqlInsertFile);
                    echo 14;
                    if ($resultInsertFile) {
                        echo 13;
                        echo "게시물이 성공적으로 추가되었습니다. 이미지 URL: " . $url;
                        header("Location: board_list.php");
                        exit();
                    } else {
                        echo "파일 정보 삽입 오류: " . mysqli_error($conn);
                    }

                    fclose($file_handler);
                } catch (S3Exception $e) {
                    echo "S3 업로드 오류: " . $e->getMessage();
                }
            }
        } else {
            echo "게시물 정보 삽입 오류: " . mysqli_error($conn);
        }

        // 데이터베이스 연결 종료
        mysqli_close($conn);
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
        echo "<br>Trace: <pre>" . $e->getTraceAsString() . "</pre>";
    }
    ?>

</body>
</html>

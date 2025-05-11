<?php
session_start();
ob_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>services_add_action.php</title>
</head>
<body>
    <h1>services_add_action.php</h1>

    <?php
    try {
        require 'vendor/autoload.php';
    } catch (Exception $e) {
        echo "Autoload 오류: " . $e->getMessage();
        exit;
    }

    // AWS S3 클라이언트 초기화
    use Aws\S3\S3Client;
    use Ramsey\Uuid\Uuid;
    use Aws\S3\Exception\S3Exception;

    $s3Client = new Aws\S3\S3Client([
        'version' => 'latest',
        'region' => 'ap-northeast-2',
        'credentials' => [
            'key'    => '', // 여러분의 AWS 액세스 키로 대체
            'secret' => '', // 여러분의 AWS 시크릿 키로 대체
        ],
    ]);

    // 세션에서 사용자 ID 가져오기
    if (isset($_SESSION["user_id"])) {
        $author_id = $_SESSION["user_id"];
    } else {
        echo "로그인이 필요합니다.";
        exit;
    }

    // 폼 데이터 가져오기
    $dtype = $_POST["dtype"];
    $text = $_POST["text"];
    $place = $_POST["place"];
    $duration = $_POST["duration"];
    $url = $_POST["url"];
    $detail = $_POST["detail"];

    // 데이터베이스 연결
    $conn = mysqli_connect("localhost", "root", "1234", "kau");

    if (!$conn) {
        die("데이터베이스 연결에 실패했습니다: " . mysqli_connect_error());
    }

    // 이미지 업로드 관련 설정
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];

        // S3에 저장될 폴더 경로 설정
        $folderPath = '/';

        // 파일명 생성
        $tempFileName = str_replace('-', '', Uuid::uuid4()->toString());
        $fileExtension = strtoupper(pathinfo($file['name'], PATHINFO_EXTENSION));
        $s3FilePath = $tempFileName . '.' . $fileExtension;

        // S3에 파일 업로드
        try {
            $file_handler = fopen($file['tmp_name'], 'r');
            $s3Client->putObject([
                'Bucket' => 'websw',
                'Key'    => $folderPath . $s3FilePath,
                'Body'   => $file_handler,
                'ACL'    => 'public-read',
            ]);

            // 업로드된 파일의 URL
            $url2 = $s3Client->getObjectUrl('websw', $folderPath . $s3FilePath);

            // 게시물 삽입 쿼리
            $sqlInsertPost = "INSERT INTO information (image, dtype, text, place, duration, url, detail) VALUES ('$url2', 'korea', '$text', '$place', '$duration', '$url', '$detail')";
            $resultInsertPost = mysqli_query($conn, $sqlInsertPost);

            if ($resultInsertPost) {
                echo "게시물이 성공적으로 추가되었습니다. 이미지 URL: " . $url;
                header("Location: services.php");
                exit();
            } else {
                echo "게시물 정보 삽입 오류: " . mysqli_error($conn);
            }

            fclose($file_handler);
        } catch (S3Exception $e) {
            echo "S3 업로드 오류: " . $e->getMessage();
        }
    } else {
        echo "이미지가 제공되지 않았습니다.";
    }

    // 데이터베이스 연결 종료
    mysqli_close($conn);
    ?>
</body>
</html>

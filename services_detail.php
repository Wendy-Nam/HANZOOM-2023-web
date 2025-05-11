<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Information Detail</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <style>
        body {
            padding-top: 56px;
        }

        .information-detail {
            max-width: 800px;
            margin: 0 auto;
        }

        .information-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5 event-detail">
        
        <?php
            // MySQL connection object creation
            $conn = mysqli_connect("localhost", "root", "1234", "kau");
            mysqli_set_charset($conn, "utf8");

            // Connection object creation confirmation
            if (!$conn) {
                die("연결 실패: " . mysqli_error());
            }

            // Extracting event details based on the provided event_id
            $information_id = $_GET["information_id"];
            $sql = "SELECT information_id, image, dtype, text, place, duration, url, detail FROM information WHERE information_id = '$information_id'";
            $result = mysqli_query($conn, $sql);

            // Checking if the query was successful
            if ($result && $row = mysqli_fetch_assoc($result)) {
        ?>
        <table class="table table-bordered">
            <tr>
                <td style="width: 15%;"><strong>제목</strong></td>
                <td><?php echo $row["text"]; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <img class="information-image" src="<?php echo $row["image"]; ?>" alt="Information Image">
                </td>
            </tr>
            <tr>
                <td><strong>공고 기간</strong></td>
                <td><?php echo $row["duration"]; ?></td>
            </tr>
            <tr>
                <td><strong>장소</strong></td>
                <td><?php echo $row["place"]; ?></td>
            </tr>
            <tr>
                <td><strong>공고 플랫폼으로 이동</strong></td>
                <td><?php echo '<a href="' . $row['url'] . '" target="_blank">Visit information</a>'; ?></td>
            </tr>
            <tr>
                <td><strong>상세게시글</strong></td>
                <td><?php echo $row["deatil"]; ?></td>
            </tr>
            
        </table>
        <?php
            }

            // Closing the MySQL connection
            mysqli_close($conn);
        ?>
        
        <a class="btn btn-primary" href="/services.php">리스트로 돌아가기</a>
    </div>

    <script type="text/javascript" src="js/bootstrap.js"></script>
</body>
</html>

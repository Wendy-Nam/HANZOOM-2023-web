<?php
session_start();
ob_start();
?>
<?php
// Check if there's an error message in the URL
if (isset($_GET['error_message'])) {
    $error_message = $_GET['error_message'];
    echo "<script>alert('$error_message');</script>";
}

?>
<div class="container">
    <div class="max-w-xl mx-auto">
        <form action="/board_update_action.php" method="post" class="bg-white rounded px-4 pt-6 pb-8 mb-4">
            <?php
                // 커넥션 객체 생성 (데이터 베이스 연결)
                $conn = mysqli_connect("localhost", "root", "1234", "kau");
                // 연결 성공 여부 확인
                if ($conn) {
                    echo "연결 성공<br>";
                } else {
                    die("연결 실패 : " . mysqli_error());
                }
                $board_no = $_GET["id"];
                echo $board_no . "번째 글 수정 페이지<br>";
                // board 테이블을 조회하여 board_no의 값이 일치하는 행의 board_no, board_title, board_content, board_user, board_date 필드의 값을 가져오는 쿼리
                $sql = "SELECT id, title as board_title, text as board_content, author_id, update_date FROM post WHERE id = '" . $board_no . "'";
                $result = mysqli_query($conn, $sql);
                if ($row = mysqli_fetch_array($result)) {
            ?>
            <br>
            <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
            <!-- Password Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="password" placeholder="Password" pattern="\d+" title="비밀번호는 숫자로만 입력하세요" required/>
            </div>

            <!-- Title Input -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="board_title">Title</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="board_title" id="board_title" value="<?php echo $row["board_title"] ?>" placeholder="Title" required>
            </div>

            <!-- Content Textarea -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="board_content">Contents</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="board_content" id="board_content" rows="5" placeholder="Content" required><?php echo $row["board_content"] ?></textarea>
            </div>

            <!-- Form Buttons -->
            <div class="flex items-center space-x-4 text-bold">
                <button class="btn bg-yellow-400 hover:bg-orange-400" type="submit">Update</button>
                <a class="btn bg-yellow-400 hover:bg-orange-400" href="/board_list.php">Cancel</a>
            </div>
            <?php
                }
                // 커넥션 객체 종료
                mysqli_close($conn);
            ?>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include("main.php");
?>

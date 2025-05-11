<?php
session_start();
ob_start();

$conn = mysqli_connect("localhost", "root", "1234", "kau");
if (!$conn) {
    die("Connection Failed: " . mysqli_error());
}

$id = $_GET["id"];

$sql = "SELECT post.id, post.title, post.text, post.author_id, post.reg_date, file.file_name, user.name 
    FROM post 
    LEFT JOIN file ON post.id = file.post_id 
    LEFT JOIN user ON post.author_id = user.user_id 
    WHERE post.id = '" . $id . "'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "No results: " . mysqli_error($conn);
}

$content = ob_get_clean(); // Output을 $content에 저장

include("main.php");
?>

<div class="max-w-2xl mx-auto my-10 p-6 bg-white">
    <?php
    if ($row = mysqli_fetch_array($result)) {

        if (isset($_SESSION["id"]) && $row["author_id"] == $_SESSION["id"]) { ?>
            <a href='/board_delete_form.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class='text-red-500 hover:underline'>Delete</a>
        <?php } ?>

        <div class="mb-6">
            <h2 class="text-3xl font-bold mb-2" data-translate><?php echo $row["title"]; ?></h2>
            <p class="text-gray-700 font-normal">By <span class="font-medium"><?php echo $row["author_id"]; ?></span> on <span class="font-medium"><?php echo $row["reg_date"]; ?></span></p>
        </div>

        <?php if ($row["file_name"]) : ?>
            <img class="w-full h-auto mb-6 rounded" src="<?php echo $row['file_name']; ?>" alt="Post Image">
        <?php endif; ?>

        <div class="prose lg:prose-xl">
            <p data-translate>
                <?php echo nl2br($row["text"]); ?>
            </p>
        </div>

        <div class="flex space-x-4 mt-4">
            <a class="btn bg-yellow-300 hover:bg-yellow-400 btn-circle btn-outline border-2 border-yellow-400 hover:border-yellow-600" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                <svg width="24px" height="24px">
                    <use xlink:href="#back_arrow" />
                </svg>
            </a>
            <button class="btn items-center bg-gray-100 hover:bg-yellow-300" id="likeButton">
            </button>
        </div>

        <!-- Comment input form -->
        <form method="post" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <textarea name="comment_text" placeholder="댓글을 입력하세요"></textarea>
            <input type="submit" value="댓글 작성">
        </form>

        <?php
        // 기존에 작성된 모든 댓글을 가져오는 SQL 쿼리
        $getAllCommentsSql = "SELECT * FROM comments WHERE post_id = '$id' ORDER BY comment_date ASC";
        $getAllCommentsResult = mysqli_query($conn, $getAllCommentsSql);

        while ($commentRow = mysqli_fetch_array($getAllCommentsResult)) {
            echo '<div class="comment">';
            echo '<p><strong>' . $commentRow["username"] . '</strong> - ' . $commentRow["comment_date"] . '</p>';
            echo '<p>' . $commentRow["comment_text"] . '</p>';
            echo '</div>';
        }

        // 추가한 댓글을 데이터베이스에 저장
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 폼이 제출되면 실행될 코드

            // 사용자가 입력한 댓글 텍스트
            $comment_text = mysqli_real_escape_string($conn, $_POST["comment_text"]);

            // 현재 로그인한 사용자의 ID와 username 가져오기
            $user_id = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : null;
            $username = isset($_SESSION["name"]) ? $_SESSION["name"] : null;

            // 로그인된 사용자인 경우에만 댓글 추가
            if ($user_id !== null && $username !== null) {
                // 현재 포스트의 ID
                $post_id = $id;

                // 댓글을 데이터베이스에 추가하는 SQL 쿼리
                $insertCommentSql = "INSERT INTO comments (user_id, username, post_id, comment_text) VALUES ('$user_id', '$username', '$post_id', '$comment_text')";

                // 쿼리 실행
                $insertCommentResult = mysqli_query($conn, $insertCommentSql);

                if ($insertCommentResult) {
                    // 댓글이 성공적으로 추가되었습니다.

                    // 새로 추가한 댓글을 화면에 바로 보이게 하려면 해당 부분을 수정해야 합니다.
                    // 추가한 댓글만을 가져오는 SQL 쿼리
                    $getNewCommentSql = "SELECT * FROM comments WHERE post_id = '$id' AND comment_date > NOW() - INTERVAL 1 SECOND ORDER BY comment_date ASC";
                    $getNewCommentResult = mysqli_query($conn, $getNewCommentSql);

                    while ($newCommentRow = mysqli_fetch_array($getNewCommentResult)) {
                        echo '<div class="comment">';
                        echo '<p><strong>' . $newCommentRow["username"] . '</strong> - ' . $newCommentRow["comment_date"] . '</p>';
                        echo '<p>' . $newCommentRow["comment_text"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "댓글 추가 실패: " . mysqli_error($conn);
                }
            } else {
                echo "로그인이 필요합니다.";
            }
        }
        ?>
    <?php
    } else {
        echo "No results for post ID: " . $id;
    }
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var postId = <?php echo $id; ?>;
        updateLikeButtonState(postId);
    });

    function updateLikeButtonState(postId) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status !== 200) {
                    console.error("Request failed with status: ", xhr.status);
                    return;
                }

                try {
                    var response = JSON.parse(xhr.responseText);
                    setLikeButtonState(response.liked);
                } catch (e) {
                    console.log("Server Response: ", xhr.responseText);
                    console.error("Error parsing JSON: ", e.message);
                    console.log("JSON String: ", xhr.responseText);
                }
            }
        };

        xhr.open('POST', '/like.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('action=get&post_id=' + postId);
    }

    function setLikeButtonState(liked) {
        var likeButton = document.getElementById('likeButton');
        likeButton.classList.toggle('liked', liked);
        if (liked) {
            likeButton.classList.remove('bg-gray-100')
            likeButton.classList.add('bg-yellow-400');
            likeButton.innerHTML = '<svg width="24px" height="24px" fill="white"><use xlink:href="#liked_solid" /></svg><span class="text-base mt-1">Liked</span>';
        } else {
            likeButton.classList.remove('bg-yellow-400');
            likeButton.classList.add('bg-gray-100')
            likeButton.innerHTML = '<svg width="24px" height="24px" fill="white"><use xlink:href="#liked_outline" /></svg><span class="text-base mt-1 text-gray-400">Like</span>';
        }
    }

    const likeButton = document.getElementById('likeButton');
    likeButton.addEventListener('click', function () {
        this.classList.toggle('liked');
        var postId = <?php echo $id; ?>;
        likeUnlikePost(postId, function (liked) {
            setLikeButtonState(liked);
        });
    });

    function likeUnlikePost(postId, callback) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status !== 200) {
                    console.error("Request failed with status: ", xhr.status);
                    return;
                }

                try {
                    var response = JSON.parse(xhr.responseText);
                    callback(response.liked);
                } catch (e) {
                    console.log("Server Response: ", xhr.responseText);
                    console.error("Error parsing JSON: ", e.message);
                    console.log("JSON String: ", xhr.responseText);
                }
            }
        };

        xhr.open('POST', '/like.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('action=toggle&post_id=' + postId);
    }
</script>
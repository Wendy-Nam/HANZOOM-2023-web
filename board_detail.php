<style>
    /* Add some styles for comments */
    .comment {
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .comment p {
        margin: 0;
    }

    /* Style the comment form */
    form {
        margin-top: 20px;
    }

    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    
</style>

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
		?>
        <div class="mb-6">
            <h2 class="text-3xl font-bold mb-2" data-translate><?php echo $row["title"]; ?></h2>
			<div class="flex flex-row space-x-4">
				<p class="text-gray-700 font-normal">By <span class="font-medium"><?php echo $row["author_id"]; ?></span> on <span class="font-medium"><?php echo $row["reg_date"]; ?></span></p>
				<?php if (isset($_SESSION["id"]) && $row["author_id"] == $_SESSION["user_id"]) { ?>
                    <span><button onclick="openDeleteModal()" class='opacity-60'>
                        <svg width="18px" height="20px">
                            <use xlink:href="#delete_icon"/>
                        </svg></button></span>
                    <span><a href='/board_update_form.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>
                        <svg width="18px" height="20px">
                            <use xlink:href="#edit_icon"/>
                        </svg>
                    </a></span>
                <?php } ?>
			</div>
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
            <a class="btn bg-gray-50 hover:bg-gray-100 btn-circle btn-outline border-2 border-gray-200 hover:border-gray-250" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                <svg width="24px" height="24px">
                    <use xlink:href="#back_arrow" />
                </svg>
            </a>
            <button class="btn items-center bg-gray-100 hover:bg-yellow-300 rounded-full" id="likeButton">
            </button>
			<!-- 아이콘으로 변경된 신고 버튼 -->
			<button onclick="openReportModal()" class="opacity-60">
				<i class="fas fa-flag"></i> <!-- 신고 아이콘 -->
			</button>
			    <div id="reportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto p-6">
            <h2 class="text-2xl font-bold mb-4">Report This Post</h2>
            <form id="reportForm">
                <textarea name="reportReason" id="reportReason" class="w-full h-20 p-2 mb-4 rounded-lg border" placeholder="Please provide details about the issue" required></textarea>

                <button type="button" onclick="submitReport()"class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit Report</button>
                <!-- 추가: 모달 창 닫기 버튼 -->
                <button type="button" onclick="closeReportModal() "class="bg-red-500 text-white px-4 py-2 rounded-md" >Close</button>
            </form>
        </div>
    </div>

    <div id="reportModalBackdrop" class="hidden fixed inset-0 z-40 bg-black bg-opacity-50" onclick="closeReportModal()"></div>
        </div>
		<!-- Comment input form -->
		<div class="mt-8">
			<form method="post" action="" class="space-y-4">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="space-y-2">
					<label for="comment_text" class="text-lg font-semibold">Leave your comments here</label>
					<div class="flex items-center space-x-2">
						<textarea name="comment_text" id="comment_text" class="w-full h-12 p-2 rounded-lg border" placeholder="What do you think of this topic?" required></textarea>
						<button type="submit" class="bg-orange-300 text-white hover:bg-orange-400 transition duration-300 ease-in-out rounded-md p-2 h-12 w-16">
							<i class="fas fa-paper-plane"></i> <!-- 비행기 아이콘 -->
						</button>
					</div>
				</div>
			</form>
		</div>
	<!-- Modal backdrop, hidden by default -->
		<div id="deleteModalBackdrop" class="fixed inset-0 z-40 <?php echo isset($_GET["error"]) ? '' : 'hidden'; ?> bg-black bg-opacity-50"></div>

		<!-- Modal structure -->
		<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center <?php echo isset($_GET["error"]) ? '' : 'hidden'; ?>">
			<!-- Modal content -->
			<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto p-6">
				<!-- Include the content of board_delete_form.php here -->
				<?php include("board_delete_form.php"); ?>
			</div>
		</div>
        <?php
        // 기존에 작성된 모든 댓글을 가져오는 SQL 쿼리
        $getAllCommentsSql = "SELECT * FROM comments WHERE post_id = '$id' ORDER BY comment_date ASC";
        $getAllCommentsResult = mysqli_query($conn, $getAllCommentsSql);

        while ($commentRow = mysqli_fetch_array($getAllCommentsResult)) {
            ?><div class="bg-gray-50 p-4 rounded-lg shadow-md mb-4 mt-4">
					<p class="text-lg font-semibold"><?php echo $commentRow["username"]; ?> <span class="ml-1 font-light text-sm">
                        <?php echo $commentRow["comment_date"]; ?>s</span>
                        <span><button onclick="openReportModal()" class="opacity-60">
                        <i class="fas fa-flag"></i> <!-- 신고 아이콘 -->
                        </button></span></p>
					<p class="mt-2 text-gray-800 text-base"><?php echo $commentRow["comment_text"]; ?></p>
				</div><?php
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
                       	echo '<div class="bg-gray-50 p-4 rounded-lg shadow-md mb-4">';
						echo '<p class="text-lg font-semibold">' . $newCommentRow["username"] . ' <span class="ml-1 font-light text-sm">' . $newCommentRow["comment_date"] . 's</span>';
						echo '<span><button onclick="openReportModal()" class="opacity-60">';
						echo '<i class="fas fa-flag"></i> <!-- 신고 아이콘 -->';
						echo '</button></span></p>';
						echo '<p class="mt-2 text-gray-800 text-base">' . $newCommentRow["comment_text"] . '</p>';
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
function closeReportModal() {
    var reportModal = document.getElementById('reportModal');
    if (reportModal) {
        reportModal.classList.add('hidden');
    }

    var reportModalBackdrop = document.getElementById('reportModalBackdrop');
    if (reportModalBackdrop) {
        reportModalBackdrop.classList.add('hidden');
    }
}
    
    function openReportModal() {
        // 모달을 엽니다.
        var reportModal = document.getElementById('reportModal');
        reportModal.classList.remove('hidden');

        // 배경 모달을 엽니다.
        var reportModalBackdrop = document.getElementById('reportModalBackdrop');
        reportModalBackdrop.classList.remove('hidden');
    }
    


function submitReport() {
    var reportReason = document.getElementById('reportReason').value;
    var postId = <?php echo $id; ?>; // 현재 포스트의 ID를 가져옵니다.

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status !== 200) {
                console.error("Request failed with status: ", xhr.status);
                return;
            }

            try {
                var response = JSON.parse(xhr.responseText);
                // 성공적으로 처리되면 모달을 닫을 수 있습니다.
                closeReportModal();
                // 여기서 추가적인 동작을 수행할 수 있습니다.
            } catch (e) {
                console.log("Server Response: ", xhr.responseText);
                console.error("Error parsing JSON: ", e.message);
                console.log("JSON String: ", xhr.responseText);
            }
        }
    };

    xhr.open('POST', '/report.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('post_id=' + postId + '&report_reason=' + encodeURIComponent(reportReason));
}

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
// 삭제 폼 모달창 로드
// Function to open the modal and backdrop
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModalBackdrop').classList.remove('hidden');
}

// Function to close the modal and backdrop
// 모달을 닫는 함수
function closeModal() {
    // 모달을 숨깁니다.
    var modalElement = document.getElementById('deleteModal');
    if (modalElement) {
        modalElement.classList.add('hidden');
    }

    // 배경 모달을 숨깁니다.
    var backdropElement = document.getElementById('deleteModalBackdrop');
    if (backdropElement) {
        backdropElement.classList.add('hidden');
    }

    // GET 파라미터에서 'error'를 제거하고 다른 파라미터는 그대로 유지합니다.
    var urlWithoutError = removeErrorFromURL();

    // 페이지를 갱신합니다.
    if (urlWithoutError) {
        history.pushState({}, null, urlWithoutError);
    }
}

// GET 파라미터에서 'error'를 제거하고 다른 파라미터는 그대로 유지하는 함수
function removeErrorFromURL() {
    var url = window.location.href;
    var urlParts = url.split('?');
    if (urlParts.length === 2) {
        var params = new URLSearchParams(urlParts[1]);
        
        // 'error' 파라미터만 제거
        params.delete('error');
        
        // 다른 파라미터는 그대로 유지
        var remainingParams = Array.from(params.keys()).map(function (key) {
            return key + '=' + params.get(key);
        });
        
        return urlParts[0] + '?' + remainingParams.join('&');
    }
    return url;
}

// Add event listeners to open and close the modal
document.getElementById('closeModal').addEventListener('click', closeModal);
// document.getElementById('cancelDelete').addEventListener('click', closeModal);
</script>
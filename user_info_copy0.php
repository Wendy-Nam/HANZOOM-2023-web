<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}
$mno = $_SESSION['user_id'];
$user_id = $_SESSION['id'];

// Update Profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    // Retrieve other fields similarly

    // SQL Update Query
    $sql = "UPDATE user SET name = '$name' WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Profile updated successfully";
        $messageClass = "bg-green-100 border-green-400 text-green-800";
    } else {
        $message = "Error updating profile: " . mysqli_error($conn);
        $messageClass = "bg-red-100 border-red-400 text-red-800";
    }
}

$sql = "SELECT * FROM user WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);

// $postSql = "SELECT * FROM post WHERE author_id='$id'";
// $postResult = mysqli_query($conn, $postSql);



ob_start(); // Start capturing output

if ($result) {
    $row = mysqli_fetch_assoc($result);
    ?>

	<style>
		.alert {
			margin-top: 1rem;
		}
	</style>
    <!-- Display success or error message using DaisyUI alert -->
    <?php if (isset($message)) { ?>
        <div id="alert" class="fixed w-5/12 top-20 flex items-center justify-between p-4 mb-3 <?php echo $messageClass; ?> mb-4"
             style="border-radius: 0.5rem;">
            <div class="flex items-center">
                <div class="mr-3">
                    <i class="far fa-check-circle"></i> <!-- Success icon -->
                </div>
                <div>
                    <?php echo $message; ?>
                </div>
            </div>
            <button onclick="hideAlert()" class="btn btn-ghost btn-sm ml-2">
                <i class="fas fa-times"></i> <!-- Close icon -->
            </button>
        </div>
    <?php } ?>
    <div class="container mx-auto p-10 bg-white shadow-md rounded-lg max-w-2xl mt-16">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">Profile</h2>
        <!-- Display user information -->
        <div class="space-y-3">
            <p><strong>User ID </strong> <?php echo $row['id']; ?></p>
            <p><strong>Nickname </strong> <?php echo $row['name']; ?></p>
            <p><strong>Email </strong> <?php echo $row['email']; ?></p>
            <!-- Include fields for other user information -->
        </div>
        <!-- Update Profile Button -->
        <button class="btn btn-sm bg-yellow-300 border-2 border-yellow-400 mt-6 hover:border-yelllow-400 hover:bg-yellow-500" onclick="openModal()">Edit</button>
    </div>
    <!-- Update Profile Modal (Hidden Initially) -->
    <div id="update-modal" class="fixed inset-0 overflow-y-auto hidden">
        <!-- Background overlay with a semi-transparent gray color -->
        <div class="fixed inset-0 bg-gray-900 opacity-20"></div>
        <div class="flex items-center justify-center mt-36 md:mt-24">
            <!-- Update Form -->
            <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
					<button onclick="closeModal()" class="btn fixed top-2 right-2 btn-ghost text-xl md:text-lg sm:text-base">
                           X
                        </button>
					<div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    		<h3 class="text-lg font-medium leading-6 text-gray-900 mb-6" id="modal-headline">
                                Update Profile
                            </h3>
                            <form action="user_info.php" method="post">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Name Field -->
                                    <div class="mb-4">
                                        <label for="name" class="block text-gray-700 text-sm font-bold mb-4">Name</label>
                                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    </div>
                                    <!-- Include fields for other user information -->
                                </div>
                                <button type="submit" class="btn btn-success mt-6 mb-6 btn-sm">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>
        // JavaScript functions to open and close the modal
        function openModal() {
            document.getElementById('update-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('update-modal').classList.add('hidden');
        }

        // Automatically hide the message after 2 seconds
        function hideAlert() {
            var alert = document.getElementById('alert');
            alert.style.opacity = '0';
            setTimeout(function () {
                alert.style.display = 'none';
            }, 500);
        }

        setTimeout(hideAlert, 2000); // 2 seconds delay before hiding
    </script>
    <?php
} else {
    echo "Error: " . mysqli_error($conn);
}


// $postSql = "SELECT * FROM post join user  WHERE user.id='$user_id' and post.author_id=user_id";
// $postResult = mysqli_query($conn, $postSql);
$postSql = "SELECT post.id as post_id, post.title, post.text, post.category_id, post.reg_date, user.id as user_id
            FROM post
            JOIN user ON post.author_id = user.user_id
            WHERE user.id='$user_id'";
$postResult = mysqli_query($conn, $postSql);

if (!$postResult) {
    echo "쿼리 실행 오류: " . mysqli_error($conn);
} else {
    if (mysqli_num_rows($postResult) > 0) {
        // 결과가 있는 경우의 코드
        echo '<div class="container mx-auto p-10 bg-white shadow-md rounded-lg max-w-2xl mt-16">';
        echo '<h2 class="text-3xl font-semibold text-gray-800 mb-4">Your Posts</h2>';
        while ($postRow = mysqli_fetch_assoc($postResult)) {
            // echo "<p><strong>Title:</strong> " . $postRow['title'] . "</p>";
            echo "<p><strong>Title:</strong> <a href='board_detail.php?id=" . $postRow['post_id'] . "'>" . $postRow['title'] . "</a></p>";
            // echo "<p><strong>Text:</strong> " . $postRow['text'] . "</p>";
            // echo "<p><strong>Category ID:</strong> " . $postRow['category_id'] . "</p>";
            // Add more fields as needed
            echo "<hr>";
        }
        echo '</div>';
    } else {
        // 결과가 없는 경우의 코드
        echo '<div class="container mx-auto p-10 bg-white shadow-md rounded-lg max-w-2xl mt-16">';
        echo "You haven't written any posts yet.";
        echo '</div>';
    }
}





// Display user's liked posts
$likeSql = "SELECT post.title,post.id
            FROM post_like
            JOIN post ON post_like.post_id = post.id
            WHERE post_like.user_id=$mno";
$likeResult = mysqli_query($conn, $likeSql);

if ($likeResult && mysqli_num_rows($likeResult) > 0) {
    echo '<div class="container mx-auto p-10 bg-white shadow-md rounded-lg max-w-2xl mt-16">';
    echo '<h2 class="text-3xl font-semibold text-gray-800 mb-4">Liked Posts</h2>';
    while ($likeRow = mysqli_fetch_assoc($likeResult)) {
        echo "<p><strong>Title:</strong> <a href='board_detail.php?id=" . $likeRow['id'] . "'>" . $likeRow['title'] . "</a></p>";
        // Add more fields as needed
        echo "<hr>";
    }
    echo '</div>';
} else {
    
    echo '<div class="container mx-auto p-10 bg-white shadow-md rounded-lg max-w-2xl mt-16">';
    echo($mno);
    echo "You haven't liked any posts yet.";
    echo '</div>';
}

$content = ob_get_clean(); // Store the output in $content
include("main.php");
mysqli_close($conn);
?>

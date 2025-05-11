<?php
	//board_list.php 페이지에서 넘어온 글 번호값 저장 및 출력
	$id = $_GET["id"];
	// echo $id."번째 글 삭제 페이지<br>";
?>
<!-- board_delete_action.php 페이지로 post방식을 이용하여 값 전송 -->
<h1 class="text-2xl font-semibold mb-4">Delete Post</h1>
<form action="/board_delete_action.php" method="post">
	<div class="mb-4">
		<label for="password" class="block text-gray-700 ml-1 mb-2">Enter Password</label>
		<input type="password" id="password" name="password" placeholder="(Same as when uploading the post)" class="w-full p-2 rounded-md border border-gray-300 focus:outline-none focus:border-yellow-500" required>
	</div>
	<input type="hidden" name="id" value="<?php echo $id ?>">
	<div class="mt-4 flex space-x-2 justify-end">
		<button type="submit" class="bg-yellow-500 text-white py-2 px-4 rounded-md hover:bg-yellow-600">Delete</button>
		<button id="closeModal" class="bg-gray-100 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-200">Cancel</button>
	</div>
	<?php
        if (isset($_GET["error"])) {
            $error = $_GET["error"];
            echo "<p class='text-red-500'>$error</p>";
        }
    ?>
</form>
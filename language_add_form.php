<?php
session_start();
ob_start();
?>
<!-- board_add_form.php -->
    <div class="container">
        <div class="max-w-xl mx-auto">
            <form action="/language_add_action.php" method="post" enctype="multipart/form-data" class="bg-white rounded px-4 pt-6 pb-8 mb-4">
                <!-- Password Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" type="password" placeholder="Password" pattern="\d+" title="비밀번호는 숫자로만 입력하세요" required/>
                </div>
                
                <!-- Title Input -->
                <div class="mb-4 text-2xl font-bold">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="Title">Title</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="Title" id="Title" placeholder="Title" required>
                </div>

                <!-- Content Textarea -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="content">Contents</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="content" id="content" rows="5" placeholder="Content" required></textarea>
                </div>

                <!-- Image Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Photo</label>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="image" id="image" accept="image/*" required>
                </div>

                <!-- Hidden Fields for User and Date -->
                <input type="hidden" name="boardUser" value="<?php echo $loggedInUserName; ?>">
                <input type="hidden" name="boardDate" value="<?php echo date('Y-m-d H:i:s'); ?>">

                <!-- Category Dropdown -->
				<div class="mb-6">
					<label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Category</label>
					<select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="category_id" name="category_id" required>
						<option value="1">Communication</option>
						<option value="2">Living</option>
						<option value="3">Language</option>
						<option value="4">Entertainment</option>
					</select>
				</div>

                <!-- Form Buttons -->
                <div class="flex items-center space-x-4 text-bold">
                    <button class="btn bg-yellow-400 hover:bg-orange-400" type="submit">Confirm</button>
                    <!-- <button class="btn btn-secondary" type="reset">Reset</button> -->
                    <!-- <a href="/board_list.php" class="btn btn-accent"></a> -->
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $("#password").change(function(){
            checkPassword($('#password').val());
        });

        $("#boardTitle").change(function(){
            checkTitle($('#boardTitle').val());
        });

        $("#content").change(function(){
            checkContent($('#content').val());
        });

        // boardUser 및 category_id에 대한 불필요한 체크 제거

        function checkPassword(password) { 
            if(password.length < 4 || !/^\d+$/.test(password)) { 
                alert("비밀번호는 4자 이상의 숫자로 입력하여야 합니다."); 
                $('#password').val('').focus();
                return false;
            } else { 
                return true;
            } 
        }

        function checkTitle(Title) {
            if(Title.length < 2) {
                alert('제목은 2자 이상 입력해야 합니다.');
                $('#Title').val('').focus();
                return false;
            } else { 
                return true;
            } 
        }

        function checkContent(content) {
            if(content.length < 2) {            
                alert('내용은 2자 이상 입력해야 합니다.');
                $('#content').val('').focus();
                return false;
            } else { 
                return true;
            } 
        }
        // 추가적인 JavaScript 코드가 필요하다면 여기에 추가
    </script>
<?php
$content = ob_get_clean();
include("main.php");
?>
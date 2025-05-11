<?php
session_start();
ob_start();
?>

    <div class="container">
        <div class="max-w-xl mx-auto">
            <form action="/services_add_action.php" method="post" enctype="multipart/form-data" class="bg-white rounded px-4 pt-6 pb-8 mb-4">
                <!-- Title Input -->
                <div class="mb-4 text-2xl font-bold">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="text">image</label>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="image" id="image" accept="image/*" required>
                </div>
                <div class="mb-4 text-2xl font-bold">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="text">text</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="text" id="text" placeholder="text" required>
                </div>

                <!-- Place Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="place">Place</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="place" id="place" placeholder="place" required>
                </div>

                <!-- Duration Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="duration">Duration</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="duration" id="duration" placeholder="Duration" required>
                </div>

                <!-- URL Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="url">URL</label>
                    <input type="url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="url" id="url" placeholder="URL" required>
                </div>

                <!-- Detail Image Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="detail">Detail</label>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="detail" id="detail" placeholder="detail" required>
                </div>

                <!-- Form Buttons -->
                <div class="flex items-center space-x-4 text-bold">
                    <button class="btn bg-yellow-400 hover:bg-orange-400" type="submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
    $("#url").change(function(){
        checkURL($('#url').val());
    });

    $("#duration").change(function(){
        checkDuration($('#duration').val());
    });

    function checkText(text) {
        if(text.length < 2) {
            alert('제목은 2자 이상 입력해야 합니다.');
            $('#text').val('').focus();
            return false;
        } else { 
            return true;
        } 
    }

    function checkURL(url) {
        // Regular expression for a valid URL format
        var urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;

        if(!urlRegex.test(url)) {
            alert('올바른 URL 형식이 아닙니다.');
            $('#url').val('').focus();
            return false;
        } else {
            return true;
        }
    }

    function checkDuration(duration) {
        // Check if the duration is a valid date
        if(isNaN(Date.parse(duration))) {
            alert('유효한 날짜 형식이 아닙니다.');
            $('#duration').val('').focus();
            return false;
        } else {
            return true;
        }
    }
    </script>

<?php
$content = ob_get_clean();
include("main.php");
?>
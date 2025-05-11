<?php
session_start();
ob_start(); // Start output buffering

$currentPage = 1;
if (isset($_GET["currentPage"])) {
    $currentPage = $_GET["currentPage"];
}

// mysqli_connect() 함수로 커넥션 객체 생성
$conn = mysqli_connect("localhost", "root", "1234", "kau");
mysqli_set_charset($conn, "utf8");
// 커넥션 객체 생성 확인

// 페이징 작업을 위한 테이블 내 전체 행 갯수 조회 쿼리
$sqlCount = "SELECT count(*) FROM event";
$resultCount = mysqli_query($conn, $sqlCount);
if ($rowCount = mysqli_fetch_array($resultCount)) {
    $totalRowNum = $rowCount["count(*)"];   // php는 지역 변수를 밖에서 사용 가능.
}

// 페이지당 표시할 항목 수와 전체 페이지 수 계산
$itemsPerPage = 12; // Adjust this as needed
$totalPages = ceil($totalRowNum / $itemsPerPage);

// 현재 페이지의 시작 레코드를 계산
$startIndex = ($currentPage - 1) * $itemsPerPage;

// Get search parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$place = isset($_GET['place']) ? mysqli_real_escape_string($conn, $_GET['place']) : '';
$locations = ['서울', '고양시', '시흥시', '구리시', '부천시', '인천', '화성시', '전라북도', '경상북도', '전라남도', '부산광역시', '광주광역시'];

// 이벤트 조회 쿼리
$sql = "SELECT event_id, image, text, place, duration 
        FROM event";

// Add WHERE clause for search parameters
if (!empty($search) || !empty($place)) {
    $sql .= " WHERE";

    if (!empty($place)) {
        $sql .= " text LIKE '%$place%'";
    }
}

// Add LIMIT clause for pagination
$sql .= " ORDER BY STR_TO_DATE(SUBSTRING(duration, POSITION('~' IN duration) + 1), '%Y.%m.%d') DESC LIMIT $startIndex, $itemsPerPage";

$result = mysqli_query($conn, $sql);
// 쿼리 조회 결과가 있는지 확인
?>

<div class="mb-2 p-4 py-6 select-ghost rounded-lg">
    <!-- Modified search form -->
    <form method="get" action="" class="flex items-center">
        <!-- Replace "Place" label with FontAwesome icon -->
        <label for="place" class="mr-2">
            <i class="fas fa-map-marker-alt"></i>
        </label>
        <select name="place" id="place" class="border p-2 rounded-md mr-2">
            <option value="">Choose your location</option>
            <?php foreach ($locations as $location): ?>
                <option value="<?= $location ?>" <?= ($location === $place) ? 'selected' : '' ?>><?= $location ?></option>
            <?php endforeach; ?>
        </select>
        <!-- Move the submit button next to the search combo box -->
        <button type="submit" class="bg-yellow-400 text-white py-2 px-4 rounded-md cursor-pointer">Search</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <?php
    // Loop through the results and display them as gallery items
    while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="p-4 border border-gray-300 rounded-md shadow-md transform hover:scale-105 transition-transform duration-300 hover:bg-green-100">
            <a href='/event_detail.php?event_id=<?= $row["event_id"] ?>'>
                <img src='<?= $row["image"] ?>' alt='Event Image' class="max-w-full h-auto mb-2">
                <h2 class="text-lg font-semibold" data-translate><?= $trimmedText = trim($row["text"], " \"") ?></h2>
                <p class="text-gray-500" data-translate><?= $trimmedPlace = trim($row["place"], " \"") ?></p>
                <p class="text-gray-500"><?= $row["duration"] ?></p>
            </a>
        </div>

        <?php
    }
    ?>
</div>

<div class="flex justify-center">
    <div class="join mt-24">
        <?php
        $window = 10; // Maximum number of page links to display
        $half = floor($window / 2);
        $start = max($currentPage - $half, 1);
        $end = min($start + $window - 1, $totalPages);

        // Display a "Previous" link if not on the first page
        if ($currentPage > 1) {
            echo "<a href='?currentPage=" . ($currentPage - 1) . "' class='join-item btn'>&laquo;</a>";
        }

        // Display page links within the window
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                echo "<button class='join-item btn bg-yellow-400'>$i</button>";
            } else {
                echo "<a href='?currentPage=$i' class='join-item btn'>$i</a>";
            }
        }

        // Display a "Next" link if not on the last page
        if ($currentPage < $totalPages) {
            echo "<a href='?currentPage=" . ($currentPage + 1) . "' class='join-item btn'>&raquo;</a>";
        }
        ?>
    </div>
</div>

<script>
    // Viewport 너비에 따라 표시할 페이지 링크 수 조절
    function adjustPagination() {
        var width = window.innerWidth || document.documentElement.clientWidth;
        var windowSize = width < 640 ? 5 : 10; // 640px 이하에서는 5개, 그 외는 10개 표시

        var currentPage = <?= $currentPage ?>;
        var totalPages = <?= $totalPages ?>;
        var halfWindow = Math.floor(windowSize / 2);
        var startPage = Math.max(currentPage - halfWindow, 1);
        var endPage = Math.min(startPage + windowSize - 1, totalPages);

        // 페이징 네비게이션 업데이트
        var paginationHTML = '';
        if (currentPage > 1) {
            paginationHTML += "<a href='?currentPage=" + (currentPage - 1) + "' class='join-item btn'>&laquo;</a>";
        }
        for (var i = startPage; i <= endPage; i++) {
            paginationHTML += "<a href='?currentPage=" + i + "' class='join-item btn" + (i === currentPage ? " bg-yellow-400" : "") + "'>" + i + "</a>";
        }
        if (currentPage < totalPages) {
            paginationHTML += "<a href='?currentPage=" + (currentPage + 1) + "' class='join-item btn'>&raquo;</a>";
        }
        document.querySelector('.join').innerHTML = paginationHTML;
    }

    // 창 크기 변경시 페이징 네비게이션 업데이트
    window.addEventListener('resize', adjustPagination);

    // 페이지 로드시 초기 페이징 네비게이션 설정
    adjustPagination();
</script>


<?php
$content = ob_get_clean(); // Store the output in $content
include("main.php");
?>

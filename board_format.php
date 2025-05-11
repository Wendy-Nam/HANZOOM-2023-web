<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function shortenText($text, $maxLength = 25, $ellipsis = '...') {
    if (strlen($text) > $maxLength) {
        $shortText = substr($text, 0, $maxLength) . $ellipsis;
    } else {
        $shortText = $text;
    }
    return $shortText;
}

function getTimeAgo($regDate) {
    $regDateTimestamp = strtotime($regDate);
    $currentTimestamp = time();
    $timeDifference = $currentTimestamp - $regDateTimestamp;

    $minute = 60;
    $hour = 3600;
    $day = 86400;
    $week = 604800;

    if ($timeDifference < $minute) {
        return "Just now";
    } elseif ($timeDifference < $hour) {
        $minutesAgo = floor($timeDifference / $minute);
        return $minutesAgo . " mins ago";
    } elseif ($timeDifference < $day) {
        $hoursAgo = floor($timeDifference / $hour);
        return $hoursAgo . " hours ago";
    } elseif ($timeDifference < $week) {
        $daysAgo = floor($timeDifference / $day);
        if ($daysAgo == 1) {
            return "1 day ago";
        } else {
            return $daysAgo . " days ago";
        }
    } else {
        return date("y/m/d", $regDateTimestamp);
    }
}

function displayHotList() {
    $conn = mysqli_connect("localhost", "root", "1234", "kau");
    mysqli_set_charset($conn, "utf8");

    // Updated SQL query to include category_id
    $sql = "SELECT p.id, p.title, p.text, p.reg_date, p.category_id, COUNT(pl.post_id) AS like_count, f.file_name
        FROM post p
        LEFT JOIN post_like pl ON p.id = pl.post_id
        LEFT JOIN file f ON p.id = f.post_id
        GROUP BY p.id, p.title, p.text, p.reg_date, p.category_id, f.file_name
        ORDER BY like_count DESC, p.id ASC LIMIT 5";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center mt-16 ml-2">
            <i class="fas fa-fire text-red-500 text-2xl mr-3"></i> 
            <span class="border-b-2 border-red-500 pb-2">Hot Post</span>
        </h2>';
        while ($row = mysqli_fetch_array($result)) {
            // Determine the category name based on category_id
            $categoryName = '';
            switch ($row["category_id"]) {
                case 1:
                    $categoryName = 'Communication';
                    break;
                case 3:
                    $categoryName = 'Language';
                    break;
                case 2:
                    $categoryName = 'Living';
                    break;
                case 4:
                    $categoryName = 'Entertainment';
                    break;
            }

            echo '<div class="bg-white py-2 px-8 border-b-2 border-gray-200">';
            echo '<a href="/board_detail.php?id=' . $row["id"] . '">';
            echo "<h2 class='text-xl font-semibold' data-translate mr-6>" . $row["title"] . "</h2>";
            echo '</a>';
            echo '<div class="flex justify-end md:justify-start mt-4 space-x-2">';
            // Display category name as a pill label
            if ($categoryName) {
                echo '<div class="badge badge-secondary badge-outline border-red-400"><span class="text-orange-400">' . $categoryName . '</span></div>';
            }
            if ($row["like_count"] > 0) {
                echo '<i class="fas fa-thumbs-up mr-1 text-orange-400"></i><span class="text-orange-400">' . $row["like_count"] . '</span>';
            }
            echo '<p class="text-gray-500 mb-2">' . getTimeAgo($row["reg_date"]) . '</p>';
            echo '</div>';
            
            // Add the image on the right
            echo '<div class="flex justify-end">';
            if ($row["file_name"]) {
                echo '<img class="rounded-lg ml-4" src="' . $row["file_name"] . '" alt="Image" width="100" height="100">';
            } else {
                echo '<img class="rounded-lg ml-4" src="./images/board_default.png" alt="Image" width="100" height="100">';
            }
            echo '</div>';
            
            echo '</div>';
        }
    } else {
        echo "No results: " . mysqli_error($conn);
    }
}

function displayBoardList($category_id, $category_name) {
    $conn = mysqli_connect("localhost", "root", "1234", "kau");
    mysqli_set_charset($conn, "utf8");

    $sql = "SELECT p.id, p.title, p.text, p.reg_date, p.category_id, f.file_name, COUNT(pl.post_id) AS like_count 
        FROM post p
        LEFT JOIN post_like pl ON p.id = pl.post_id
        LEFT JOIN file f ON p.id = f.post_id
        WHERE p.category_id = $category_id
        GROUP BY p.id, p.title, p.text, p.reg_date, p.category_id, f.file_name
        ORDER BY p.id ASC LIMIT 5";

    $result = mysqli_query($conn, $sql);

    if ($result) {
?>
    <h1 class="text-2xl font-bold -ml-8 lg:-ml-10 mb-2 text-orange-300 underline decoration-orange-400 underline-offset-8"><?php echo $category_name ?></h1>
    <div class="md:hidden my-4 -ms-8">
        <select class="select select-warning w-full max-w-xs" onchange="location = this.value;">
            <option disabled selected>Choose a board</option>
            <option value="board_list.php">Community</option>
            <option value="language.php">Language</option>
            <option value="living.php">Living</option>
            <option value="entertain.php">Entertainment</option>
        </select>
    </div>
	<div id='feed-container' class='-ms-8 lg:-ms-20 md:-ms-20 py-1 w-[80vw] lg:px-10 lg:w-[50vw] md:w-[55vw] sm:w-[100vw]'>
<?php
        while ($row = mysqli_fetch_array($result)) {
?>
            <div class='border-b-2 border-gray-200 flex justify-between items-center'>
                <div class='bg-white p-2'>
                    <a href='/board_detail.php?id=<?php echo $row["id"]; ?>'>
                        <h2 class='text-xl font-semibold' data-translate>
                            <?php echo $row["title"]; ?>
                        </h2>
                    </a>
                    <p class='text-gray-700 mt-1' data-translate><?php echo shortenText($row["text"]); ?></p>
                    <div class='flex justify-start mt-3 space-x-2'>
                        <p class='text-gray-500 mb-2'>
                            <?php if ($row["like_count"] > 0) { ?> 
                                <i class="fas fa-thumbs-up mr-1 text-orange-400"></i><span class="text-orange-400"><?php echo $row["like_count"]; ?></span>
                            <?php } ?>
                        </p>
                        <p class='text-gray-500 mb-1'><?php echo getTimeAgo($row["reg_date"]); ?></p>
                    </div>
                </div>
                   <?php if ($row["file_name"]) : ?>
    <!-- 이미지가 있는 경우 -->
    <img class="rounded-lg m-2 mobile-hidden" src='<?php echo $row["file_name"]; ?>' alt='' width='150rem' height='auto'>
<?php else : ?>
    <!-- 이미지가 없는 경우 또는 경로가 잘못된 경우 -->
    <img class="rounded-lg m-2 mobile-hidden" src='./images/board_default.png' alt='' width='150rem' height='auto'>
<?php endif; ?>

            </div>
            <style>
                @media only screen and (max-width: 650px) {
                    .mobile-hidden {
                        display: none;
                    }
                }
            </style>
<?php
        }
?>
    <!-- 로딩 스피너 -->
    <div id="spinner" class="hidden fixed top-1/2 left-1/2">
        <span class="loading loading-spinner loading-lg text-gray-500"></span>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let isLoading = false;
            let currentPage = 1;

            function showLoadingSpinner(show) {
                const spinner = document.getElementById('spinner');
                if (show) {
                    spinner.classList.remove('hidden');
                } else {
                    spinner.classList.add('hidden');
                }
            }

            window.addEventListener('scroll', () => {
                if (isLoading) return;
                let scrollPosition = window.scrollY + window.innerHeight;
                let documentHeight = document.documentElement.offsetHeight;

                if (scrollPosition >= documentHeight * 1.0) {
                    loadMore();
                }
            });

            function loadMore() {
                isLoading = true;
                showLoadingSpinner(true);
                currentPage++;

                fetch(`/load_more.php?page=${currentPage}&category_id=<?php echo $category_id; ?>`)
                    .then(response => response.text())
                    .then(data => {
                        console.log('Loading more content:', data);
                        document.getElementById('feed-container').insertAdjacentHTML('beforeend', data);
                        isLoading = false;
                        showLoadingSpinner(false);
                    })
                    .catch(error => {
                        console.error(error);
                        isLoading = false;
                        showLoadingSpinner(false);
                    });
            }
        });
    </script>

<?php
    } else {
        echo "No results: " . mysqli_error($conn);
    }
}
?>

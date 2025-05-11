
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('board_format.php');
session_start();

ob_start(); // Start output buffering
?>
<div class="font-sans antialiased bg-gray-100">
    <!-- Greeting Section with Animation -->
	<!-- <div class="p-6 text-center bg-gradient-to-r from-yellow-300 via-yellow-400 to-yellow-500">
		<h1 class="text-sm font-bold" id="greetingText">
			//<?php if (isset($_SESSION['id']) && isset($_SESSION['name'])): ?>
			//	Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>
			//<?php else: ?>
			//	Hello, Guest.
			//<?php endif; ?>
		</h1>
	</div> -->

    <!-- Hero Section with Feature Highlights, Background Image, and Dark Overlay -->
    <div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1535189043414-47a3c49a0bed');" x-data="{ activeFeature: 1, featureInterval: null }" x-init="featureInterval = setInterval(() => { activeFeature = activeFeature < 3 ? activeFeature + 1 : 1; }, 2000);">
        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <div class="container mx-auto relative z-10">
			<div class="relative bg-yellow-400 mt-50 p-8 greeting-section">
    <h2 class="text-3xl font-extrabold mb-2 text-gray-800 tracking-wide z-10 relative">WELCOME TO HANZ8M KOREA</h2>
    <p class="text-sm mb-2 text-black z-10 relative">Explore South Korea like never before. Connect, share, and enjoy our vibrant expat community.</p>
</div>

            
            <!-- Feature Blocks -->
    <div class="px-6 grid grid-cols-1 md:grid-cols-3 gap-4 py-4">
        <!-- Feature 1 -->
        <div :class="{'text-white opacity-100': activeFeature === 1, 'text-white opacity-50': activeFeature !== 1, 'block': activeFeature === 1 || screen.width > 768, 'hidden': activeFeature !== 1 && screen.width <= 768}" class="p-4 text-center transition-opacity duration-400 ease-in-out">
            <i class="fas fa-globe fa-2x mb-2"></i>
            <h4 class="font-bold text-md">Create & Explore</h4>
            <p class="text-xs">Be a Content Creator and Explorer! Share Your Experiences, Discover Hidden Gems.</p>
        </div>
        
        <!-- Feature 2 -->
        <div :class="{'text-white opacity-100': activeFeature === 2, 'text-white opacity-50': activeFeature !== 2, 'block': activeFeature === 2 || screen.width > 768, 'hidden': activeFeature !== 2 && screen.width <= 768}" class="p-4 text-center transition-opacity duration-400 ease-in-out">
            <i class="fas fa-users fa-2x mb-2"></i>
            <h4 class="font-bold text-md">Expat Hub</h4>
            <p class="text-xs">A Community for Expats, by Expats! Connect, Communicate, and Create Together.</p>
        </div>
        
        <!-- Feature 3 -->
        <div :class="{'text-white opacity-100': activeFeature === 3, 'text-white opacity-50': activeFeature !== 3, 'block': activeFeature === 3 || screen.width > 768, 'hidden': activeFeature !== 3 && screen.width <= 768}" class="p-4 text-center transition-opacity duration-400 ease-in-out">
            <i class="fas fa-hands-helping fa-2x mb-2"></i>
            <h4 class="font-bold text-md">Services Hub</h4>
            <p class="text-xs">All Your Needs in One Place! Uncover Elusive Services for Expats in Korea.
			</p>
        </div>
    </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<?php
displayHotList();
// // Assuming getCategoryName is a valid function in your codebase
// function getCategoryName($category_id) {
//     // Implementation of getCategoryName
//     // Replace this with your actual logic to get the category name
//     // Example: return "Category " . $category_id;
// }

// // Loop through categories
// for ($category_id = 1; $category_id <= 4; $category_id++) {
//     $category_name = getCategoryName($category_id);

//     // Call displayBoardList function for each category
//     displayBoardList($category_id, $category_name);
// }

// Get the captured content and store it in the $content variable
$content = ob_get_clean();

// Include the main.php file
include('main.php');
?>

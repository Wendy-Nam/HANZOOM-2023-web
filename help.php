<?php
// Start output buffering
session_start();
ob_start();
?>

<style>
    /* Keyframes for the background animation */
    @keyframes moveBackground {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 100% 0;
        }
    }

    /* Style for the container with the moving background */
    .moving-background {
        background-image: linear-gradient(90deg, #FFD700 50%, #FFC800 50%);
        background-size: 200% 100%;
        animation: moveBackground 10s linear infinite;
    }
</style>

<div class="moving-background font-sans p-8 mx-auto max-w-2xl">
    <!-- Start of Professional Content -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-semibold mb-4 text-gray-800">Welcome to Our Expert Community! <i class="fas fa-globe"></i></h1>
        <p class="text-gray-700 mb-4">
            We've created this platform to address the challenges faced by our foreign friends in Korea. From fragmented event information to language barriers and the lack of a unified platform, we're here to provide a one-stop solution through our integrated community website.
        </p>
        <p class="text-gray-700 mb-4">
            <strong>Benefits and Assistance</strong>
        </p>
        <ul class="list-disc list-inside mb-4">
            <li class="text-gray-700">Access to local event information</li>
            <li class="text-gray-700">Improved communication with community members</li>
            <li class="text-gray-700">Filtered service announcements tailored to your needs</li>
            <li class="text-gray-700">Help in finding housing, entertainment, visa and legal guidance, and job opportunities</li>
        </ul>
        <p class="text-gray-700 mb-4">
            <strong>Contact for Inquiries:</strong> hanzoom2000@gmail.com
        </p>
    </div>
    <!-- End of Professional Content -->
</div>

<?php
// Get the buffered output and store it in $content
$content = ob_get_clean();
// Output the content wherever needed
include('main.php');
// echo $content;
?>

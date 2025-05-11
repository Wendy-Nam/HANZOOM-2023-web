<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .custom-button:hover {
            background-color: #f59e0b; /* Slightly darker yellow for hover effect */
        }
        .icon {
            position: absolute;
            left: 15px; /* Slightly increased space from the left edge */
            top: 50%;
            transform: translateY(-50%);
            color: gray;
        }

        .input-field {
            position: relative;
        }

        .input-field input {
            padding-left: 45px; /* Increased padding to create more space for the icon */
        }

        .error-message {
            min-height: 24px; /* Reserve space for error message */
        }
    </style>
</head>
<body class="bg-yellow-400">
    <!-- Wave SVG -->
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-full absolute bottom-0 h-3/6 opacity-80" id="wavepattern2">
        <path id="wave2" d=""/>
    </svg>
	<div class="p-3">
		<div class="flex justify-center items-center min-h-screen bg-yellow-400">
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-600 max-w-md w-full z-20">
            <form action="signup-check.php" method="post" id="signupForm">
                <h2 class="text-3xl font-semibold mb-2 mt-2 text-yellow-500 text-center">SIGN UP</h2>
                <p id="formError" class="text-red-500 text-center mb-4 error-message <?php echo isset($_GET['success']) ? 'text-green-500' : 'text-red-500'; ?>">
                    <?php
                    if (isset($_GET['error'])) {
                        echo $_GET['error'];
                    } elseif (isset($_GET['success'])) {
                        echo $_GET['success'];
                        echo '<script>
                        setTimeout(function(){
                            window.location.href = "login.php"; // Replace "login.php" with your actual login page URL
                        }, 2000); // 2000 milliseconds (2 seconds)
                        </script>';
                    }
                    ?>
                </p>
                <div class="mb-4 input-field">
                    <i class="fas fa-id-badge icon"></i>
                    <input type="text" name="id" id="id" placeholder="User ID" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                </div>
                <div class="mb-4 input-field">
                    <i class="fas fa-user icon"></i> <!-- Icon for ID -->
                    <input type="text" name="name" id="name" placeholder="Nickname" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                </div>
                <div class="mb-4 input-field">
                    <i class="fas fa-envelope icon"></i>
                    <input type="email" name="email" id="email" placeholder="Email Address" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                </div>
                <div class="mb-4 input-field">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                </div>
                <div class="mb-6 input-field">
                    <i class="fas fa-lock icon"></i>
                    <input type="password" name="repassword" id="repassword" placeholder="Confirm Password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                </div>
                <button type="submit" class="w-full bg-yellow-400 text-white py-3 rounded-lg hover:bg-yellow-500 transition duration-300 custom-button">Sign Up</button>
                <a href="index.php" class="block mt-5 text-center text-yellow-500 hover:underline">Already have an account?</a>
            </form>
        </div>
    </div>
	</div>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            var id = document.getElementById('id').value;
            var username = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('repassword').value;
            var errorElement = document.getElementById('formError');

            errorElement.textContent = ''; // Clear previous errors

            if (!id.trim()) {
                errorElement.textContent = 'Please enter an ID.'; // Validation message for ID
                event.preventDefault();
            } else if (!username.trim()) {
                errorElement.textContent = 'Please enter a nickname.';
                event.preventDefault();
            } else if (!email.trim() || !validateEmail(email)) {
                errorElement.textContent = 'Please enter a valid email address.';
                event.preventDefault();
            } else if (password.length < 8) {
                errorElement.textContent = 'Password must be at least 8 characters long.';
                event.preventDefault();
            } else if (password !== confirmPassword) {
                errorElement.textContent = 'Passwords do not match.';
                event.preventDefault();
            }

            // Email validation function
            function validateEmail(email) {
                var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
    <!-- Include any other JavaScript libraries you need -->

    <!-- JavaScript for the wave animation -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/jquery.wavify.js"></script>

    <script>
        $('#wave2').wavify({
            height: 80,
            bones: 3,
            amplitude: 180,
            color: '#fcd34d',
            speed: 0.5
        });
    </script>
</body>
</html>

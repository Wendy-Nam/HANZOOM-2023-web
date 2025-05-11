<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Animations */
        @keyframes bounce {
            0%, 100% { transform: scale(1.3) translateY(0); }
            50% { transform: scale(1.4) translateY(-20px); }
        }
        .bounce { 
            animation: bounce 2s ease infinite; 
            display: inline-block;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
		.fade-in { animation: fadeIn 0.25s ease-in; }
        .fade-out { animation: fadeOut 0.5s ease-out; }
		.eye-icon {
			position: absolute;
			right: 5px;
			top: 20%;
			transform: translateY(-50%);
			cursor: pointer;
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
	<script src="https://cdn.jsdelivr.net/gh/mzebley/dynamowaves/dist/dynamowaves.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-yellow-400">
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-full absolute bottom-0 h-3/6 opacity-80 hidden" id="wavepattern1"><path id="wave" d=""/></svg>
	<div class="p-3 z-20">
		<!-- Intro Section -->
    <div id="intro" class="flex flex-col justify-center items-center h-screen hidden z-10">
        <div class="bounce"> <!-- SVG Logo -->
        <svg width="164" height="159" viewBox="0 0 164 159" fill="none" xmlns="http://www.w3.org/2000/svg"> 
				<path d="M59.5558 117.116C59.5558 117.118 59.5539 117.12 59.5516 117.12C33.6124 117.093 10.3767 100.097 3.24124 75.9182C-4.33117 50.2566 5.23088 24.0123 27.3772 9.69573C64.2067 -14.1097 113.528 8.53876 118.54 51.6966C119.959 63.9406 117.994 75.8017 111.648 86.5807C110.128 89.161 110.791 90.3929 112.588 92.1658C128.161 107.506 143.641 122.93 159.198 138.287C162.791 141.833 164.209 146.003 162.757 150.781C161.389 155.284 157.955 157.872 153.355 158.713C148.586 159.587 145.052 157.198 141.87 154.035C126.851 139.128 111.773 124.287 96.8469 109.287C94.681 107.107 93.2706 106.849 90.5758 108.53C81.1408 114.406 70.7994 117.427 59.56 117.112C59.5577 117.112 59.5558 117.114 59.5558 117.116ZM59.497 100.415C82.8439 100.439 101.901 81.8196 101.951 58.9298C101.993 35.7735 83.2636 17.0205 60.0427 16.9789C36.444 16.9373 17.5381 35.5405 17.5214 58.8215C17.5046 81.4284 36.6371 100.39 59.497 100.415Z" fill="white"/>
<path d="M59.0609 91.2507C59.0609 91.2484 59.0628 91.2466 59.0651 91.2466C74.5691 91.2115 86.7458 83.2442 90.9796 70.9492C93.0676 64.881 91.4538 58.132 86.8702 54.0389C82.1286 49.8029 76.7464 48.9288 71.0731 51.652C66.0902 54.0473 63.2452 58.5606 60.7746 63.3597C56.5404 71.5795 49.8272 75.7483 40.6185 75.5129C38.1478 75.4457 35.6938 74.933 33.2232 74.7061C32.5743 74.6472 31.6011 74.6304 31.2933 75.0171C30.5862 75.908 31.6343 76.4122 32.1002 77.0594C39.0453 86.4882 48.4438 90.9596 59.0567 91.2548C59.059 91.2549 59.0609 91.253 59.0609 91.2507ZM87.9183 42.5328C87.914 42.5328 87.9107 42.5288 87.9113 42.5245C88.0982 41.3116 87.4097 40.758 86.9118 40.1123C77.8112 28.5054 65.824 24.7485 51.8071 27.5304C40.4604 29.7829 32.1251 36.2125 28.2403 47.5505C25.595 55.2744 28.5814 63.1244 35.1531 66.7216C41.5751 70.2432 48.5961 68.495 53.9699 62.141C56.0745 59.6532 57.314 56.7032 58.7365 53.8372C62.1971 46.8529 67.6042 42.743 75.3821 41.5243C79.7078 40.8519 83.759 42.1294 87.9183 42.5328Z" fill="#FAF8F7"/>
<path d="M59.5774 59.2762C59.5774 59.2762 59.5774 59.2763 59.5773 59.2762C59.4819 59.2736 59.3973 59.2334 59.3348 59.1489C59.3306 59.1431 59.3212 59.1385 59.3276 59.1306C59.3304 59.1271 59.3391 59.1272 59.345 59.1278C59.3672 59.1298 59.3893 59.1344 59.4115 59.135C59.4944 59.1372 59.5548 59.0998 59.5928 59.026C59.615 58.983 59.6406 58.9424 59.6854 58.9209C59.7365 58.8964 59.7849 58.9043 59.8275 58.9423C59.8688 58.9791 59.8834 59.0396 59.8645 59.0941C59.8264 59.2044 59.7168 59.2759 59.5774 59.2762C59.5774 59.2762 59.5774 59.2762 59.5774 59.2762Z" fill="white"/>
<path d="M59.8346 58.8144C59.7971 58.8108 59.7606 58.7993 59.7215 58.8053C59.6513 58.8163 59.6025 58.8532 59.5713 58.916C59.5585 58.9418 59.5473 58.9683 59.5283 58.9907C59.4799 59.0478 59.4165 59.0634 59.3586 59.0318C59.2993 58.9994 59.2724 58.9289 59.2963 58.8595C59.3313 58.7576 59.4064 58.6998 59.5088 58.6796C59.6353 58.6546 59.7435 58.6883 59.8255 58.7927C59.83 58.7985 59.8363 58.8034 59.8345 58.8143C59.8345 58.8144 59.8345 58.8144 59.8346 58.8144Z" fill="white"/> </svg>
			</div>
			<p id="serviceName" class="text-6xl text-white font-extrabold mb-5 mt-14">
				HANZ8M
			</p>
			<p id="slogan" class="lg:text-2xl text-lg text-white font-light text-center px-16">
			</p>
    </div>

    <!-- Login Form -->
	<div id="loginForm" class="form-box flex justify-center items-center min-h-screen bg-yellow-400 z-10">
		<div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-600 max-w-md w-full z-10">
			<form action="login.php" method="post">
            <h2 class="text-5xl font-semibold text-yellow-500 text-center mb-20 mt-6">LOGIN</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="text-red-500 mb-4"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <div class="mb-6 input-field">
                <i class="fas fa-user icon"></i>
                <input type="text" name="id" id="id" placeholder="Id" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
            </div>

            <div class="mb-12 input-field relative">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-yellow-400 focus:ring focus:ring-yellow-400">
                <span id="togglePassword" class="eye-icon absolute inset-y-0 right-0 pr-5 pt-8 flex items-center cursor-pointer">
                    <img id="eyeOpen" src="./svg/eye_filled.svg" class="h-6 w-6 text-gray-700"/>
                    <img id="eyeClosed" src="./svg/eye_outline.svg" class="h-6 w-6 text-gray-700 hidden"/>
                </span>
            </div>
            <button type="submit" class="w-full bg-yellow-400 text-white py-3 rounded-lg hover:bg-yellow-500 transition duration-300">Sign In</button>
			<a href="signup.php" class="w-full block text-center bg-white py-3 rounded-lg border-2 border-yellow-300 hover:bg-yellow-100 transition duration-300 text-yellow-500 hover:underline mt-5">
				Sign Up
			</a>
			<!-- Guest Mode Button -->
            <!-- <button onclick="location.href='home.php'" type="button" class="w-full border-2 border-yellow-300 bg-yellow-200 text-black py-3 rounded-lg hover:bg-yellow-300 transition duration-300 mt-5">
                <span class="text-yellow-600 text-semibold">Guest Mode</span>
            </button> -->
			<a href="home.php" class="w-full block text-center py-3 transition duration-300 text-yellow-500 hover:underline mt-5 mb-2">
				Guest Mode
			</a>

        </form>
		</div>
	</div>
	</div>
	<script>
    document.addEventListener("DOMContentLoaded", function() {
        const slogan = document.getElementById('slogan');
        const intro = document.getElementById('intro');
        const loginForm = document.getElementById('loginForm');
        let sloganText = "A NEW WAY TO EXPLORE SOUTH KOREA";
        let index = 0;
		
        function typeSlogan() {
            if (index < sloganText.length) {
                slogan.innerHTML += sloganText[index++];
                setTimeout(typeSlogan, 50);
            } else {
                setTimeout(() => {
                    intro.classList.add('fade-out');
                    setTimeout(() => {
                        intro.style.display = 'none';
						document.getElementById('wavepattern1').classList.remove('hidden');
                        loginForm.style.display = 'flex';
                        loginForm.classList.add('fade-in');
                    }, 400);
                }, 500);
            }
        }

        // Check if the splash was already shown
        if (localStorage.getItem('splashShown') !== 'true') {
			intro.classList.remove('hidden');
            typeSlogan();
            localStorage.setItem('splashShown', 'true');
        } else {
			intro.classList.add('hidden');
			document.getElementById('wavepattern1').classList.remove('hidden');
            loginForm.style.display = 'flex';
        }

        // Password visibility toggle logic
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    });
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.0.1/TweenMax.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/85188/jquery.wavify.js"></script>

<script>
  $('#wave').wavify({
    height: 80,
    bones: 3,
    amplitude: 150,
    color: '#fcd34d',
    speed: 0.4
  });
</script>
</body>
</html>

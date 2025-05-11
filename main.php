<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HANZ8M KOREA</title>
    <link href="./css/main.css" rel="stylesheet" />
  	<link href="./css/snowfall.css" rel="stylesheet" />
  <link
      href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.min.css"
      rel="stylesheet"6
      type="text/css"
    />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
	/>
      
      <style>
      .hidden {
        display: none;
      }
    
      #searchInput {
    background-color: rgba(255, 255, 255, 0.8); /* 투명도 조절 */
          left: -400px;
          
  }

  #searchInput input {
    border: 1px solid #ccc;
    padding: 8px;
    width: 200px;
    transition: width 0.3s ease-in-out; /* 입력창 너비 변화에 따른 부드러운 애니메이션 추가 */
  }

  #searchInput input:focus {
    width: 250px;
  }

  #executeSearch {
    background-color: #f39c12; /* 배경색 변경 */
    color: #fff; /* 텍스트 색상 변경 */
  }
    </style>
  <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white">
  <div id="snow"></div>
  <!-- Top menu bar -->
  <div class="navbar bg-base-100 fixed top-0 z-20 bg-yellow-400 px-5 p-1">
    <div class="flex-1">
      <a class="btn btn-ghost text-xl font-black" href="home.php">HANZ8M KOREA</a>
    </div>
    <div class="flex-none space-x-3 relative">
		<?php
		// Check if the user is logged in (You will need PHP session handling)
		// $isLoggedIn = true; // Replace with your actual logic
		if (isset($_SESSION['id'])) {
		} else{
			 echo '<div class="badge py-3 bg-red-500 border-2 border-orange-300 text-white font-semibold text-sm">GUEST MODE</div>';
		}
		?>
      <button id="searchButton" class="btn btn-ghost btn-circle mb-1">
        <svg height="25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
      </button>
        
    <div id="searchInput" class="hidden absolute top-0 left-0 mt-6 p-2 bg-white rounded shadow">
        <input type="text" placeholder="Search..." class="border p-1 w-32 focus:outline-none focus:border-blue-500">
        <button id="executeSearch" class="bg-yellow-400 text-white p-1 ml-2">Search</button>
    </div>

		<div class="dropdown dropdown-end lg:block xl:block 2xl:block md:block">
  <label tabindex="0" class="btn btn-circle btn-ghost avatar w-10 h-auto">
	  <img id="selectedFlag" src="./svg/country/default.svg" class="mr-2" />
  </label>
  <ul tabindex="0" class=" language-menu menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-slate-100 rounded-box w-20">
    <li>
      <a class="justify-between" href="?lang=en" value="en" id="lang_en">
        <img src="./svg/country/us.svg" class="w-5 h-3 mr-2" alt="English"> EN
      </a>
    </li>
    <li>
      <a class="justify-between" href="?lang=zh-CN" value="zh" id="lang_cn">
        <img src="./svg/country/cn.svg" class="w-5 h-3 mr-2" alt="Chinese"> CN
      </a>
    </li>
    <li>
      <a class="justify-between" href="?lang=ja" value="ja" id="lang_jp">
        <img src="./svg/country/jp.svg" class="w-5 h-3 mr-2" alt="Japanese"> JP
      </a>
    </li>
    <li>
      <a class="justify-between" href="?lang=ko" value="ko" id="lang_kr">
        <img src="./svg/country/kr.svg" class="w-5 h-3 mr-2" alt="Korean"> KR
      </a>
    </li>
	 <li>
      <a class="justify-between" href="" value="default" id="lang_default">
        Default
      </a>
    </li>
    <!-- Add more languages as needed -->
  </ul>
</div>
	</div>
      <div class="dropdown dropdown-end lg:block xl:block 2xl:block md:block hidden ml-2">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full bg-white border-2 border-orange-300">
            <img alt="kau-logo" src="https://www.kau.ac.kr/cmm_typeA/images/sub/new_emblem.png" />
          </div>
        </label>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-slate-100 rounded-box w-52 shadow-lg">
         <li>
            <a href="help.php" class="justify-between">
              Help
            </a>
          </li> 
		<?php
		// Check if the user is logged in (You will need PHP session handling)
		// $isLoggedIn = true; // Replace with your actual logic
		if (isset($_SESSION['id'])) {
		  echo '<li>
            <a class="justify-between" href="user_info.php">
              Profile
              <span class="badge">New</span>
            </a>
          </li>';
		  echo '<li id="logoutBtn"><a href="logout.php">Logout</a></li>';
		} else {
		  echo '<li><a href="index.php">Login</a></li>';
		}
		?>
        </ul>
      </div>
  </div>
  <!-- Action Button (write) -->
  <a href="board_add_form.php" id="write_action_button" class="z-90 hidden">
    <button
       class="fixed p-8 z-90 bottom-36 sm:bottom-15 md:bottom-12 right-12 border border-white border-4 bg-amber-500 w-12 h-12 rounded-full drop-shadow-lg flex justify-center items-center text-white text-4xl hover:bg-orange-500 hover:drop-shadow-xl hover:animate-bounce duration-300"
    ><i class="fa fa-sm fa-pencil z-90" aria-hidden="true"></i>
    </button>
  </a>
	  <a href="askgpt.php" id="gpt_action_button" class="z-90 hidden">
    <button
       class="fixed p-8 z-90 bottom-36 sm:bottom-15 md:bottom-12 right-12 border border-white border-4 bg-emerald-400 w-12 h-12 rounded-full drop-shadow-lg flex justify-center items-center text-white text-4xl hover:bg-emerald-500 hover:drop-shadow-xl hover:animate-bounce duration-300"
    ><i class="fa-solid fa-headset" fill="white"></i>
    </button>
  </a>
  <div class="flex flex-col md:flex-row">
	  <!-- Sidebar for large viewport -->
    <!-- <div class="hidden md:flex h-screen p-4 bg-white"> -->
    <nav class="nav hidden md:flex" data-expanded="true">
      <div class="nav__main fixed left-0 inset-y-0 col-0 shadow-lg mt-12 h-screen">
        <ul class="nav__items__home">
          <li class="nav__item">
            <a class="nav__item-box" href="home.php" title="home" id="home-link">
              <span class="nav__item-icon">
                <svg width="24px" height="24px" aria-hidden="true">
                  <use xlink:href="#home" />
                </svg>
              </span>
              <span class="nav__item-text">Home</span>
            </a>
          </li>
          </ul>
          <span class="nav__heading">
            <span class="nav__heading-text">Information</span>
          </span>
          <ul class="nav__items">
            <li class="nav__item">
              <a class="nav__item-box" title="events" id="events-link" href="events.php">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#events" />
                  </svg>
                </span>
                <span class="nav__item-text">Events</span>
              </a>
            </li>
            <li class="nav__item">
              <a class="nav__item-box" href="services.php" title="services" id="services-link">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#services" />
                  </svg>
                </span>
                <span class="nav__item-text">Services</span>
              </a>
            </li>
          </ul>
          <span class="nav__heading">
            <span class="nav__heading-text">Community</span>
          </span>
          <ul class="nav__items">
            <li class="nav__item">
              <a class="nav__item-box"  title="community_all" id="community-all-link" href="board_list.php">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#community_all" />
                  </svg>
                </span>
                <span class="nav__item-text">Dashboard</span>
              </a>
            </li>
              
            <li class="nav__item">
              <a class="nav__item-box" href="language.php" title="community_lang" id="community-lang-link">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#community_lang" />
                  </svg>
                </span>
                <span class="nav__item-text">Language</span>
              </a>
            </li>
            <li class="nav__item">
              <a class="nav__item-box" href="living.php" title="community_living" id="community-living-link">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#community_living" />
                  </svg>
                </span>
                <span class="nav__item-text">Living</span>
              </a>
            </li>
            <li class="nav__item">
              <a class="nav__item-box" href="entertain.php" title="community_entertain" id="community-entertain-link">
                <span class="nav__item-icon">
                  <svg width="24px" height="24px" aria-hidden="true">
                    <use xlink:href="#community_entertain" />
                  </svg>
                </span>
                <span class="nav__item-text">Entertain</span>
              </a>
            </li>
          </ul>
      <div class="">
        <ul class="nav__items">
          <li class="nav__item">
            <button
              class="nav__item-box"
              type="button"
              aria-expanded="true"
              id="expand-button"
              data-expand
            >
              <span class="nav__item-icon">
                <svg width="24px" height="24px" aria-hidden="true">
                  <use xlink:href="#arrow" />
                </svg>
              </span>
              <span class="nav__item-text" data-expand-label>Collapse</span>
            </button>
          </li>
        </ul>
		  </div>
	  </div>
	</nav>
  <!-- Content Pane -->
    <div id="contentPane" class="mt-28 mb-16 px-12 m-5 md:ml-32 md:mb-22 mb-32">
        <!-- Your page content goes here -->
		<?php echo isset($content) ? $content : ''; ?>	
	</div>
 </div>
  <!-- Bottom navbar for mobile viewport -->
  <div class="md:hidden fixed inset-x-0 bottom-0 bg-white py-4 px-2 border-t-2 border-gray-100">
    <nav class="flex px-2 justify-center space-x-2">
          <a class="nav__item-box-mobile" href="events.php" title="events" id="events-mobile-link">
              <svg width="30px" height="30px">
                <use xlink:href="#events" />
              </svg>
          </a>
          <a class="nav__item-box-mobile" href="services.php" title="services" id="services-mobile-link">
            <svg width="30px" height="30px">
              <use xlink:href="#services" />
            </svg>
        </a>
        <a class="nav__item-box-mobile" href="home.php" title="home" id="home-mobile-link">
          <svg width="30px" height="30px">
            <use xlink:href="#home" />
          </svg>
      </a>
        <a class="nav__item-box-mobile" href="board_list.php" title="community_all" id="community-all-mobile-link">
          <svg width="30px" height="30px">
              <use xlink:href="#community_all" />
            </svg>
        </a> 
        <a class="nav__item-box-mobile" href="user_info.php" title="profile" id="profile-mobile-link">
          <svg width="30px" height="30px">
              <use xlink:href="#profile" />
            </svg>
        </a> 
    </nav>
  </div>
	 
    <svg display="none" class="hidden">
      <symbol id="home" viewBox="0 0 576 512">
        <g fill="currentColor">
          <path
            d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"
          />
          <polygon
            points="14.999 10.343 9.343 13.172 12.171 16 14.999 10.343"
          />
        </g>
      </symbol>
      <symbol id="events" viewBox="0 0 448 512">
        <g fill="currentColor">
          <path
            d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"
          />
        </g>
      </symbol>
      <symbol id="community_all" viewBox="0 0 640 512">
        <g fill="currentColor">
          <path
            d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM609.3 512H471.4c5.4-9.4 8.6-20.3 8.6-32v-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2h61.4C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"
          />
        </g>
      </symbol>
      <symbol id="community_lang" viewBox="0 0 640 512">
        <g fill="currentColor">
        <path
          d="M0 128C0 92.7 28.7 64 64 64H256h48 16H576c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H320 304 256 64c-35.3 0-64-28.7-64-64V128zm320 0V384H576V128H320zM178.3 175.9c-3.2-7.2-10.4-11.9-18.3-11.9s-15.1 4.7-18.3 11.9l-64 144c-4.5 10.1 .1 21.9 10.2 26.4s21.9-.1 26.4-10.2l8.9-20.1h73.6l8.9 20.1c4.5 10.1 16.3 14.6 26.4 10.2s14.6-16.3 10.2-26.4l-64-144zM160 233.2L179 276H141l19-42.8zM448 164c11 0 20 9 20 20v4h44 16c11 0 20 9 20 20s-9 20-20 20h-2l-1.6 4.5c-8.9 24.4-22.4 46.6-39.6 65.4c.9 .6 1.8 1.1 2.7 1.6l18.9 11.3c9.5 5.7 12.5 18 6.9 27.4s-18 12.5-27.4 6.9l-18.9-11.3c-4.5-2.7-8.8-5.5-13.1-8.5c-10.6 7.5-21.9 14-34 19.4l-3.6 1.6c-10.1 4.5-21.9-.1-26.4-10.2s.1-21.9 10.2-26.4l3.6-1.6c6.4-2.9 12.6-6.1 18.5-9.8l-12.2-12.2c-7.8-7.8-7.8-20.5 0-28.3s20.5-7.8 28.3 0l14.6 14.6 .5 .5c12.4-13.1 22.5-28.3 29.8-45H448 376c-11 0-20-9-20-20s9-20 20-20h52v-4c0-11 9-20 20-20z"
        />
    	</g>  
	</symbol>
      <symbol id="community_living" viewBox="0 0 512 512">
        <g fill="currentColor">
          <path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm306.7 69.1L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
    	</g>  
	</symbol>
      <symbol id="community_entertain" viewBox="0 0 512 512">
        <g fill="currentColor">
          <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/>
		  </g>
      </symbol>
      <symbol id="community_commu" viewBox="0 0 640 512">
        <g fill="currentColor">
        <path d="M88.2 309.1c9.8-18.3 6.8-40.8-7.5-55.8C59.4 230.9 48 204 48 176c0-63.5 63.8-128 160-128s160 64.5 160 128s-63.8 128-160 128c-13.1 0-25.8-1.3-37.8-3.6c-10.4-2-21.2-.6-30.7 4.2c-4.1 2.1-8.3 4.1-12.6 6c-16 7.2-32.9 13.5-49.9 18c2.8-4.6 5.4-9.1 7.9-13.6c1.1-1.9 2.2-3.9 3.2-5.9zM0 176c0 41.8 17.2 80.1 45.9 110.3c-.9 1.7-1.9 3.5-2.8 5.1c-10.3 18.4-22.3 36.5-36.6 52.1c-6.6 7-8.3 17.2-4.6 25.9C5.8 378.3 14.4 384 24 384c43 0 86.5-13.3 122.7-29.7c4.8-2.2 9.6-4.5 14.2-6.8c15.1 3 30.9 4.5 47.1 4.5c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176zM432 480c16.2 0 31.9-1.6 47.1-4.5c4.6 2.3 9.4 4.6 14.2 6.8C529.5 498.7 573 512 616 512c9.6 0 18.2-5.7 22-14.5c3.8-8.8 2-19-4.6-25.9c-14.2-15.6-26.2-33.7-36.6-52.1c-.9-1.7-1.9-3.4-2.8-5.1C622.8 384.1 640 345.8 640 304c0-94.4-87.9-171.5-198.2-175.8c4.1 15.2 6.2 31.2 6.2 47.8l0 .6c87.2 6.7 144 67.5 144 127.4c0 28-11.4 54.9-32.7 77.2c-14.3 15-17.3 37.6-7.5 55.8c1.1 2 2.2 4 3.2 5.9c2.5 4.5 5.2 9 7.9 13.6c-17-4.5-33.9-10.7-49.9-18c-4.3-1.9-8.5-3.9-12.6-6c-9.5-4.8-20.3-6.2-30.7-4.2c-12.1 2.4-24.7 3.6-37.8 3.6c-61.7 0-110-26.5-136.8-62.3c-16 5.4-32.8 9.4-50 11.8C279 439.8 350 480 432 480z"/>
    	</g>  
	</symbol>
      <symbol id="search" viewBox="0 0 512 512">
        <g fill="currentColor">
          <path
            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
          />
        </g>
      </symbol>
      <symbol id="services" viewBox="0 0 576 512">
        <g fill="currentColor">
          <path
            d="M253.3 35.1c6.1-11.8 1.5-26.3-10.2-32.4s-26.3-1.5-32.4 10.2L117.6 192H32c-17.7 0-32 14.3-32 32s14.3 32 32 32L83.9 463.5C91 492 116.6 512 146 512H430c29.4 0 55-20 62.1-48.5L544 256c17.7 0 32-14.3 32-32s-14.3-32-32-32H458.4L365.3 12.9C359.2 1.2 344.7-3.4 332.9 2.7s-16.3 20.6-10.2 32.4L404.3 192H171.7L253.3 35.1zM192 304v96c0 8.8-7.2 16-16 16s-16-7.2-16-16V304c0-8.8 7.2-16 16-16s16 7.2 16 16zm96-16c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16s-16-7.2-16-16V304c0-8.8 7.2-16 16-16zm128 16v96c0 8.8-7.2 16-16 16s-16-7.2-16-16V304c0-8.8 7.2-16 16-16s16 7.2 16 16z"
          />
        </g>
      </symbol>
      <symbol id="profile" viewBox="0 0 512 512">
        <g fill="currentColor">
          <path
            d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"
          />
        </g>
      </symbol>
      <symbol id="arrow" viewBox="0 0 24 24">
        <g fill="currentColor">
          <path
            d="M10.59,4.044A1.091,1.091,0,0,0,9.047,2.5L.32,11.229a1.088,1.088,0,0,0,0,1.542L9.047,21.5a1.091,1.091,0,0,0,1.543-1.543L2.634,12Zm13.091,0A1.091,1.091,0,0,0,22.138,2.5L13.41,11.229a1.09,1.09,0,0,0,0,1.542L22.138,21.5a1.091,1.091,0,0,0,1.543-1.543L15.725,12Z"
          />
        </g>
      </symbol>
	<symbol id="lang" viewBox="0 0 512 512">
        <g fill="white">
          <path d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64H348.7c2.2 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0H18.6C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6H344.3c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352H135.3zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6H493.4z"/>
        </g>
      </symbol>
	<symbol id="liked_outline" viewBox="0 0 512 512">
        <g fill="#989898">
          <path d="M323.8 34.8c-38.2-10.9-78.1 11.2-89 49.4l-5.7 20c-3.7 13-10.4 25-19.5 35l-51.3 56.4c-8.9 9.8-8.2 25 1.6 33.9s25 8.2 33.9-1.6l51.3-56.4c14.1-15.5 24.4-34 30.1-54.1l5.7-20c3.6-12.7 16.9-20.1 29.7-16.5s20.1 16.9 16.5 29.7l-5.7 20c-5.7 19.9-14.7 38.7-26.6 55.5c-5.2 7.3-5.8 16.9-1.7 24.9s12.3 13 21.3 13L448 224c8.8 0 16 7.2 16 16c0 6.8-4.3 12.7-10.4 15c-7.4 2.8-13 9-14.9 16.7s.1 15.8 5.3 21.7c2.5 2.8 4 6.5 4 10.6c0 7.8-5.6 14.3-13 15.7c-8.2 1.6-15.1 7.3-18 15.2s-1.6 16.7 3.6 23.3c2.1 2.7 3.4 6.1 3.4 9.9c0 6.7-4.2 12.6-10.2 14.9c-11.5 4.5-17.7 16.9-14.4 28.8c.4 1.3 .6 2.8 .6 4.3c0 8.8-7.2 16-16 16H286.5c-12.6 0-25-3.7-35.5-10.7l-61.7-41.1c-11-7.4-25.9-4.4-33.3 6.7s-4.4 25.9 6.7 33.3l61.7 41.1c18.4 12.3 40 18.8 62.1 18.8H384c34.7 0 62.9-27.6 64-62c14.6-11.7 24-29.7 24-50c0-4.5-.5-8.8-1.3-13c15.4-11.7 25.3-30.2 25.3-51c0-6.5-1-12.8-2.8-18.7C504.8 273.7 512 257.7 512 240c0-35.3-28.6-64-64-64l-92.3 0c4.7-10.4 8.7-21.2 11.8-32.2l5.7-20c10.9-38.2-11.2-78.1-49.4-89zM32 192c-17.7 0-32 14.3-32 32V448c0 17.7 14.3 32 32 32H96c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32H32z"/>
        </g>
      </symbol>
	<symbol id="liked_solid" viewBox="0 0 512 512">
        <g fill="#ffffff">
          <path d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z"/>
        </g>
      </symbol>
	<symbol id="back_arrow" viewBox="0 0 488 512">
        <g fill="black">
			<path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
		</g>
	</symbol>
	<symbol id="delete_icon" viewBox="0 0 488 512">	
		<g fill="red">
			<path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
		</g>
	</symbol>
	<symbol id="edit_icon" viewBox="0 0 512 512">	
		<g fill="skyblue">
			<path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
		</g>
	</symbol>
	</svg>
  	<script src="./js/snowfall.js"></script>
    <script src="./js/main.js"></script>
	<script src="./js/translate.js"></script>
	<script src="./js/particle.js"></script>
	<script>
    
	document.getElementById('logoutBtn').addEventListener('click', function() {
        // localStorage에서 splashShown 값을 false로 설정 (로그인 페이지의 스플래시 애니메이션 다시 보이게끔 함)
        localStorage.setItem('splashShown', 'false');
    });	  
	const writeBtn = document.getElementById('write_action_button');
	const gptBtn = document.getElementById('gpt_action_button');
	const currentUrl = window.location.href;
	window.onload = function() {
		// 허용할 URL 주소를 배열로 지정
		const allowedURLs = [
			// 'home.php',
			'board_list.php',
            'services.php',
            'living.php',
            'language.php',
            'entertain.php',
			// 필요한 만큼 URL을 추가
		];

		// 현재 URL이 허용 목록에 있는 경우에만 hidden 클래스를 제거하여 버튼을 표시
		const isAllowedURL = allowedURLs.some(url => currentUrl.includes(url));
		if (currentUrl.includes('home.php')) {
			gptBtn.classList.remove('hidden');
			writeBtn.classList.add('hidden');
		} else if (isAllowedURL) {
			gptBtn.classList.add('hidden');
			writeBtn.classList.remove('hidden');
		} else {
			gptBtn.classList.add('hidden');
			writeBtn.classList.add('hidden');
		}
	};
        
          document.addEventListener('DOMContentLoaded', function () {
    var searchButton = document.getElementById('searchButton');
    var searchInput = document.getElementById('searchInput');

    searchButton.addEventListener('click', function () {
      searchInput.classList.toggle('hidden');
      if (!searchInput.classList.contains('hidden')) {
        // 검색창이 나타나면 input에 포커스를 줍니다.
        searchInput.querySelector('input').focus();
      }
    });

    var executeSearchButton = document.getElementById('executeSearch');
    executeSearchButton.addEventListener('click', function () {
      // 여기에 실제 검색을 실행하는 로직을 추가하세요.
      // alert('Searching...'); // 예시로 경고창을 띄웠습니다. 실제로는 검색 로직을 실행하세요.
        var searchTerm = searchInput.querySelector('input').value;

      // 검색 결과 페이지로 리다이렉션합니다.
      window.location.href = '/search.php?q=' + encodeURIComponent(searchTerm);
    });
  });

	</script>
  </body>
</html>

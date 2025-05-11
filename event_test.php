<!DOCTYPE html>
<html>
<head>
    <title>Festivals</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/daisyui@1.3.6/dist/full.js"></script>
</head>
<body class="p-6">
<div class="language-selection">
    <form id="languageSelection" class="space-y-2">
        <div class="form-control">
            <label class="label cursor-pointer">
                <span class="label-text">Korean</span> 
                <input type="radio" id="korean" name="language" value="ko" class="radio">
            </label>
        </div>

        <div class="form-control">
            <label class="label cursor-pointer">
                <span class="label-text">Chinese</span> 
                <input type="radio" id="chinese" name="language" value="zh" class="radio">
            </label>
        </div>

        <div class="form-control">
            <label class="label cursor-pointer">
                <span class="label-text">English</span> 
                <input type="radio" id="english" name="language" value="en" class="radio" checked>
            </label>
        </div>

        <div class="form-control">
            <label class="label cursor-pointer">
                <span class="label-text">Japanese</span> 
                <input type="radio" id="japanese" name="language" value="ja" class="radio">
            </label>
        </div>
    </form>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Category Selection -->
    <select name="searchCate" id="searchCate" title="카테고리 선택" class="select select-bordered w-full max-w-xs">
        <option value="">카테고리</option>
		<option value="연인과함께">연인과함께</option>
		<option value="겨울">겨울</option>
		<option value="인생샷">인생샷</option>
		<option value="문화관광">문화관광</option>
		<option value="예술">예술</option>
	</select>
	<!-- Date Selection -->
	<select name="searchDate" id="searchDate" title="시기 선택" class="select select-bordered w-full max-w-xs">
	  <option value="">시기</option>
		<option value="A">개최중</option>
		<option value="B">개최예정</option>
		<option value="01">01월</option>
		<option value="02">02월</option>
		<option value="03">03월</option>
		<option value="04">04월</option>
		<option value="05">05월</option>
		<option value="06">06월</option>
		<option value="07">07월</option>
		<option value="08">08월</option>
		<option value="09">09월</option>
		<option value="10">10월</option>
		<option value="11">11월</option>
		<option value="12">12월</option>
	</select>
	<!-- Area Selection -->
	<select name="searchArea" id="searchArea" title="지역 선택">
	   <option value="">지역</option>
		<option value="1">서울</option>
		<option value="2">인천</option>
		<option value="3">대전</option>
		<option value="4">대구</option>
		<option value="5">광주</option>
		<option value="6">부산</option>
		<option value="7">울산</option>
		<option value="8">세종시</option>
		<option value="31">경기도</option>
		<option value="32">강원도</option>
		<option value="33">충청북도</option>
		<option value="34">충청남도</option>
		<option value="35">경상북도</option>
		<option value="36">경상남도</option>
		<option value="37">전라북도</option>
		<option value="38">전라남도</option>
		<option value="39">제주도</option>
</select>


</div>

<?php

$url = "https://korean.visitkorea.or.kr/kfes/list/wntyFstvlList.do"; // Replace with the URL you want to fetch

$options = [
    "http" => [
        "header" => "User-Agent: MyCrawler/1.0\r\n"
    ]
];

$context = stream_context_create($options);
$html = file_get_contents($url, false, $context);
// echo $html;
$doc = new DOMDocument();
// libxml_use_internal_errors(true);
$doc->loadHTML($html);

// Create a new DOMDocument instance and load HTML
// $doc = new DOMDocument();
// libxml_use_internal_errors(true);
// $doc->loadHTML($html);
// libxml_clear_errors();

$xpath = new DOMXPath($doc);

// Array to hold festival data
$festivals = [];

// Query for festival details
$festivalNodes = $xpath->query('//div[@class="other_festival_content"]');
foreach ($festivalNodes as $node) {
    $name = $xpath->query('.//strong', $node)->item(0)->nodeValue;
    $date = $xpath->query('.//div[@class="date"]', $node)->item(0)->nodeValue;
    $location = $xpath->query('.//div[@class="loc"]', $node)->item(0)->nodeValue;
    $festivals[] = [
        'name' => $name,
        'date' => $date,
        'location' => $location
    ];
}
foreach ($festivals as $festival) {
	echo $festival['name'];
}
// Now $festivals array contains all the festival information
?>


</body>
</html>
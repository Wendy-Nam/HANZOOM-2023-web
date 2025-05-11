<?php
session_start();
ob_start(); // Start output buffering
?>
<div class="mb-4">
  <select class="select select-bordered w-full max-w-xs" id="categoryFilter" onchange="filterCards()">
    <option disabled>Select a category</option>
    <option value="all" selected>All Categories</option>
    <option value="center">Center</option>
    <option value="language">Language</option>
    <option value="living">Living</option>
    <option value="education">Education</option>
    <option value="social">Social</option>
    <option value="job">Job</option>
    <option value="entertainment">Entertainment</option>
  </select>
</div>

<div id="cardContainer" class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 z-0"></div>
<style>
    .card {
        transition: transform 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card:hover {
        background-color: #f5ebff; /* Very light purple background on hover */
    }
</style>

<script>
// 카드 데이터를 JavaScript 배열에 저장
const cardsData = [
    {
        tag: 'center',
        title: 'Seoul Foreign Resident Center',
        contacts: [
            { type: 'tel', value: '02-2229-4900', icon: 'fas fa-phone' },
            { type: 'email', value: 'hotline@sfrc.seoul.kr', icon: 'fas fa-envelope' },
            { type: 'address', value: '40, Doshin-ro, Yeongdeungpo-gu, Seoul', icon: 'fas fa-map-marker-alt' }
        ],
        href: 'https://global.seoul.go.kr/web/cent/swgc/centInfoPage.do?cent_cd=02'
    },
    {
        tag: 'language',
        title: 'Conversational Korean & Computer Class',
        contacts: [
            { type: 'manager', value: 'Program Operation Department, Lee Jiyoon', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4923', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'living, mentoring',
        title: 'Seoul Life Mentoring for Foreign Residents',
        contacts: [
            { type: 'manager', value: 'Program Operation Department, Kim Sumin', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4904', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'living, education',
        title: 'Democratic Citizenship Education for Foreign Residents',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Kim Minseob', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4910', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'living, education',
        title: 'Media Education',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Lim Boram', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4906', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
	    {
        tag: 'education',
        title: 'Safety Education for Foreign Residents',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Lee Jiyoon', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4923', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'social, education',
        title: 'Social Integration Program (Korean Immigration & Integration Program, KIIP)',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Lee Eunju', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4909', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'social, education',
        title: 'Early Adaptation Program',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Lim Boram', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4906', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
    {
        tag: 'entertainment, education',
        title: 'Cultural Companion Class for Local & Foreign Residents',
        contacts: [
            { type: 'inquiries', value: 'Program Operation Department, Lim Boram', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4906', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    },
	{
        tag: 'job',
        title: 'Education of support facility personnels',
        contacts: [
            { type: 'inquiries', value: 'Business Operation Department, Lee Jiyoon', icon: 'fas fa-user' },
            { type: 'tel', value: '02-2229-4923', icon: 'fas fa-phone' }
        ],
        href: 'https://global.seoul.go.kr/web/educ/edos/educListPage.do'
    }
];


	
const tagEmojis = {
    'center': '🏢',
    'language': '🗣️',
    'living': '🏠',
    'education': '🎓',
    'social': '🤝',
    'job': '💼',
    'entertainment': '🎉',
    'mentoring': '👥'
};

function createTagBadges(tags) {
    return tags.split(', ').map(tag => {
        const emoji = tagEmojis[tag] || '';
        return `<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">${emoji} ${tag}</span>`;
    }).join('');
}

function createCard(cardData) {
    let contactHTML = '';
    cardData.contacts.forEach(contact => {
        contactHTML += `<p class="text-sm mb-2"><i class="${contact.icon} mr-1"></i>${contact.value}</p>`;
    });

    const tagBadges = createTagBadges(cardData.tag);

    return `
        <div class="card bg-white shadow-lg rounded-lg overflow-hidden z-0">
            <div class="p-4">
                <div class="mb-2">${tagBadges}</div>
                <h5 class="text-lg font-bold mb-2">${cardData.title}</h5>
                ${contactHTML}
                <a href="${cardData.href}" class="text-blue-500 hover:text-blue-700 text-sm">Learn More</a>
            </div>
        </div>
    `;
}
function filterCards() {
    const selectedCategory = document.getElementById('categoryFilter').value;
    const cardContainer = document.getElementById('cardContainer');
    cardContainer.innerHTML = ''; // Clear current cards

    cardsData
        .filter(card => selectedCategory === 'all' || card.tag.split(', ').includes(selectedCategory))
        .forEach(card => {
            cardContainer.innerHTML += createCard(card);
        });
}

// 페이지 로드 시 모든 카드를 불러옵니다.
filterCards();
</script>

<?php
$content = ob_get_clean(); // Store the output in $content
include("main.php");
?>

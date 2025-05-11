window.addEventListener("DOMContentLoaded", () => {
  const nav = new Nav("nav");
});

class Nav {
  constructor(qs) {
    this.el = document.querySelector(qs);
    this.expanded = true;
    this.expandBtn = null;
    this.timeout = null;
    this.init();
  }
  init() {
    this.expandBtn = this.el?.querySelector("[data-expand]");
    this.expandBtn?.addEventListener("click", this.toggleSize.bind(this));
  }
  toggleSize() {
    this.expanded = !this.expanded;
    this.el.setAttribute("data-expanded", this.expanded);
    this.expandBtn.setAttribute("aria-expanded", this.expanded);

    const label = this.expanded ? "Collapse" : "Expand";
    const timeoutValue = this.expanded ? 0 : 300;

    clearTimeout(this.timeout);
    this.timeout = setTimeout(() => {
      this.el.querySelector("[data-expand-label]").innerText = label;
    }, timeoutValue);
  }
}

function activateMenuItem(menuItemId) {
  const menuItems = document.querySelectorAll(".nav__item-box");
  menuItems.forEach((menuItem) => {
    menuItem.classList.remove("active");
  });

  const currentMenuItem = document.getElementById(menuItemId);
  currentMenuItem.classList.add("active");
}
var menu_url = [
  "home-link",
  "events-link",
  "services-link",
  "community-all-link",
  "community-lang-link",
  "community-living-link",
  "community-entertain-link",
];

var mobile_menu_url = [
  "events-mobile-link",
  "services-mobile-link",
  "home-mobile-link",
  "community-all-mobile-link",
  "profile-mobile-link",
];

// Function to activate menu items based on the current URL
function activateMenuItemByHref(href) {
  menu_url.forEach(function (elementId) {
    var element = document.getElementById(elementId);
    var elementHref = element.getAttribute("href");
	var currentHref = getCurrentPath();
    if (href.includes(elementHref)) {
      element.classList.add("active");
    } else {
      element.classList.remove("active");
    }
  });

  mobile_menu_url.forEach(function (elementId) {
    var element = document.getElementById(elementId);
    var elementHref = element.getAttribute("href");
    if (href.includes(elementHref)) {
      element.classList.add("active");
    } else {
      element.classList.remove("active");
    }
  });

  // Exception: If the URL includes "community," activate the "community-all-mobile-link"
  if (href.includes("language.php") || href.includes("board_list.php") || href.includes("living.php") || href.includes("entertain.php")) {
    var communityAllMobileLink = document.getElementById(
      "community-all-mobile-link"
    );
    if (communityAllMobileLink) {
      communityAllMobileLink.classList.add("active");
    }
  }
}

// Function to get the current URL's path
function getCurrentPath() {
  return window.location.pathname; // Use window.location.pathname to get the URL path
}

// Page load event listener
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = getCurrentPath();
  activateMenuItemByHref(currentPath);
});

// Click event listeners for menu items
menu_url.forEach(function (elementId) {
  var element = document.getElementById(elementId);
  element.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default link behavior
    var href = element.getAttribute("href");
    activateMenuItemByHref(href);
    window.location.href = href; // Navigate to the clicked URL
  });
});

mobile_menu_url.forEach(function (elementId) {
  var element = document.getElementById(elementId);
  element.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default link behavior
    var href = element.getAttribute("href");
    activateMenuItemByHref(href);
    window.location.href = href; // Navigate to the clicked URL
  });
});

// 언어 선택을 URL에 포함시키는 함수
function appendLanguageToUrl(language) {
  let currentUrl = new URL(window.location.href);
  currentUrl.searchParams.set('lang', language);
  window.history.pushState({}, '', currentUrl.href);
}

// URL 변경 감지 및 처리
window.onpopstate = function(event) {
  let currentLanguage = new URL(window.location.href).searchParams.get('lang');
  if (currentLanguage) {
    localStorage.setItem('selectedLanguage', currentLanguage);
    translatePageContent(currentLanguage);
  }
};

var language_menu = [
	'lang_en',
	'lang_cn',
	'lang_jp',
	'lang_kr',
	'lang_default'
];

 document.addEventListener("DOMContentLoaded", () => {
  // Load the saved language from localStorage
  const savedLanguage = localStorage.getItem('selectedLanguage');
  const savedFlagUrl = localStorage.getItem('selectedFlagUrl');
  if (savedLanguage && savedFlagUrl) {
    document.getElementById('selectedFlag').src = savedFlagUrl;
    activateLanguageMenu(savedLanguage);
  }

  // Event listeners for language dropdown items
  language_menu.forEach(itemId => {
    const element = document.getElementById(itemId);
    element.addEventListener('click', function() {
      const selectedLang = this.getAttribute('value');
      let flagIconUrl = '';
      switch(selectedLang) {
        case 'en':
          flagIconUrl = './svg/country/us.svg';
          break;
        case 'zh':
          flagIconUrl = './svg/country/cn.svg';
          break;
        case 'ja':
          flagIconUrl = './svg/country/jp.svg';
          break;
        case 'ko':
          flagIconUrl = './svg/country/kr.svg';
          break;
        // Add more cases as needed
        default:
          flagIconUrl = './svg/country/default.svg'; // Default flag icon URL
      }
      document.getElementById('selectedFlag').src = flagIconUrl;
	  localStorage.setItem('selectedLanguage', selectedLang);
	  localStorage.setItem('selectedFlagUrl', flagIconUrl);
    });
  });
});

function activateLanguageMenu(selectedLang) {
  language_menu.forEach(itemId => {
    const element = document.getElementById(itemId);
    if (element.getAttribute('value') === selectedLang) {
      element.classList.add('active');
    } else {
      element.classList.remove('active');
    }
  });
}

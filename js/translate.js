document.addEventListener('DOMContentLoaded', () => {
    const languageLinks = document.querySelectorAll('.language-menu a');

    languageLinks.forEach(link => {
      link.addEventListener('click', (event) => {
        event.preventDefault(); // 기본 링크 동작 방지

        const newLang = link.getAttribute('value');
        changeLanguage(newLang);
      });
    });

    function changeLanguage(newLang) {
      const url = new URL(window.location);
      url.searchParams.set('lang', newLang); // URL에서 'lang' 매개변수 변경
      window.location.href = url.href; // 변경된 URL로 이동
    }
});

// 언어 선택을 URL에 포함시키는 함수
function appendLanguageToUrl(language) {
  let currentUrl = new URL(window.location.href);
  currentUrl.searchParams.set('lang', localStorage.getItem('selectedLanguage'));
  window.history.pushState({}, '', currentUrl.href);
}


// 페이지 로딩 시 URL에서 언어 설정 추출 및 적용
document.addEventListener("DOMContentLoaded", () => {
  appendLanguageToUrl();
  let urlParams = new URLSearchParams(window.location.search);
  let currentLanguage = localStorage.getItem('selectedLanguage');
  // localStorage.setItem('selectedLanguage', currentLanguage);
  document.querySelectorAll('[data-translate]').forEach(element => {
    const pageLanguage = getLanguageFromURL(); // 언어 코드를 가져옴
	if (pageLanguage == 'none') {
		return;
	}
    translateText(element.textContent, pageLanguage)
        .then(translatedText => {
            element.textContent = translatedText;
        });
});

});

// 텍스트 번역 함수 (Google Cloud Translation API 사용)
async function translateText(text, targetLanguage) {
    try {
        const response = await fetch(`https://translation.googleapis.com/language/translate/v2?key=AIzaSyDY7coP08O_1uQVoRC2RDkd5cJt5qg5nTY`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                q: text,
                target: targetLanguage
            })
        });

        const data = await response.json();
        console.log(data); // 데이터를 콘솔에 출력
        return data.data.translations[0].translatedText;
    } catch (error) {
        console.error('Translation error:', error);
    }
}

function getLanguageFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const langCode = urlParams.get('lang');
	if (langCode == 'default' || langCode == '' || langCode == 'null') {
		return 'none';
	}
	return langCode;
    // // URL의 lang 매개변수를 ISO 639-1 표준에 맞춰서 매핑
    // switch(langCode) {
    //     case 'en':
    //         return 'en'; // 영어
    //     case 'zh':
    //         return 'zh'; // 중국어 (간체)
    //     case 'ko':
    //         return 'ko'; // 한국어
    //     case 'ja':
    //         return 'ja'; // 일본어
    //     default:
    //         return 'ko'; // 기본값은 영어
    // }
}

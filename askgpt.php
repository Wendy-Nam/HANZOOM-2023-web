<?php
session_start();
ob_start();
?>
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-semibold">ChatGPT Chatbot</h1>
    <!-- 대화창 -->
    <div class="mt-4 p-8 border bg-white rounded" id="chat" style="min-width: 70vw; max-height: 80vh; overflow-y: auto;">
    </div>
    <!-- 사용자 입력 폼 -->
    <form id="question-form" method="POST" class="mt-4 space-y-4 hidden" onsubmit="return false;">
    </form>
    <!-- Reset 버튼 -->
    <div class="mt-4 flex justify-center">
        <button type="button" onclick="resetChat()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Reset</button>
    </div>
</div>
<script>
    let conversation = [];
    let currentStep = 0;
	
    const languageOptions = ['English', 'Korean', 'Spanish', 'French', 'German', 'Chinese'];
    const interestsOptions = ['Living', 'Entertainment', 'Language', 'Technology', 'Travel'];

    function createSelectOptions(options) {
        let html = '<option value="">Select Option</option>';
        for (let option of options) {
            html += `<option value="${option}">${option}</option>`;
        }
        return html;
    }

    const steps = [
        {
            title: 'Language Selection',
            content: 'GPT: Please select a language:',
            input: `<select id="language" name="language" class="flex-1 p-2 border rounded">${createSelectOptions(languageOptions)}</select>`,
            inputName: 'language',
            buttons: [
                { label: 'Next', action: 'next' , id: 'step1'}
            ]
        },
        {
            title: 'Stay Duration',
            content: 'GPT: How long is your stay duration?',
            input: '<input type="text" id="stay_duration" name="stay_duration" class="w-full p-2 border rounded" placeholder="e.g., 3 months">',
            inputName: 'stay_duration',
            buttons: [
                { label: 'Next', action: 'next' , id: 'step2'}
            ]
        },
        {
            title: 'Future Stay Duration',
            content: 'GPT: What is your future stay duration?',
            input: '<input type="text" id="future_duration" name="future_duration" class="w-full p-2 border rounded" placeholder="e.g., 6 months">',
            inputName: 'future_duration',
            buttons: [
                { label: 'Next', action: 'next' ,id: 'step3'}
            ]
        },
        {
            title: 'Interests',
            content: 'GPT: What are your interests?',
            input: `<select id="interests" name="interests" class="flex-1 p-2 border rounded">${createSelectOptions(interestsOptions)}</select>`,
            inputName: 'interests',
            buttons: [
                { label: 'Next', action: 'next' , id: 'step4'}
            ]
        },
        {
            title: 'Ask your question',
            content: 'GPT: Now you can ask your question. Type your question below:',
            input: '<textarea id="question" name="question" class="w-full p-2 border rounded" placeholder="Your Question"></textarea>',
            inputName: 'question',
            buttons: [
                { label: 'Submit', action: 'submitForm', id: 'questionBtn'}
            ]
        }
    ];

    function updateChat() {
		const chat = document.getElementById('chat');
		chat.innerHTML = ''; // 채팅창 초기화
		conversation.forEach(item => {
			chat.innerHTML += item; // 대화 기록 추가
		});
    	chat.scrollTop = chat.scrollHeight;
	}


    function nextStep() {
        if (currentStep < steps.length) {
            const step = steps[currentStep];
            const form = document.getElementById('question-form');
            form.innerHTML = '';

            conversation.push(`
                <div class="chat chat-start">
                    <div class="chat-bubble">${step.content}</div>
                </div>
            `);
            if (step.input) {
                form.innerHTML += step.input;
                step.buttons.forEach(button => {
                    form.innerHTML += `<button type="button" id=${button.id} onclick="handleButtonClick('${button.action}')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">${button.label}</button>`;
                });
                form.classList.remove('hidden');
            }
            updateChat();
        }
    }

    function handleButtonClick(action) {
        if (action === 'submitForm') {
            submitForm();
            return;
        }
        const formData = new FormData(document.getElementById('question-form'));
        const input = formData.get(steps[currentStep].inputName);
        addChatBubble('You: ' + input, false); // You 입력을 챗 버블로 추가
        currentStep++;
        nextStep();
    }

    function resetChat() {
        conversation = [];
        currentStep = 0;
        document.getElementById('chat').innerHTML = '';
        document.getElementById('question-form').innerHTML = '';
        document.getElementById('question-form').classList.add('hidden');
        nextStep();
    }

function submitForm() {
    const formData = new FormData(document.getElementById('question-form'));
    const question = formData.get('question');
    addChatBubble('You: ' + question, false); // Add user's question as a chat bubble
    // Add a chat bubble with loading animation for the chatbot's response
	addChatBubble('<span class="loading loading-dots loading-md"></span>', true);

    const submitButton = document.getElementById("questionBtn");
    if (submitButton) {
        submitButton.innerHTML = '<span class="loading loading-spinner loading-md"></span>';
        submitButton.disabled = true;
    }

    fetch('askgpt_api.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
         // Update the chat bubble with the response
		updateChatBubbleWithResponse(data);
		// Reset the submit button
		if (submitButton) {
			submitButton.innerHTML = 'Submit';
			submitButton.disabled = false;
		}
    })
    .catch(error => {
        updateChatBubbleWithResponse({error: error.toString()}); // Handle errors
        submitButton.innerHTML = 'Submit';
        submitButton.disabled = false;
    });

    // Clear the question field
    document.getElementById('question').value = '';
}

function updateChatBubbleWithResponse(data) {
	const lastBubble = document.querySelector("#chat .chat.chat-start:last-child .chat-bubble");
	if (data.error) {
		lastBubble.innerHTML = 'GPT: ' + data.error;
	} else {
		lastBubble.innerHTML = 'GPT: ' + data.answer; // Update the last bubble with the chatbot's response
	}
}
	
	function addChatBubble(content, isBot) {
		const bubbleId = 'bubble-' + conversation.length; // Generate a unique ID
		const chatClass = isBot ? 'chat chat-start' : 'chat chat-end';
		const bubbleClass = isBot ? 'chat-bubble' : 'chat-bubble bg-orange-500';
		const bubbleContent = `<div id="${bubbleId}" class="${chatClass}"><div class="${bubbleClass}">${content}</div></div>`;

		conversation.push(bubbleContent);
		updateChat();
	}
    nextStep();
</script>
<?php
$content = ob_get_clean();
include('main.php');
?>

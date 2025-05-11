<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $language = isset($_POST["language"]) ? $_POST["language"] : 'N/A';
    $stay_duration = isset($_POST["stay_duration"]) ? $_POST["stay_duration"] : 'N/A';
    $future_duration = isset($_POST["future_duration"]) ? $_POST["future_duration"] : 'N/A';
    $interests = isset($_POST["interests"]) ? $_POST["interests"] : 'N/A';
    $question = isset($_POST["question"]) ? $_POST["question"] : 'N/A';

    // Construct the data to send in the request
    $requestData = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a helpful assistant.'
            ],
            [
                'role' => 'user',
                'content' => "Language: $language\nCurrent Stay Duration: $stay_duration\nFuture Stay Duration: $future_duration\nInterests: $interests\nQuestion: $question"
            ]
        ]
    ];

    // Encode the data as JSON
    $jsonData = json_encode($requestData);

    // Set up options for the HTTP context
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => [
                'Content-Type: application/json',
                'Authorization: ', // API 키
            ],
            'content' => $jsonData
        ]
    ];

    // Create a stream context
    $context = stream_context_create($options);

    // Make the API request using file_get_contents
    $result = file_get_contents('https://api.openai.com/v1/chat/completions', false, $context);

    // Check for errors
    if ($result === false) {
        $error = error_get_last();
        echo json_encode(['error' => 'API request failed: ' . $error['message']]);
    } else {
        // Decode the API response
        $response = json_decode($result, true);

        // Check for errors in the response
        if (isset($response['error'])) {
            echo json_encode(['error' => $response['error']['message']]);
        } else {
            // Get the ChatGPT answer
            $GPT_ANSWER = $response['choices'][0]['message']['content'];

            // Return the ChatGPT answer as JSON
            echo json_encode(['answer' => $GPT_ANSWER]);
        }
    }
}
?>

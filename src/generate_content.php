<?php

if(isset($_POST['prompt']) && !empty($_POST['prompt'])){

    $prompt = $_POST['prompt'];

    //create api key in Google Ai Studio (Gemini) and put it here inside $apiKey variable
    $apiKey = "";

    // Google Ai Studio (Gemini)
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=".$apiKey;
    
    $data = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ]
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/json",
            "method" => "POST",
            "content" => json_encode($data),
            "ignore_errors" => true
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if($response === FALSE){
        echo "Request Failed!";
        print_r(error_get_last());
        exit;
    }

    $result = json_decode($response, true);

    // Handle errors
    if(isset($result['error'])){
        echo "API Error: " . $result['error']['message'];
        exit;
    }

    // Correct Gemini response parsing
    if(isset($result['candidates'][0]['content']['parts'][0]['text'])){
        echo $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        echo "Unexpected Response:";
        print_r($result);
    }

} else {
    echo "Prompt is empty!";
}
?>
